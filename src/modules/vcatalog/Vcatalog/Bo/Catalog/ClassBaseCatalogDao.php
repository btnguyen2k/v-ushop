<?php
abstract class Vcatalog_Bo_Catalog_BaseCatalogDao extends Quack_Bo_BaseDao implements
        Vcatalog_Bo_Catalog_ICatalogDao {

    /* Virtual columns for category */
    const COL_CAT_ID = 'catId';
    const COL_CAT_POSITION = 'catPosition';
    const COL_CAT_PARENT_ID = 'catParentId';
    const COL_CAT_TITLE = 'catTitle';
    const COL_CAT_DESCRIPTION = 'catDescription';
    const COL_CAT_IMAGE_ID = 'catImageId';

    const COL_CATEGORY_IDS = 'categoryIds';
    const COL_START_OFFSET = 'startOffset';
    const COL_PAGE_SIZE = 'pageSize';

    const COL_ITEM_ID = 'itemId';
    const COL_ITEM_ACTIVE = 'itemActive';
    const COL_ITEM_CAT_ID = 'itemCategoryId';
    const COL_ITEM_TITLE = 'itemTitle';
    const COL_ITEM_DESCRIPTION = 'itemDescription';
    const COL_ITEM_VENDOR = 'itemVendor';
    const COL_ITEM_TIMESTAMP = 'itemTimestamp';
    const COL_ITEM_PRICE = 'itemPrice';
    const COL_ITEM_OLD_PRICE = 'itemOldPrice';
    const COL_ITEM_STOCK = 'itemStock';
    const COL_ITEM_IMAGE_ID = 'itemImageId';
    const COL_ITEM_HOT_ITEM = 'itemHotItem';

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    const CACHE_KEY_CATEGORY_COUNT = 'CATEGORY_COUNT';
    const CACHE_KEY_CATEGORY_TREE = 'CATEGORY_TREE';
    const CACHE_KEY_CATEGORY_PREFIX = 'CATEGORY_';
    const CACHE_KEY_CATEGORY_CHILDREN_PREFIX = 'CATEGORY_CHILDREN_';

    private function getAllCategoryIds() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        $rows = $this->execSelect($sqlStm);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $result[] = $row[self::COL_CAT_ID];
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
            $cacheKey = self::CACHE_KEY_CATEGORY_PREFIX . $catId;
            $this->deleteFromCache($cacheKey);
            $cacheKey = self::CACHE_KEY_CATEGORY_CHILDREN_PREFIX . $catId;
            $this->deleteFromCache($cacheKey);
        }
        $this->deleteFromCache(self::CACHE_KEY_CATEGORY_COUNT);
        $this->deleteFromCache(self::CACHE_KEY_CATEGORY_TREE);
    }

    const CACHE_KEY_ITEM_ALL = 'ITEM_ALL';
    const CACHE_KEY_ITEM_HOT = 'ITEM_HOT';
    const CACHE_KEY_ITEM_COUNT = 'ITEM_COUNT';
    const CACHE_KEY_ITEM_PREFIX = 'ITEM_';

    /**
     * Invalidates the item cache due to change.
     *
     * @param Vcatalog_Bo_Catalog_BoItem $item
     */
    protected function invalidateItemCache($item = NULL) {
        if ($item !== NULL) {
            $itemId = $item->getId();
            $cacheKey = self::CACHE_KEY_ITEM_PREFIX . $itemId;
            $this->deleteFromCache($cacheKey);
        }
        $this->deleteFromCache(self::CACHE_KEY_ITEM_ALL);
        $this->deleteFromCache(self::CACHE_KEY_ITEM_HOT);
        $this->deleteFromCache(self::CACHE_KEY_ITEM_COUNT);
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::countNumCategories()
     */
    public function countNumCategories() {
        $cacheKey = self::CACHE_KEY_CATEGORY_COUNT;
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = $this->execCount($sqlStm, NULL, NULL, $cacheKey);
        return (int)$result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::createCategory()
     */
    public function createCategory($position, $parentId, $title, $description, $imageId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_CAT_POSITION => $position,
                self::COL_CAT_PARENT_ID => $parentId,
                self::COL_CAT_TITLE => $title,
                self::COL_CAT_DESCRIPTION => $description,
                self::COL_CAT_IMAGE_ID => $imageId);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCategoryCache();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::deleteCategory()
     */
    public function deleteCategory($category) {
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();

        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_CAT_ID => $category->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCategoryCache($category);

        //delete the attachment too!
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
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryById()
     */
    public function getCategoryById($id) {
        $cacheKey = self::CACHE_KEY_CATEGORY_PREFIX . $id;
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_CAT_ID => $id);
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
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryChildren()
     */
    public function getCategoryChildren($category) {
        if ($category === NULL) {
            return Array();
        }
        $catId = $category->getId();
        $cacheKey = self::CACHE_KEY_CATEGORY_CHILDREN_PREFIX . $catId;
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        $params = Array(self::COL_CAT_PARENT_ID => $category->getId());
        $rows = $this->execSelect($sqlStm, $params, NULL, $cacheKey);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $catId = (int)($row[self::COL_CAT_ID]);
                $category = $this->getCategoryById($catId);
                $result[] = $category;
            }
        }
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryTree()
     */
    public function getCategoryTree() {
        $cacheKey = self::CACHE_KEY_CATEGORY_TREE;
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        $rows = $this->execSelect($sqlStm, NULL, $conn->getConn(), $cacheKey);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $catId = (int)$row[self::COL_CAT_ID];
                $category = $this->getCategoryById($catId);
                $result[] = $category;
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::updateCategory()
     */
    public function updateCategory($category) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_CAT_ID => $category->getId(),
                self::COL_CAT_POSITION => $category->getPosition(),
                self::COL_CAT_PARENT_ID => $category->getParentId(),
                self::COL_CAT_TITLE => $category->getTitle(),
                self::COL_CAT_DESCRIPTION => $category->getDescription(),
                self::COL_CAT_IMAGE_ID => $category->getImageId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCategoryCache($category);
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::countNumItems()
     */
    public function countNumItems() {
        $cacheKey = self::CACHE_KEY_ITEM_COUNT;
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = $this->execCount($sqlStm, NULL, NULL, $cacheKey);
        return (int)$result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::countNumItemsForCategory()
     */
    public function countNumItemsForCategory($cat) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        //count items within this category and its children too
        $params = Array($cat->getId());
        foreach ($cat->getChildren() as $child) {
            $params[] = $child->getId();
        }
        $params = Array(self::COL_CATEGORY_IDS => $params);
        $result = $this->execCount($sqlStm, $params);
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::createItem()
     */
    public function createItem($categoryId, $title, $description, $vendor, $timestamp, $price, $oldPrice, $stock, $imageId, $hotItem = TRUE) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_ITEM_CAT_ID => $categoryId,
                self::COL_ITEM_TITLE => $title,
                self::COL_ITEM_DESCRIPTION => $description,
                self::COL_ITEM_VENDOR => $vendor,
                self::COL_ITEM_TIMESTAMP => $timestamp,
                self::COL_ITEM_PRICE => $price,
                self::COL_ITEM_OLD_PRICE => $oldPrice,
                self::COL_ITEM_STOCK => $stock,
                self::COL_ITEM_IMAGE_ID => $imageId,
                self::COL_ITEM_HOT_ITEM => $hotItem ? 1 : 0);
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateItemCache();

        $item = $this->getItemJustCreated($timestamp, $title);
        $this->updateIndexItem($item);
        return $item;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::deleteItem()
     */
    public function deleteItem($item) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_ITEM_ID => $item->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateItemCache($item);

        //delete the attachment too!
        $paperclipId = $item->getImageId();
        $paperclipDao = $this->getDaoFactory()->getDao(DAO_PAPERCLIP);
        $paperclipItem = $paperclipDao->getAttachment($paperclipId);
        if ($paperclipItem !== NULL) {
            $paperclipDao->deleteAttachment($paperclipItem);
        }
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getAllItems()
     */
    public function getAllItems($pageNum = 1, $pageSize = 999) {
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_START_OFFSET => ($pageNum - 1) * $pageSize,
                self::COL_PAGE_SIZE => $pageSize);
        $result = Array();
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[self::COL_ITEM_ID];
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
        $params = Array(self::COL_ITEM_TIMESTAMP => $timestamp, self::COL_ITEM_TITLE => $title);
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            $itemId = $rows[0][self::COL_ITEM_ID];
        }
        return $this->getItemById($itemId);
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getItemById()
     */
    public function getItemById($id) {
        $cacheKey = self::CACHE_KEY_ITEM_PREFIX . $id;
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_ITEM_ID => $id);
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
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getItemsForCategory()
     */
    public function getItemsForCategory($cat, $pageNum = 1, $pageSize = 999, $itemSorting = DEFAULT_ITEM_SORTING) {
        if ($cat === NULL) {
            return Array();
        }
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        //get all items within this category and its children too
        $params = Array($cat->getId());
        foreach ($cat->getChildren() as $child) {
            $params[] = $child->getId();
        }
        $params = Array(self::COL_CATEGORY_IDS => $params,
                self::COL_START_OFFSET => ($pageNum - 1) * $pageSize,
                self::COL_PAGE_SIZE => $pageSize);
        switch ($itemSorting) {
            case ITEM_SORTING_TITLE:
                $params['sortingField'] = new Ddth_Dao_ParamAsIs(self::COL_ITEM_TITLE);
                $params['sorting'] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEASC:
                $params['sortingField'] = new Ddth_Dao_ParamAsIs(self::COL_ITEM_PRICE);
                $params['sorting'] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ITEM_SORTING_PRICEDESC:
                $params['sortingField'] = new Ddth_Dao_ParamAsIs(self::COL_ITEM_PRICE);
                $params['sorting'] = new Ddth_Dao_ParamAsIs('DESC');
                break;
            case ITEM_SORTING_TIMEASC:
                $params['sortingField'] = new Ddth_Dao_ParamAsIs(self::COL_ITEM_TIMESTAMP);
                $params['sorting'] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            default:
                $params['sortingField'] = new Ddth_Dao_ParamAsIs(self::COL_ITEM_TIMESTAMP);
                $params['sorting'] = new Ddth_Dao_ParamAsIs('DESC');
        }
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[self::COL_ITEM_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getHotItems()
     */
    public function getHotItems($numItems = 10) {
        $cacheKey = self::CACHE_KEY_ITEM_HOT;
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        $params = Array(self::COL_PAGE_SIZE => $numItems);
        $rows = $this->execSelect($sqlStm, $params, $conn->getConn(), $cacheKey);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[self::COL_ITEM_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::searchItems()
     */
    public function searchItems($searchQuery, $searchType = 2, $cat = NULL, $pageNum = 1, $pageSize = 10) {
        $tokens = preg_split(WORD_SPLIT_PATTERN, strip_tags($searchQuery));
        $searchTerms = Array();
        foreach ($tokens as $token) {
            if (mb_strlen($token) > 2) {
                $temp = mb_strtolower($token, 'UTF-8');
                $searchTerms[$temp] = 1;
            }
        }

        if (count($searchTerms) === 0) {
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

        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . (count($paramCats) === 0 ? 'NoCategory' : 'Category'));
        $params = Array('searchTypes' => $paramSearchTypes,
                'tags' => $paramSearchTerms,
                self::COL_CATEGORY_IDS => $paramCats,
                self::COL_START_OFFSET => ($pageNum - 1) * $pageSize,
                self::COL_PAGE_SIZE => $pageSize);
        $result = Array();
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $itemId = $row[self::COL_ITEM_ID];
                $item = $this->getItemById($itemId);
                $result[] = $item;
            }
        }
        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::updateItem()
     */
    public function updateItem($item) {
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_ITEM_ID => $item->getId(),
                self::COL_ITEM_ACTIVE => $item->isActive() ? 1 : 0,
                self::COL_ITEM_CAT_ID => $item->getCategoryId(),
                self::COL_ITEM_TITLE => $item->getTitle(),
                self::COL_ITEM_DESCRIPTION => $item->getDescription(),
                self::COL_ITEM_VENDOR => $item->getVendor(),
                self::COL_ITEM_PRICE => $item->getPrice(),
                self::COL_ITEM_OLD_PRICE => $item->getOldPrice(),
                self::COL_ITEM_STOCK => $item->getStock(),
                self::COL_ITEM_IMAGE_ID => $item->getImageId(),
                self::COL_ITEM_HOT_ITEM => $item->isHotItem() ? 1 : 0);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateItemCache($item);
        $this->updateIndexItem($item);
        $this->closeConnection();
        return $result;
    }

    private function updateIndexItem($item) {
        //pre-open a connection so that subsequence operations will reuse it
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
