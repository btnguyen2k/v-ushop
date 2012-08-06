<?php
abstract class Vushop_Bo_TextAds_BaseAdsDao extends Quack_Bo_BaseDao implements
        Vushop_Bo_TextAds_IAdsDao {

    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * Creates the cache key for ads.
     *
     * @param mixed $adsId
     */
    protected function createCacheKeyAds($adsId) {
        return "TEXTADS_$adsId";
    }

    /**
     * Invalidates the cache due to change.
     *
     * @param Vushop_Bo_TextAds_BoAds $ads
     */
    protected function invalidatePageCache($ads = NULL) {
        if ($ads !== NULL) {
            $cacheKey = $this->createCacheKeyAds($ads->getId());
            $this->deleteFromCache($cacheKey);
        }
    }

    /**
     *
     * @see Vushop_Bo_TextAds_IAdsDao::countNumAds()
     */
    public function countNumAds() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = $this->execCount($sqlStm);
        return (int)$result;
    }

    /**
     *
     * @see Vushop_Bo_TextAds_IAdsDao::createAds()
     */
    public function createAds($ads) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_TextAds_BoAds::COL_TITLE => $ads->getTitle(),
                Vushop_Bo_TextAds_BoAds::COL_URL => $ads->getUrl(),
                Vushop_Bo_TextAds_BoAds::COL_IMAGE_ID => $ads->getImageId());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache();
    }

    /**
     *
     * @see Vushop_Bo_TextAds_IAdsDao::deleteAds()
     */
    public function deleteAds($ads) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_TextAds_BoAds::COL_ID => $ads->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache($ads);
        return $result;
    }

    /**
     *
     * @see Vushop_Bo_TextAds_IAdsDao::getAdsById()
     */
    public function getAdsById($id) {
        $cacheKey = $this->createCacheKeyAds($id);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_TextAds_BoAds::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Vushop_Bo_TextAds_BoAds();
                $result->populate($rows[0]);
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
    }

    /**
     *
     * @see Vushop_Bo_TextAds_IAdsDao::getAds()
     */
    public function getAds($pageNum = 1, $pageSize = PHP_INT_MAX) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize,
                self::PARAM_PAGE_SIZE => $pageSize);
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $rows = $this->execSelect($sqlStm, $params);
        $result = Array();
        if ($rows !== NULL) {
            foreach ($rows as $row) {
                $adsId = $row[Vushop_Bo_TextAds_BoAds::COL_ID];
                $ads = $this->getAdsById($adsId);
                $result[] = $ads;
            }
        }
        return $result;
    }

    /**
     *
     * @see Vushop_Bo_TextAds_IAdsDao::updateAds()
     */
    public function updateAds($ads) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_TextAds_BoAds::COL_ID => $ads->getId(),
                Vushop_Bo_TextAds_BoAds::COL_TITLE => $ads->getTitle(),
                Vushop_Bo_TextAds_BoAds::COL_URL => $ads->getUrl());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache($ads);
        return $result;
    }

    /**
     *
     * @see Vushop_Bo_TextAds_IAdsDao::incClicksCount()
     */
    public function incClicksCount($ads) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_TextAds_BoAds::COL_ID => $ads->getId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidatePageCache($ads);
        return $result;
    }
}
