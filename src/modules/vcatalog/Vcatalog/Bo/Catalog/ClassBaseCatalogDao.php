<?php
abstract class Vcatalog_Bo_Catalog_BaseCatalogDao extends Quack_Bo_BaseDao implements
        Vcatalog_Bo_Catalog_ICatalogDao {

    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    const PARAM_SORTING_FIELD = 'sortingField';
    const PARAM_SORTING = 'sorting';
    const PARAM_CATEGORY_IDS = 'categoryIds';
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
                $result[] = $row[Vcatalog_Bo_Catalog_BoCategory::COL_ID];
            }
        }
        return $result;
    }

    /**
     * Invalidates the category cache due to change.
     *
     * @param Vcatalog_Bo_Catalog_BoCategory $cat
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
     * @param Vcatalog_Bo_Catalog_BoItem $item
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
     * @see Vcatalog_Bo_Catalog_ICatalogDao::countNumCategories()
     */
    public function countNumCategories() {
        $cacheKey = $this->createCacheKeyCatCount();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = $this->execCount($sqlStm, NULL, NULL, $cacheKey);
        return (int)$result;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::createCategory()
     */
    public function createCategory($position, $parentId, $title, $description, $imageId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vcatalog_Bo_Catalog_BoCategory::COL_POSITION => $position,
                Vcatalog_Bo_Catalog_BoCategory::COL_PARENT_ID => $parentId,
                Vcatalog_Bo_Catalog_BoCategory::COL_TITLE => $title,
                Vcatalog_Bo_Catalog_BoCategory::COL_DESCRIPTION => $description,
                Vcatalog_Bo_Catalog_BoCategory::COL_IMAGE_ID => $imageId);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCategoryCache();
        return $result;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::deleteCategory()
     */
    public function deleteCategory($category) {
        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();

        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vcatalog_Bo_Catalog_BoCategory::COL_ID => $category->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCategoryCache($category);

        // delete the attachment too!
        $paperclipId = $category->getImageId();
        $paperclipDao = $this->getDaoFactory()->getDao(DAO_PAPERCLIP);
        $paperclipItem = $paperclipDao->getAttachment($paperclipId);
        if ($paperclipItem !== NULL) {
            $paperclipDao->deleteAttachment($paperclipItem);
        }

        $this->closeConnection();
        return $result;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryById()
     */
    public function getCategoryById($id) {
        $cacheKey = $this->createCacheKeyCat($id);
        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vcatalog_Bo_Catalog_BoCategory::COL_ID => $id);
        $rows = $this->execSelect($sqlStm, $params, $conn->getConn(), $cacheKey);
        if ($rows !== NULL && count($rows) > 0) {
            $category = new Vcatalog_Bo_Catalog_BoCategory();
            $category->populate($rows[0]);
        } else {
            $category = NULL;
        }
        if ($category !== NULL) {
            $children = $this->getCategoryChildren($category);
            $category->setChildren($children);
        }
        $this->closeConnection();
        return $category;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryChildren()
     */
    public function getCategoryChildren($category) {
        if ($category === NULL) {
            return Array();
        }
        $catId = $category->getId();
        $cacheKey = $this->createCacheKeyCatChidren($catId);
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        $params = Array(Vcatalog_Bo_Catalog_BoCategory::COL_PARENT_ID => $category->getId());
        $rows = $this->execSelect($sqlStm, $params, NULL, $cacheKey);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $catId = (int)($row[Vcatalog_Bo_Catalog_BoCategory::COL_ID]);
                $category = $this->getCategoryById($catId);
                $result[] = $category;
            }
        }
        return $result;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryTree()
     */
    public function getCategoryTree() {
        $cacheKey = $this->createCacheKeyCatTree();
        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        $rows = $this->execSelect($sqlStm, NULL, $conn->getConn(), $cacheKey);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $catId = (int)$row[Vcatalog_Bo_Catalog_BoCategory::COL_ID];
                $category = $this->getCategoryById($catId);
                $result[] = $category;
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::updateCategory()
     */
    public function updateCategory($category) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vcatalog_Bo_Catalog_BoCategory::COL_ID => $category->getId(),
                Vcatalog_Bo_Catalog_BoCategory::COL_POSITION => $category->getPosition(),
                Vcatalog_Bo_Catalog_BoCategory::COL_PARENT_ID => $category->getParentId(),
                Vcatalog_Bo_Catalog_BoCategory::COL_TITLE => $category->getTitle(),
                Vcatalog_Bo_Catalog_BoCategory::COL_DESCRIPTION => $category->getDescription(),
                Vcatalog_Bo_Catalog_BoCategory::COL_IMAGE_ID => $category->getImageId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCategoryCache($category);
        return $result;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::countNumItems()
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
     * @see Vcatalog_Bo_Catalog_ICatalogDao::countNumItemsForCategory()
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
        $params = Array($cat->getId());
        foreach ($cat->getChildren() as $child) {
            $params[] = $child->getId();
        }
        $params = Array('categoryIds' => $params);
        $result = $this->execCount($sqlStm, $params);
        return $result;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::createItem()
     */
    public function createItem($categoryId, $title, $description, $vendor, $timestamp, $price, $oldPrice, $stock, $imageId, $hotItem = FALSE, $newItem = TRUE) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vcatalog_Bo_Catalog_BoItem::COL_CATEGORY_ID => $categoryId,
                Vcatalog_Bo_Catalog_BoItem::COL_TITLE => $title,
                Vcatalog_Bo_Catalog_BoItem::COL_DESCRIPTION => $description,
                Vcatalog_Bo_Catalog_BoItem::COL_VENDOR => $vendor,
                Vcatalog_Bo_Catalog_BoItem::COL_TIMESTAMP => $timestamp,
                Vcatalog_Bo_Catalog_BoItem::COL_PRICE => $price,
                Vcatalog_Bo_Catalog_BoItem::COL_OLD_PRICE => $oldPrice,
                Vcatalog_Bo_Catalog_BoItem::COL_STOCK => $stock,
                Vcatalog_Bo_Catalog_BoItem::COL_IMAGE_ID => $imageId,
                Vcatalog_Bo_Catalog_BoItem::COL_HOT_ITEM => $hotItem ? 1 : 0,
                Vcatalog_Bo_Catalog_BoItem::COL_NEW_ITEM => $newItem ? 1 : 0);
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateItemCache();

        $item = $this->getItemJustCreated($timestamp, $title);
        $this->updateIndexItem($item);
        return $item;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::deleteItem()
     */
    public function deleteItem($item) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vcatalog_Bo_Catalog_BoItem::COL_ID => $item->getId());
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
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getAllItems()
     */
    public function getAllItems($pageNum = 1, $pageSize = 999, $itemSorting = DEFAULT_ITEM_SORTING, $featuredItems = FEATURED_ITEM_NONE) {
        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
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
                        Vcatalog_Bo_Catalog_BoItem::COL_TITLE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vcatalog_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEDESC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vcatalog_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
                break;
            case ITEM_SORTING_TIMEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vcatalog_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            default:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vcatalog_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
        }
        $result = Array();
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[Vcatalog_Bo_Catalog_BoItem::COL_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * Gets the item that has just been created.
     *
     * @param int $timestamp
     * @param string $title
     * @return Vcatalog_Bo_Catalog_BoItem
     */
    protected function getItemJustCreated($timestamp, $title) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $itemId = 0;
        $params = Array(Vcatalog_Bo_Catalog_BoItem::COL_TIMESTAMP => $timestamp,
                Vcatalog_Bo_Catalog_BoItem::COL_TITLE => $title);
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            $itemId = $rows[0][Vcatalog_Bo_Catalog_BoItem::COL_ID];
        }
        return $this->getItemById($itemId);
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getItemById()
     */
    public function getItemById($id) {
        $cacheKey = $this->createCacheKeyItem($id);
        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vcatalog_Bo_Catalog_BoItem::COL_ID => $id);
        $rows = $this->execSelect($sqlStm, $params, $conn->getConn(), $cacheKey);
        if ($rows !== NULL && count($rows) > 0) {
            $item = new Vcatalog_Bo_Catalog_BoItem();
            $item->populate($rows[0]);
        }
        if ($item !== NULL) {
            $cat = $this->getCategoryById($item->getCategoryId());
            $item->setCategory($cat);
        }
        $this->closeConnection();
        return $item;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getItemsForCategory()
     */
    public function getItemsForCategory($cat, $pageNum = 1, $pageSize = 999, $itemSorting = DEFAULT_ITEM_SORTING, $featuredItems = FEATURED_ITEM_NONE) {
        if ($cat === NULL) {
            return Array();
        }
        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
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
        $params = Array($cat->getId());
        foreach ($cat->getChildren() as $child) {
            $params[] = $child->getId();
        }
        $params = Array(self::PARAM_CATEGORY_IDS => $params,
                self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize,
                self::PARAM_PAGE_SIZE => $pageSize);
        switch ($itemSorting) {
            case ITEM_SORTING_TITLE:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vcatalog_Bo_Catalog_BoItem::COL_TITLE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vcatalog_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEDESC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vcatalog_Bo_Catalog_BoItem::COL_PRICE);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
                break;
            case ITEM_SORTING_TIMEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vcatalog_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            default:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs(
                        Vcatalog_Bo_Catalog_BoItem::COL_TIMESTAMP);
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
        }
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[Vcatalog_Bo_Catalog_BoItem::COL_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        $this->closeConnection();
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
                'categoryIds' => $paramCats);
        return $params;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::countSearchItems()
     */
    public function countSearchItems($searchQuery, $searchType = 2, $cat = NULL) {
        $params = $this->buildSearchParams($searchQuery, $searchType, $cat);
        if ($params === NULL) {
            return 0;
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . (count($params['categoryIds']) === 0 ? 'NoCategory' : 'Category'));
        return $this->execCount($sqlStm, $params);
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::searchItems()
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

        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . (count($params['categoryIds']) === 0 ? 'NoCategory' : 'Category'));
        $result = Array();
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[Vcatalog_Bo_Catalog_BoItem::COL_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     *
     * @see Vcatalog_Bo_Catalog_ICatalogDao::updateItem()
     */
    public function updateItem($item) {
        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vcatalog_Bo_Catalog_BoItem::COL_ID => $item->getId(),
                Vcatalog_Bo_Catalog_BoItem::COL_ACTIVE => $item->isActive() ? 1 : 0,
                Vcatalog_Bo_Catalog_BoItem::COL_CATEGORY_ID => $item->getCategoryId(),
                Vcatalog_Bo_Catalog_BoItem::COL_TITLE => $item->getTitle(),
                Vcatalog_Bo_Catalog_BoItem::COL_DESCRIPTION => $item->getDescription(),
                Vcatalog_Bo_Catalog_BoItem::COL_VENDOR => $item->getVendor(),
                Vcatalog_Bo_Catalog_BoItem::COL_PRICE => $item->getPrice(),
                Vcatalog_Bo_Catalog_BoItem::COL_OLD_PRICE => $item->getOldPrice(),
                Vcatalog_Bo_Catalog_BoItem::COL_STOCK => $item->getStock(),
                Vcatalog_Bo_Catalog_BoItem::COL_IMAGE_ID => $item->getImageId(),
                Vcatalog_Bo_Catalog_BoItem::COL_HOT_ITEM => $item->isHotItem() ? 1 : 0,
                Vcatalog_Bo_Catalog_BoItem::COL_NEW_ITEM => $item->isNewItem() ? 1 : 0);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateItemCache($item);
        $this->updateIndexItem($item);
        $this->closeConnection();
        return $result;
    }

    private function updateIndexItem($item) {
        // pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $this->deleteIndexItem($item);

        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);

        $params = Array('itemId' => $item->getId());
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
        $this->closeConnection();
    }

    private function deleteIndexItem($item) {
        if ($item === NULL) {
            return;
        }
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array('itemId' => $item->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    }
}
