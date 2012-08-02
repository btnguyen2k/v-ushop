<?php
abstract class Vushop_Bo_Catalog_BaseCatalogDao extends Quack_Bo_BaseDao implements 
        Vushop_Bo_Catalog_ICatalogDao {
    
    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;
    
    const PARAM_SORTING_FIELD = 'sortingField';
    const PARAM_SORTING = 'sorting';
    const PARAM_CATEGORY_IDS = 'categoryIds';
    const PARAM_OWNER_ID = 'owner_id';
    const PARAM_START_OFFSET = 'startOffset';
    const PARAM_PAGE_SIZE = 'pageSize';
    
    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see Quack_Bo_BaseDao::getCacheName()
     */
    public function getCacheName() {
        return 'ICatalogDao';
    }
    
    protected function createCacheKeyCat($catId) {
        return 'CATEGORY_' . $catId;
    }
    
    protected function createCacheKeyCatChidren($catId) {
        return 'CATEGORY_CHILDREN_' . $catId;
    }
    
    protected function createCacheKeyCatCount() {
        return 'CATEGORY_COUNT';
    }
    
    protected function createCacheKeyCatTree() {
        return 'CATEGORY_TREE';
    }
    
    private function getAllCategoryIds() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        $rows = $this->execSelect($sqlStm);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $result[] = $row[Vushop_Bo_Catalog_BoCategory::COL_ID];
            }
        }
        return $result;
    }
    
    /**
     * Invalidates the category cache due to change.
     *
     * @param Vushop_Bo_Catalog_BoCategory $cat
     */
    protected function invalidateCategoryCache($cat = NULL) {
        $catIds = $this->getAllCategoryIds();
        foreach ($catIds as $catId) {
            $cacheKey = $this->createCacheKeyCat($catId);
            $this->deleteFromCache($cacheKey);
            $cacheKey = $this->createCacheKeyCatChidren($catId);
            $this->deleteFromCache($cacheKey);
        }
        $this->deleteFromCache($this->createCacheKeyCatCount());
        $this->deleteFromCache($this->createCacheKeyCatTree());
    }
    
    protected function createCacheKeyItem($itemId) {
        return 'ITEM_' . $itemId;
    }
    
    protected function createCacheKeyAllItems() {
        return 'ITEM_ALL';
    }
    
    protected function createCacheKeyHotItems() {
        return 'ITEM_HOT';
    }
    
    protected function createCacheKeyItemCount() {
        return 'ITEM_COUNT';
    }
    
    /**
     * Invalidates the item cache due to change.
     *
     * @param Vushop_Bo_Catalog_BoItem $item
     */
    protected function invalidateItemCache($item = NULL) {
        if ($item !== NULL) {
            $itemId = $item->getId();
            $cacheKey = $this->createCacheKeyItem($itemId);
            $this->deleteFromCache($cacheKey);
        }
        $this->deleteFromCache($this->createCacheKeyAllItems());
        $this->deleteFromCache($this->createCacheKeyHotItems());
        $this->deleteFromCache($this->createCacheKeyItemCount());
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::countNumCategories()
     */
    public function countNumCategories() {
        $cacheKey = $this->createCacheKeyCatCount();
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $result = $this->execCount($sqlStm);
        }
        return $this->returnCachedResult($result, $cacheKey);
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::createCategory()
     */
    public function createCategory($category) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Catalog_BoCategory::COL_POSITION => $category->getPosition(), 
                Vushop_Bo_Catalog_BoCategory::COL_PARENT_ID => $category->getParentId(), 
                Vushop_Bo_Catalog_BoCategory::COL_TITLE => $category->getTitle(), 
                Vushop_Bo_Catalog_BoCategory::COL_DESCRIPTION => $category->getDescription(), 
                Vushop_Bo_Catalog_BoCategory::COL_IMAGE_ID => $category->getImageId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCategoryCache();
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::deleteCategory()
     */
    public function deleteCategory($category) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Catalog_BoCategory::COL_ID => $category->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCategoryCache($category);
        
        // delete the attachment too!
        $paperclipId = $category->getImageId();
        $paperclipDao = $this->getDaoFactory()->getDao(DAO_PAPERCLIP);
        $paperclipItem = $paperclipDao->getAttachment($paperclipId);
        if ($paperclipItem !== NULL) {
            $paperclipDao->deleteAttachment($paperclipItem);
        }
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::getCategoryById()
     */
    public function getCategoryById($id) {
        $cacheKey = $this->createCacheKeyCat($id);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_Catalog_BoCategory::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Vushop_Bo_Catalog_BoCategory();
                $result->populate($rows[0]);
            }
            if ($result !== NULL) {
                $children = $this->getCategoryChildren($result);
                $result->setChildren($children);
            
            }
        
        }
        return $this->returnCachedResult($result, $cacheKey);
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::getCategoryChildren()
     */
    public function getCategoryChildren($category) {
        if ($category === NULL) {
            return Array();
        }
        $catId = $category->getId();
        $cacheKey = $this->createCacheKeyCatChidren($catId);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $result = Array();
            $params = Array(Vushop_Bo_Catalog_BoCategory::COL_PARENT_ID => $category->getId());
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                foreach ($rows as $row) {
                    $catId = $row[Vushop_Bo_Catalog_BoCategory::COL_ID];
                    $category = $this->getCategoryById($catId);
                    $result[] = $category;
                }
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::getCategoryTree()
     */
    public function getCategoryTree() {
        $cacheKey = $this->createCacheKeyCatTree();
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $result = Array();
            $rows = $this->execSelect($sqlStm);
            if ($rows !== NULL && count($rows) > 0) {
                foreach ($rows as $row) {
                    $catId = (int)$row[Vushop_Bo_Catalog_BoCategory::COL_ID];
                    $category = $this->getCategoryById($catId);
                    $result[] = $category;
                }
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::updateCategory()
     */
    public function updateCategory($category) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Catalog_BoCategory::COL_ID => $category->getId(), 
                Vushop_Bo_Catalog_BoCategory::COL_POSITION => $category->getPosition(), 
                Vushop_Bo_Catalog_BoCategory::COL_PARENT_ID => $category->getParentId(), 
                Vushop_Bo_Catalog_BoCategory::COL_TITLE => $category->getTitle(), 
                Vushop_Bo_Catalog_BoCategory::COL_DESCRIPTION => $category->getDescription(), 
                Vushop_Bo_Catalog_BoCategory::COL_IMAGE_ID => $category->getImageId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCategoryCache($category);
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::countNumItems()
     */
    public function countNumItems($featuredItems = FEATURED_ITEM_NONE) {
        // $cacheKey = $this->createCacheKeyItemCount();
        switch ($featuredItems) {
            case FEATURED_ITEM_HOT:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredHotOnly');
                break;
            case FEATURED_ITEM_NEW:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredNewOnly');
                break;
            case FEATURED_ITEM_ALL:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredOnly');
                break;
            default:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        }
        // $result = $this->execCount($sqlStm, NULL, NULL, $cacheKey);
        $result = $this->execCount($sqlStm);
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::countNumItems()
     */
    public function countNumItemsForShop($ownerId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::PARAM_OWNER_ID => $ownerId);
        // $result = $this->execCount($sqlStm, NULL, NULL, $cacheKey);
        $result = $this->execCount($sqlStm, $params);
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::countNumItemsForCategory()
     */
    public function countNumItemsForCategory($cat, $featuredItems = FEATURED_ITEM_NONE) {
        switch ($featuredItems) {
            case FEATURED_ITEM_HOT:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredHotOnly');
                break;
            case FEATURED_ITEM_NEW:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredNewOnly');
                break;
            case FEATURED_ITEM_ALL:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredOnly');
                break;
            default:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        }
        $result = Array();
        // count items within this category and its children too
        $params = $this->getCategoryTreeIds($cat);
        $params = Array(self::PARAM_CATEGORY_IDS => $params);
        $result = $this->execCount($sqlStm, $params);
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::countNumItemsForCategoryForShop()
     */
    public function countNumItemsForCategoryShop($cat, $ownerId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        // count items within this category and its children too
        $params = $this->getCategoryTreeIds($cat);
        $params = Array(self::PARAM_CATEGORY_IDS => $params, self::PARAM_OWNER_ID => $ownerId);
        $result = $this->execCount($sqlStm, $params);
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::createItem()
     */
    public function createItem($item) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Catalog_BoItem::COL_CATEGORY_ID => $item->getCategoryId(), 
                Vushop_Bo_Catalog_BoItem::COL_TITLE => $item->getTitle(), 
                Vushop_Bo_Catalog_BoItem::COL_DESCRIPTION => $item->getDescription(), 
                Vushop_Bo_Catalog_BoItem::COL_VENDOR => $item->getVendor(), 
                Vushop_Bo_Catalog_BoItem::COL_CODE => $item->getCode(), 
                Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP => $item->getTimestamp(), 
                Vushop_Bo_Catalog_BoItem::COL_PRICE => $item->getPrice(), 
                Vushop_Bo_Catalog_BoItem::COL_OLD_PRICE => $item->getOldPrice(), 
                Vushop_Bo_Catalog_BoItem::COL_STOCK => $item->getStock(), 
                Vushop_Bo_Catalog_BoItem::COL_IMAGE_ID => $item->getImageId(), 
                Vushop_Bo_Catalog_BoItem::COL_HOT_ITEM => $item->isHotItem() ? 1 : 0, 
                Vushop_Bo_Catalog_BoItem::COL_NEW_ITEM => $item->isNewItem() ? 1 : 0, 
                Vushop_Bo_Catalog_BoItem::COL_OWNER_ID => $item->getOwnerId(), 
                Vushop_Bo_Catalog_BoItem::COL_ACTIVE => $item->isActive() ? 1 : 0);
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateItemCache();
        
        $item = $this->getItemJustCreated($item->getTimestamp(), $item->getTitle());
        $this->updateIndexItem($item);
        return $item;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::deleteItem()
     */
    public function deleteItem($item) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Catalog_BoItem::COL_ID => $item->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateItemCache($item);
        
        // delete the attachment too!
        $paperclipId = $item->getImageId();
        $paperclipDao = $this->getDaoFactory()->getDao(DAO_PAPERCLIP);
        $paperclipItem = $paperclipDao->getAttachment($paperclipId);
        if ($paperclipItem !== NULL) {
            $paperclipDao->deleteAttachment($paperclipItem);
        }
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::getAllItems()
     */
    public function getAllItems($pageNum = 1, $pageSize = PHP_INT_MAX, $itemSorting = DEFAULT_ITEM_SORTING, $featuredItems = FEATURED_ITEM_NONE) {
        switch ($featuredItems) {
            case FEATURED_ITEM_HOT:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredHotOnly');
                break;
            case FEATURED_ITEM_NEW:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredNewOnly');
                break;
            case FEATURED_ITEM_ALL:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredOnly');
                break;
            default:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        }
        $params = Array(self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize, 
                self::PARAM_PAGE_SIZE => $pageSize);
        switch ($itemSorting) {
            case ITEM_SORTING_TITLE:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TITLE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEDESC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
                break;
            case ITEM_SORTING_TIMEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            default:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
        }
        $result = Array();
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[Vushop_Bo_Catalog_BoItem::COL_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::getAllItems()
     */
    public function getAllItemsForShop($ownerId, $pageNum = 1, $pageSize = PHP_INT_MAX, $itemSorting = DEFAULT_ITEM_SORTING) {
        
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize, 
                self::PARAM_PAGE_SIZE => $pageSize, 
                self::PARAM_OWNER_ID => $ownerId);
        
        switch ($itemSorting) {
            case ITEM_SORTING_TITLE:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TITLE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEDESC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
                break;
            case ITEM_SORTING_TIMEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            default:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
        }
        $result = Array();
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[Vushop_Bo_Catalog_BoItem::COL_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        return $result;
    }
    
    /**
     * Gets the item that has just been created.
     *
     * @param int $timestamp
     * @param string $title
     * @return Vushop_Bo_Catalog_BoItem
     */
    protected function getItemJustCreated($timestamp, $title) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $itemId = 0;
        $params = Array(Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP => $timestamp, 
                Vushop_Bo_Catalog_BoItem::COL_TITLE => $title);
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            $itemId = $rows[0][Vushop_Bo_Catalog_BoItem::COL_ID];
        }
        return $this->getItemById($itemId);
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::getItemById()
     */
    public function getItemById($id) {
        $cacheKey = $this->createCacheKeyItem($id);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_Catalog_BoItem::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Vushop_Bo_Catalog_BoItem();
                $result->populate($rows[0]);
            }
            if ($result !== NULL) {
                $cat = $this->getCategoryById($result->getCategoryId());
                $result->setCategory($cat);
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::getItemsForCategory()
     */
    public function getItemsForCategory($cat, $pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE, $itemSorting = DEFAULT_ITEM_SORTING, $featuredItems = FEATURED_ITEM_NONE) {
        if ($cat === NULL) {
            return Array();
        }
        switch ($featuredItems) {
            case FEATURED_ITEM_HOT:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredHotOnly');
                break;
            case FEATURED_ITEM_NEW:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredNewOnly');
                break;
            case FEATURED_ITEM_ALL:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredOnly');
                break;
            default:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        }
        $result = Array();
        // get all items within this category and its children too
        $params = $this->getCategoryTreeIds($cat);
        $params = Array(self::PARAM_CATEGORY_IDS => $params, 
                self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize, 
                self::PARAM_PAGE_SIZE => $pageSize);
        switch ($itemSorting) {
            case ITEM_SORTING_TITLE:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TITLE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEDESC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
                break;
            case ITEM_SORTING_TIMEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            default:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
        }
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[Vushop_Bo_Catalog_BoItem::COL_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::getItemsForShopCategory()
     */
    public function getItemsForCategoryShop($cat, $ownerId, $pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE, $itemSorting = DEFAULT_ITEM_SORTING) {
        if ($cat === NULL) {
            return Array();
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        // get all items within this category and its children too
        $params = $this->getCategoryTreeIds($cat);
        $params = Array(self::PARAM_CATEGORY_IDS => $params, 
                self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize, 
                self::PARAM_PAGE_SIZE => $pageSize, 
                self::PARAM_OWNER_ID => $ownerId);
        
        switch ($itemSorting) {
            case ITEM_SORTING_TITLE:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TITLE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEDESC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
                break;
            case ITEM_SORTING_TIMEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            default:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vushop_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
        }
        
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[Vushop_Bo_Catalog_BoItem::COL_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        return $result;
    }
    
    private function buildSearchParams($searchQuery, $searchType, $cat) {
        $tokens = preg_split(WORD_SPLIT_PATTERN, strip_tags($searchQuery));
        $searchTerms = Array();
        foreach ($tokens as $token) {
            if (mb_strlen($token) > 2) {
                $temp = mb_strtolower($token, 'UTF-8');
                $searchTerms[$temp] = 1;
            }
        }
        
        if (count($searchTerms) === 0) {
            // no or empty search tearm(s), thus no search should be performed
            return NULL;
        }
        
        $paramSearchTerms = array_keys($searchTerms);
        
        $paramCats = Array();
        if ($cat !== NULL) {
            $paramCats[] = $cat->getId();
            foreach ($cat->getChildren() as $child) {
                $paramCats[] = $child->getId();
            }
        }
        
        switch ($searchType) {
            case 0:
                $paramSearchTypes = Array(0);
                break;
            case 1:
                $paramSearchTypes = Array(0);
                break;
            default:
                $paramSearchTypes = Array(0, 1);
                break;
        }
        
        // build the final parameters and return
        $params = Array('searchTypes' => $paramSearchTypes, 
                'tags' => $paramSearchTerms, 
                self::PARAM_CATEGORY_IDS => $paramCats);
        return $params;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::countSearchItems()
     */
    public function countSearchItems($searchQuery, $searchType = 2, $cat = NULL) {
        $params = $this->buildSearchParams($searchQuery, $searchType, $cat);
        if ($params === NULL) {
            return 0;
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . (count($params[self::PARAM_CATEGORY_IDS]) === 0 ? 'NoCategory' : 'Category'));
        return $this->execCount($sqlStm, $params);
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::searchItems()
     */
    public function searchItems($searchQuery, $searchType = 2, $cat = NULL, $pageNum = 1, $pageSize = 10) {
        $params = $this->buildSearchParams($searchQuery, $searchType, $cat);
        if ($params === NULL) {
            return Array();
        }
        
        $pageNum = (int)$pageNum;
        if ($pageNum < 1) {
            $pageNum = 1;
        }
        $pageSize = (int)$pageSize;
        if ($pageSize < 1) {
            $pageSize = 1;
        }
        $params['startOffset'] = ($pageNum - 1) * $pageSize;
        $params['pageSize'] = $pageSize;
        
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . (count($params[self::PARAM_CATEGORY_IDS]) === 0 ? 'NoCategory' : 'Category'));
        $result = Array();
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[Vushop_Bo_Catalog_BoItem::COL_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Catalog_ICatalogDao::updateItem()
     */
    public function updateItem($item) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Catalog_BoItem::COL_ID => $item->getId(), 
                Vushop_Bo_Catalog_BoItem::COL_ACTIVE => $item->isActive() ? 1 : 0, 
                Vushop_Bo_Catalog_BoItem::COL_CATEGORY_ID => $item->getCategoryId(), 
                Vushop_Bo_Catalog_BoItem::COL_TITLE => $item->getTitle(), 
                Vushop_Bo_Catalog_BoItem::COL_DESCRIPTION => $item->getDescription(), 
                Vushop_Bo_Catalog_BoItem::COL_VENDOR => $item->getVendor(), 
                Vushop_Bo_Catalog_BoItem::COL_CODE => $item->getCode(), 
                Vushop_Bo_Catalog_BoItem::COL_PRICE => $item->getPrice(), 
                Vushop_Bo_Catalog_BoItem::COL_OLD_PRICE => $item->getOldPrice(), 
                Vushop_Bo_Catalog_BoItem::COL_STOCK => $item->getStock(), 
                Vushop_Bo_Catalog_BoItem::COL_IMAGE_ID => $item->getImageId(), 
                Vushop_Bo_Catalog_BoItem::COL_HOT_ITEM => $item->isHotItem() ? 1 : 0, 
                Vushop_Bo_Catalog_BoItem::COL_NEW_ITEM => $item->isNewItem() ? 1 : 0);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateItemCache($item);
        $this->updateIndexItem($item);
        return $result;
    }
    
    private function updateIndexItem($item) {
        $this->deleteIndexItem($item);
        
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        
        $params = Array(Vushop_Bo_Catalog_BoItem::COL_ID => $item->getId());
        $params['type'] = 0;
        $tokens = preg_split(WORD_SPLIT_PATTERN, strip_tags($item->getTitle()));
        $tags = Array();
        foreach ($tokens as $token) {
            $token = mb_strtolower($token, 'UTF-8');
            $tags[$token] = 1;
        }
        foreach ($tags as $tag => $dummy) {
            if (mb_strlen($tag) > 2) {
                $params['tag'] = $tag;
                $this->execNonSelect($sqlStm, $params);
            }
        }
        
        $params['type'] = 1;
        $tokens = preg_split(WORD_SPLIT_PATTERN, strip_tags($item->getDescription()));
        $tags = Array();
        foreach ($tokens as $token) {
            $token = mb_strtolower($token, 'UTF-8');
            $tags[$token] = 1;
        }
        foreach ($tags as $tag => $dummy) {
            if (mb_strlen($tag) > 2) {
                $params['tag'] = $tag;
                $this->execNonSelect($sqlStm, $params);
            }
        }
    }
    
    private function deleteIndexItem($item) {
        if ($item === NULL) {
            return;
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Catalog_BoItem::COL_ID => $item->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    }
    
    private function getCategoryTreeIds($cat) {
        $result = Array($cat->getId());
        foreach ($cat->getChildren() as $child) {
            $childrenIds = $this->getCategoryTreeIds($child);
            $result = array_merge($result, $childrenIds);
        }
        return $result;
    }
}
