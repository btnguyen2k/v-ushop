<?php
abstract class Vcatalog_Bo_Page_BasePageDao extends Quack_Bo_BaseDao implements
        Vcatalog_Bo_Page_IPageDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /* Virtual columns */
    const COL_ID = 'pageId';
    const COL_POSITION = 'pagePosition';
    const COL_TITLE = 'pageTitle';
    const COL_CONTENT = 'pageContent';
    const COL_ON_MENU = 'pageOnMenu';

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
            $result = $this->execCount($sqlStm);
            $this->putToCache($cacheKey, $result);
        }
        return (int)$result;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::createPage()
     */
    public function createPage($id, $position, $title, $content, $onMenu) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_ID => $id,
                self::COL_POSITION => $position,
                self::COL_TITLE => $title,
                self::COL_CONTENT => $content,
                self::COL_ON_MENU => $onMenu ? 1 : 0);
        $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache();
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::deletePage()
     */
    public function deletePage($page) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_ID => $page->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache($page);
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getPageById()
     */
    public function getPageById($id) {
        $cacheKey = "PAGE_$id";
        $page = $this->getFromCache($cacheKey);
        if ($page === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(self::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $page = new Vcatalog_Bo_Page_BoPage();
                $page->populate($rows[0]);
                $this->putToCache($cacheKey, $page);
            }
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
            $rows = $this->execSelect($sqlStm);
            $result = Array();
            if ($rows !== NULL) {
                foreach ($rows as $row) {
                    $pageId = $row[self::COL_ID];
                    $page = $this->getPageById($pageId);
                    $result[] = $page;
                }
            }
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
            $rows = $this->execSelect($sqlStm);
            $result = Array();
            if ($rows !== NULL) {
                foreach ($rows as $row) {
                    $pageId = $row[self::COL_ID];
                    $page = $this->getPageById($pageId);
                    $result[] = $page;
                }
            }
            $this->putToCache($cacheKey, $result);
        }
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::updatePage()
     */
    public function updatePage($page) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_ID => $page->getId(),
                self::COL_POSITION => $page->getPosition(),
                self::COL_TITLE => $page->getTitle(),
                self::COL_CONTENT => $page->getContent(),
                self::COL_ON_MENU => $page->getOnMenu() ? 1 : 0);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache($page);
        return $result;
    }
}
