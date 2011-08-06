<?php
abstract class Vcatalog_Bo_Catalog_BaseCatalogDao extends Commons_Bo_BaseDao implements
        Vcatalog_Bo_Catalog_ICatalogDao {

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

    /**
     * Invalidates the category cache due to change.
     *
     * @param Vcatalog_Bo_Catalog_BoCategory $cat
     */
    protected function invalidateCategoryCache($cat = NULL) {
        if ($cat !== NULL) {
            $catId = $cat->getId();
            $cacheKey = "CATEGORY_$catId";
            $this->deleteFromCache($cacheKey);
        }
        $this->deleteFromCache(self::CACHE_KEY_CATEGORY_COUNT);
        $this->deleteFromCache(self::CACHE_KEY_CATEGORY_TREE);
    }

    const CACHE_KEY_ITEM_ALL = 'ITEM_ALL';
    const CACHE_KEY_ITEM_HOT = 'ITEM_HOT';

    /**
     * Invalidates the item cache due to change.
     *
     * @param Vcatalog_Bo_Catalog_BoItem $item
     */
    protected function invalidateItemCache($item = NULL) {
        if ($item !== NULL) {
            $itemId = $item->getId();
            $cacheKey = "ITEM_$itemId";
            $this->deleteFromCache($cacheKey);
        }
        $this->deleteFromCache(self::CACHE_KEY_ITEM_ALL);
        $this->deleteFromCache(self::CACHE_KEY_ITEM_HOT);
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::countNumCategories()
     */
    public function countNumCategories() {
        $cacheKey = self::CACHE_KEY_CATEGORY_COUNT;
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();
            $rs = $sqlStm->execute($sqlConn->getConn());
            $result = $this->fetchResultArr($rs);
            $this->closeConnection();
            $result = $result[0];
            $this->putToCache($cacheKey, $result);
        }
        return (int)$result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::createCategory()
     */
    public function createCategory($position, $parentId, $title, $description, $imageId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('position' => $position,
                'parentId' => $parentId,
                'title' => $title,
                'description' => $description,
                'imageId' => $imageId);
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
        $this->invalidateCategoryCache();
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::deleteCategory()
     */
    public function deleteCategory($category) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $category->getId());
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
        $this->invalidateCategoryCache($category);

        //delete the attachment too!
        $paperclipId = $category->getImageId();
        $paperclipDao = $this->getDaoFactory()->getDao(DAO_PAPERCLIP);
        $paperclipItem = $paperclipDao->getAttachment($paperclipId);
        if ($paperclipItem !== NULL) {
            $paperclipDao->deleteAttachment($paperclipItem);
        }
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryById()
     */
    public function getCategoryById($id) {
        $cacheKey = "CATEGORY_$id";
        $category = $this->getFromCache($cacheKey);
        if ($category === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $params = Array('id' => $id);
            $rs = $sqlStm->execute($sqlConn->getConn(), $params);
            $row = $this->fetchResultAssoc($rs);
            if ($row !== NULL && $row !== FALSE) {
                $category = new Vcatalog_Bo_Catalog_BoCategory();
                $category->populate($row);
                $this->putToCache($cacheKey, $category);
            }
            $this->closeConnection();
        }
        if ($category !== NULL) {
            $children = $this->getCategoryChildren($category);
            $category->setChildren($children);
        }
        return $category;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryChildren()
     */
    public function getCategoryChildren($category) {
        $catId = $category->getId();
        $cacheKey = "CATEGORY_CHILDREN_$catId";
        $result = $this->getFromCache($cacheKey, FALSE);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $result = Array();
            $params = Array('parentId' => $category->getId());
            $rs = $sqlStm->execute($sqlConn->getConn(), $params);
            $row = $this->fetchResultArr($rs);
            while ($row !== FALSE && $row !== NULL) {
                $catId = (int)($row['0']);
                $category = $this->getCategoryById($catId);
                //$category = new Vcatalog_Bo_Catalog_BoCategory();
                //$category->populate($row);
                $result[] = $category;
                $row = $this->fetchResultArr($rs);
            }

            $this->closeConnection();
            $this->putToCache($cacheKey, $result, FALSE);
        }
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryTree()
     */
    public function getCategoryTree() {
        $cacheKey = self::CACHE_KEY_CATEGORY_TREE;
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $result = Array();
            $rs = $sqlStm->execute($sqlConn->getConn());
            $row = $this->fetchResultArr($rs);
            while ($row !== FALSE && $row !== NULL) {
                $catId = (int)$row[0];
                $category = $this->getCategoryById($catId);
                $result[] = $category;
                $row = $this->fetchResultArr($rs);
            }

            $this->closeConnection();
            $this->putToCache($cacheKey, $result);
        }
        return $result;
    }
    /*
    public function getCategoryTree() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $mResult = Array();
        $aResult = Array();
        $rs = $sqlStm->execute($sqlConn->getConn());
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $category = new Vcatalog_Bo_Catalog_BoCategory();
            $category->populate($row);
            $id = $category->getId();
            $mResult[$id] = $category;
            $parentId = $category->getParentId();
            if ($parentId === NULL || $parentId === 0) {
                $aResult[] = $category;
            } else {
                $parent = isset($mResult[$parentId]) ? $mResult[$parentId] : NULL;
                if ($parent !== NULL) {
                    $parent->addChild($category);
                }
            }
            $row = $this->fetchResultAssoc($rs);
        }

        $this->closeConnection();
        return $aResult;
    }
    */

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::updateCategory()
     */
    public function updateCategory($category) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $category->getId(),
                'position' => $category->getPosition(),
                'parentId' => $category->getParentId(),
                'title' => $category->getTitle(),
                'description' => $category->getDescription(),
                'imageId' => $category->getImageId());
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
        $this->invalidateCategoryCache($category);
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::createItem()
     */
    public function createItem($categoryId, $title, $description, $vendor, $timestamp, $price, $oldPrice, $stock, $imageId, $hotItem = TRUE) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('categoryId' => $categoryId,
                'title' => $title,
                'description' => $description,
                'vendor' => $vendor,
                'timestamp' => $timestamp,
                'price' => $price,
                'oldPrice' => $oldPrice,
                'stock' => $stock,
                'imageId' => $imageId,
                'hotItem' => $hotItem ? 1 : 0);

        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
        $this->invalidateItemCache();
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::deleteItem()
     */
    public function deleteItem($item) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $item->getId());
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
        $this->invalidateItemCache($item);

        //delete the attachment too!
        $paperclipId = $item->getImageId();
        $paperclipDao = $this->getDaoFactory()->getDao(DAO_PAPERCLIP);
        $paperclipItem = $paperclipDao->getAttachment($paperclipId);
        if ($paperclipItem !== NULL) {
            $paperclipDao->deleteAttachment($paperclipItem);
        }
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getAllItems()
     */
    public function getAllItems() {
        $cacheKey = self::CACHE_KEY_ITEM_ALL;
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $result = Array();
            $rs = $sqlStm->execute($sqlConn->getConn());
            $row = $this->fetchResultAssoc($rs);
            while ($row !== FALSE && $row !== NULL) {
                $itemId = $row['id'];
                $item = $this->getItemById($itemId);
                //$item = new Vcatalog_Bo_Catalog_BoItem();
                //$item->populate($row);
                $result[] = $item;
                $row = $this->fetchResultAssoc($rs);
            }

            $this->closeConnection();
            $this->putToCache($cacheKey, $result);
        }
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getItemById()
     */
    public function getItemById($id) {
        $cacheKey = "ITEM_$id";
        $item = $this->getFromCache($cacheKey);
        if ($item === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $params = Array('id' => $id);
            $rs = $sqlStm->execute($sqlConn->getConn(), $params);
            $row = $this->fetchResultAssoc($rs);
            if ($row !== NULL && $row !== FALSE) {
                $item = new Vcatalog_Bo_Catalog_BoItem();
                $item->populate($row);
                $this->putToCache($cacheKey, $item);
            }

            $this->closeConnection();
        }
        if ($item !== NULL) {
            $cat = $this->getCategoryById($item->getCategoryId());
            $item->setCategory($cat);
        }

        return $item;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getItemsForCategory()
     */
    public function getItemsForCategory($cat) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $result = Array();
        //get all items within this category and its children too
        $params = Array($cat->getId());
        foreach ($cat->getChildren() as $child) {
            $params[] = $child->getId();
        }
        $params = Array('categoryIds' => $params);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $itemId = $row['id'];
            $item = $this->getItemById($itemId);
            //$item = new Vcatalog_Bo_Catalog_BoItem();
            //$item->populate($row);
            $result[] = $item;
            $row = $this->fetchResultAssoc($rs);
        }

        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getHotItems()
     */
    public function getHotItems($numItems = 10) {
        $cacheKey = self::CACHE_KEY_ITEM_HOT;
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $result = Array();
            $params = Array('numItems' => $numItems);
            $rs = $sqlStm->execute($sqlConn->getConn(), $params);
            $row = $this->fetchResultAssoc($rs);
            while ($row !== FALSE && $row !== NULL) {
                $itemId = $row['id'];
                $item = $this->getItemById($itemId);
                $result[] = $item;
                $row = $this->fetchResultAssoc($rs);
            }

            $this->closeConnection();
            $this->putToCache($cacheKey, $result);
        }
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::updateItem()
     */
    public function updateItem($item) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $item->getId(),
                'active' => $item->isActive() ? 1 : 0,
                'categoryId' => $item->getCategoryId(),
                'title' => $item->getTitle(),
                'descrpition' => $item->getDescription(),
                'vendor' => $item->getVendor(),
                'price' => $item->getPrice(),
                'oldPrice' => $item->getOldPrice(),
                'stock' => $item->getStock(),
                'imageId' => $item->getImageId(),
                'hotItem' => $item->isHotItem() ? 1 : 0);

        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
        $this->invalidateItemCache($item);
    }
}
