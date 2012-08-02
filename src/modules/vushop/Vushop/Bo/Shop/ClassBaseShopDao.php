<?php
abstract class Vushop_Bo_Shop_BaseShopDao extends Quack_Bo_BaseDao implements 
        Vushop_Bo_Shop_IShopDao {
    
    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;
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
        return 'IShopDao';
    }
    
    protected function createCacheKeyShopOwnerId($shopOwnerId) {
        return "SHOP_$shopOwnerId";
    }
    
        protected function createCacheKeyShopCount() {
        return 'SHOP_COUNT';
    }
    
    /**
     * Invalidates the shop cache due to change.
     *
     * @param Vushop_Bo_Shop_BoShop $shop
     */
    protected function invalidateCache($shop = NULL) {
        if ($shop !== NULL) {
            $this->deleteFromCache($this->createCacheKeyShopOwnerId($shop->getOwnerId()));
        }
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_Shop_IShopDao::getShops()
     */
    public function getShops($pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize, 
                self::PARAM_PAGE_SIZE => $pageSize);
        $result = Array();
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $shopOwnerId = $row[Vushop_Bo_Shop_BoShop::COL_OWNER_ID];
                $shop = $this->getShopById($shopOwnerId);
                $result[] = $shop;
            }
        }
        return $result;
    }
    
         /**
     *
     * @see Vushop_Bo_Shop_BaseShopDao::getCountNumShops()
     */
    public function getCountNumShops() {
        $cacheKey = $this->createCacheKeyShopCount();
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $result = $this->execCount($sqlStm);
        }
        return $this->returnCachedResult($result, $cacheKey);
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_Shop_IShopDao::getShopById()
     */
    public function getShopById($ownerId) {
        $ownerId = (int)$ownerId;
        $cacheKey = $this->createCacheKeyShopOwnerId($ownerId);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_Shop_BoShop::COL_OWNER_ID => $ownerId);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Vushop_Bo_Shop_BoShop();
                $result->populate($rows[0]);
                if ($result !== NULL) {
                    $userDao = $this->getDaoFactory()->getDao(DAO_USER);
                    $user = $userDao->getUserById($result->getOwnerId());
                    $result->setUser($user);
                }
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_Shop_IShopDao::createShop()
     */
    public function createShop($shop) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Shop_BoShop::COL_OWNER_ID => (int)$shop->getOwnerId(), 
                Vushop_Bo_Shop_BoShop::COL_DESC => $shop->getDescription(), 
                Vushop_Bo_Shop_BoShop::COL_IMAGE_ID => $shop->getImageId(), 
                Vushop_Bo_Shop_BoShop::COL_POSITION => (int)$shop->getPosition(), 
                Vushop_Bo_Shop_BoShop::COL_TITLE => $shop->getTitle());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($shop);
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_Shop_IShopDao::updateShop()
     */
    public function updateShop($shop) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Shop_BoShop::COL_OWNER_ID => (int)$shop->getOwnerId(), 
                Vushop_Bo_Shop_BoShop::COL_DESC => $shop->getDescription(), 
                Vushop_Bo_Shop_BoShop::COL_IMAGE_ID => $shop->getImageId(), 
                Vushop_Bo_Shop_BoShop::COL_POSITION => (int)$shop->getPosition(), 
                Vushop_Bo_Shop_BoShop::COL_TITLE => $shop->getTitle());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($shop);
        return $result;
    }
}
