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

    /* (non-PHPdoc)
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

    /* (non-PHPdoc)
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

    /* (non-PHPdoc)
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

        $this->closeConnection();
        return $cat;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryChildren()
     */
    public function getCategoryChildren($category) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $result = Array();
        $params = Array('parentId' => $category->getId());
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $category = new Vcatalog_Bo_Catalog_BoCategory();
            $category->populate($row);
            $result[] = $category;
            $row = $this->fetchResultAssoc($rs);
        }

        $this->closeConnection();
        return $result;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Bo_Catalog_ICatalogDao::getCategoryTree()
     */
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

    /* (non-PHPdoc)
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
}
