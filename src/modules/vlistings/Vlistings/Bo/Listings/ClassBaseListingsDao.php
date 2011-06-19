<?php
abstract class Vlistings_Bo_Listings_BaseListingsDao extends Commons_Bo_BaseDao implements
        Vlistings_Bo_Listings_IListingsDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /* (non-PHPdoc)
     * @see Vlistings_Bo_Listings_IListingsDao::createCategory()
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
     * @see Vlistings_Bo_Listings_IListingsDao::getCategoryById()
     */
    public function getCategoryById($id) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        if ($row !== NULL && $row !== FALSE) {
            $cat = new Vlistings_Bo_Listings_BoCategory();
            $cat->populate($row);
        } else {
            $cat = NULL;
        }

        $this->closeConnection();
        return $cat;
    }

    /* (non-PHPdoc)
     * @see Vlistings_Bo_Listings_IListingsDao::getCategoryTree()
     */
    public function getCategoryTree() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $mResult = Array();
        $aResult = Array();
        $rs = $sqlStm->execute($sqlConn->getConn());
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $category = new Vlistings_Bo_Listings_BoCategory();
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
     * @see Vlistings_Bo_Listings_IListingsDao::countNumCategories()
     */
    public function countNumCategories() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();
        $rs = $sqlStm->execute($sqlConn->getConn());
        $result = $this->fetchResultArr($rs);
        $this->closeConnection();
        return (int)$result[0];
    }
}
