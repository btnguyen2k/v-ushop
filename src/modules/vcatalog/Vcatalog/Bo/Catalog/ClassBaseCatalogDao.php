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

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::countNumCategories()
     */
    public function countNumCategories() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();
        $rs = $sqlStm->execute($sqlConn->getConn());
        $result = $this->fetchResultArr($rs);
        $this->closeConnection();
        return (int)$result[0];
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::createCategory()
     */
    public function createCategory($position, $parentId, $title, $description) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('position' => $position,
                'parentId' => $parentId,
                'title' => $title,
                'description' => $description);
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
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
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryById()
     */
    public function getCategoryById($id) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        if ($row !== NULL && $row !== FALSE) {
            $cat = new Vcatalog_Bo_Catalog_BoCategory();
            $cat->populate($row);
        } else {
            $cat = NULL;
        }
        if ($cat !== NULL) {
            $children = $this->getCategoryChildren($cat);
            $cat->setChildren($children);
        }

        $this->closeConnection();
        return $cat;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryChildren()
     */
    public function getCategoryChildren($category) {
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
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryTree()
     */
    public function getCategoryTree() {
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
                'description' => $category->getDescription());
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::createItem()
     */
    public function createItem($categoryId, $title, $description, $vendor, $timestamp, $price, $oldPrice, $stock) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('categoryId' => $categoryId,
                'title' => $title,
                'description' => $description,
                'vendor' => $vendor,
                'timestamp' => $timestamp,
                'price' => $price,
                'oldPrice' => $oldPrice,
                'stock' => $stock);

        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
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
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getAllItems()
     */
    public function getAllItems() {
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
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getItemById()
     */
    public function getItemById($id) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        if ($row !== NULL && $row !== FALSE) {
            $item = new Vcatalog_Bo_Catalog_BoItem();
            $item->populate($row);
        } else {
            $item = NULL;
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
     * @see Vcatalog_Bo_Catalog_ICatalogDao::updateItem()
     */
    public function updateItem($item) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $item->getId(),
                'active' => $item->isActive(),
                'categoryId' => $item->getCategoryId(),
                'title' => $item->getTitle(),
                'descrpition' => $item->getDescription(),
                'vendor' => $item->getVendor(),
                'price' => $item->getPrice(),
                'oldPrice' => $item->getOldPrice(),
                'stock' => $item->getStock());

        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
    }
}
