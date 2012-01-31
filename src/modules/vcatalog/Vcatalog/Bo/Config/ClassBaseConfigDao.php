<?php
abstract class Vcatalog_Bo_Config_BaseConfigDao extends Commons_Bo_BaseDao implements
        Vcatalog_Bo_Config_IConfigDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_BaseDao::getCacheName()
     */
    public function getCacheName() {
        return 'IConfigDao';
    }

    protected function createCacheKeyConfig($configKey) {
        return $configKey;
    }

    protected function invalidateCache($configKey = NULL, $configValue = NULL) {
        if ($configKey !== NULL) {
            $cacheKey = $this->createCacheKeyConfig($configKey);
            if ($configValue === NULL) {
                $this->deleteFromCache($cacheKey);
            } else {
                $this->putToCache($cacheKey, $configValue);
            }

        }
    }

    /**
     * @see Vcatalog_Bo_Config_IConfigDao::loadConfig()
     */
    public function loadConfig($key) {
        $cacheKey = $this->createCacheKeyConfig($key);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array('key' => $key);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = $rows[0]['value'];
                $this->putToCache($cacheKey, $result);
            }
        }
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Config_IConfigDao::saveConfig()
     */
    public function saveConfig($key, $value) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array('key' => $key, 'value' => $value);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($key, $value);
        return $result;
    }
}
