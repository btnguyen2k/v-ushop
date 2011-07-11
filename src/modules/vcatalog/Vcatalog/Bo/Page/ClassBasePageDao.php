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

    const CACHE_KEY_PAGE_COUNT = 'PAGE_COUNT';
    const CACHE_KEY_PAGE_ALL = 'PAGE_ALL';
    const CACHE_KEY_PAGE_ON_MENU = 'PAGE_ON_MENU';

    /**
     * Invalidates the page cache due to change.
     *
     * @param Vcatalog_Bo_Page_BoPage $page
     */
    protected function invalidatePageCache($page = NULL) {
        if ($page !== NULL) {
            $pageId = $page->getId();
            $cacheKey = "PAGE_$pageId";
            $this->deleteFromCache($cacheKey);
        }
        $this->deleteFromCache(self::CACHE_KEY_PAGE_COUNT);
        $this->deleteFromCache(self::CACHE_KEY_PAGE_ALL);
        $this->deleteFromCache(self::CACHE_KEY_PAGE_ON_MENU);
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::countNumPages()
     */
    public function countNumPages() {
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
        $this->invalidatePageCache();
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
        $this->invalidatePageCache($page);
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getPageById()
     */
    public function getPageById($id) {
        $cacheKey = "PAGE_$id";
        $page = $this->getFromCache($cacheKey);
        if ($page === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $params = Array('id' => $id);
            $rs = $sqlStm->execute($sqlConn->getConn(), $params);
            $row = $this->fetchResultAssoc($rs);
            if ($row !== NULL && $row !== FALSE) {
                $page = new Vcatalog_Bo_Page_BoPage();
                $page->populate($row);
                $this->putToCache($cacheKey, $page);
            }

            $this->closeConnection();
        }
        return $page;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getAllPages()
     */
    public function getAllPages() {
        $cacheKey = self::CACHE_KEY_PAGE_ALL;
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $result = Array();
            $rs = $sqlStm->execute($sqlConn->getConn());
            $row = $this->fetchResultArr($rs);
            while ($row !== FALSE && $row !== NULL) {
                $pageId = $row[0];
                $page = $this->getPageById($pageId);
                //$page = new Vcatalog_Bo_Page_BoPage();
                //$page->populate($row);
                $result[] = $page;
                $row = $this->fetchResultArr($rs);
            }

            $this->closeConnection();
            $this->putToCache($cacheKey, $result);
        }
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getOnMenuPages()
     */
    public function getOnMenuPages() {
        $cacheKey = self::CACHE_KEY_PAGE_ON_MENU;
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $result = Array();
            $rs = $sqlStm->execute($sqlConn->getConn());
            $row = $this->fetchResultArr($rs);
            while ($row !== FALSE && $row !== NULL) {
                $pageId = $row[0];
                $page = $this->getPageById($pageId);
                //$page = new Vcatalog_Bo_Page_BoPage();
                //$page->populate($row);
                $result[] = $page;
                $row = $this->fetchResultArr($rs);
            }

            $this->closeConnection();
            $this->putToCache($cacheKey, $result);
        }
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
        $this->invalidatePageCache($page);
    }
}
