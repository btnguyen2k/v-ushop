<?php
abstract class Commons_Bo_BaseDao extends Ddth_Dao_AbstractSqlStatementDao {

    private $cacheL1 = Array();

    public function __construct() {
        parent::__construct();
        $cacheManager = Ddth_Cache_CacheManager::getInstance();
    }

    /**
     * Put an entry to cache.
     *
     * @param string $key
     * @param mixed $value
     * @param boolean $includeCacheL2
     */
    protected function putToCache($key, $value, $includeCacheL2 = TRUE) {
        $this->cacheL1[$key] = $value;
        if ($includeCacheL2) {
            Commons_Utils_CacheUtils::put($key, $value, 'default');
        }
    }

    /**
     * Gets an entry from cache.
     *
     * @param string $key
     * @param boolean $includeCacheL2
     * @return mixed
     */
    protected function getFromCache($key, $includeCacheL2 = TRUE) {
        $result = isset($this->cacheL1[$key]) ? $this->cacheL1[$key] : NULL;
        if ($result === NULL && $includeCacheL2) {
            $result = Commons_Utils_CacheUtils::get($key, 'default');
            if ($result !== NULL) {
                $this->cacheL1[$key] = $result;
            }
        }
        return $result;
    }

    /**
     * Deletes an entry from cache.
     *
     * @param string $key
     * @param boolean $includeCacheL2
     */
    protected function deleteFromCache($key, $includeCacheL2 = TRUE) {
        unset($this->cacheL1[$key]);
        if ($includeCacheL2) {
            Commons_Utils_CacheUtils::delete($key);
        }
    }

    /**
     * Fetches result from the result set and returns as an associative array.
     *
     * @param resource $rs
     */
    protected abstract function fetchResultAssoc($rs);

    /**
     * Fetches result from the result set and returns as an index array.
     *
     * @param resource $rs
     */
    protected abstract function fetchResultArr($rs);

    /**
     * Gets a {@link Ddth_Dao_SqlStatement} object, throws exception if not found.
     *
     * @param string $name name of the statement to get
     * @return Ddth_Dao_SqlStatement
     */
    protected function getStatement($name) {
        $stm = $this->getSqlStatement($name);
        if ($stm === NULL) {
            $msg = "Can not obtain the statement [$name]!";
            throw new Exception($msg);
        }
        return $stm;
    }
}