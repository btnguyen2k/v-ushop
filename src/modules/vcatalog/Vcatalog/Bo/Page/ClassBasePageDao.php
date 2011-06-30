<?php
abstract class Vcatalog_Bo_Page_BasePageDao extends Commons_Bo_BaseDao implements
        Vcatalog_Bo_Page_IPageDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::countNumPages()
     */
    public function countNumPages() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();
        $rs = $sqlStm->execute($sqlConn->getConn());
        $result = $this->fetchResultArr($rs);
        $this->closeConnection();
        return (int)$result[0];
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::createPage()
     */
    public function createPage($id, $position, $title, $content, $onMenu) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id,
                'position' => $position,
                'title' => $title,
                'content' => $content,
                'onMenu' => $onMenu ? 1 : 0);
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::deletePage()
     */
    public function deletePage($page) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $page->getId());
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getPageById()
     */
    public function getPageById($id) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        if ($row !== NULL && $row !== FALSE) {
            $page = new Vcatalog_Bo_Page_BoPage();
            $page->populate($row);
        } else {
            $page = NULL;
        }

        $this->closeConnection();
        return $page;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getAllPages()
     */
    public function getAllPages() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $result = Array();
        $rs = $sqlStm->execute($sqlConn->getConn());
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $page = new Vcatalog_Bo_Page_BoPage();
            $page->populate($row);
            $result[] = $page;
            $row = $this->fetchResultAssoc($rs);
        }

        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getOnMenuPages()
     */
    public function getOnMenuPages() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $result = Array();
        $rs = $sqlStm->execute($sqlConn->getConn());
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $page = new Vcatalog_Bo_Page_BoPage();
            $page->populate($row);
            $result[] = $page;
            $row = $this->fetchResultAssoc($rs);
        }

        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::updatePage()
     */
    public function updatePage($page) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $page->getId(),
                'position' => $page->getPosition(),
                'title' => $page->getTitle(),
                'content' => $page->getContent(),
                'onMenu' => $page->getOnMenu() ? 1 : 0);

        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
    }
}
