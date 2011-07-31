<?php
class Commons_Utils_CacheUtils {

    private static $caches = Array();

    /**
     * Gets a cache by name.
     *
     * @param string $cacheName
     * @return Ddth_Cache_ICache
     */
    private static function getCache($cacheName) {
        $cache = isset(self::$caches[$cacheName]) ? self::$caches[$cacheName] : NULL;
        if ($cache === NULL) {
            $cacheManager = Ddth_Cache_CacheManager::getInstance();
            $cache = $cacheManager->getCache($cacheName);
            if ($cache !== NULL) {
                self::$caches[$cacheName] = $cache;
            }
        }
        return $cache;
    }

    /**
     * Deletes an item from cache.
     *
     * @param string $key
     * @param string $cacheName
     */
    public static function delete($key, $cacheName = 'default') {
        $cacheManager = Ddth_Cache_CacheManager::getInstance();
        $cache = $cacheManager->getCache($cacheName);
        if ($cache !== NULL) {
            $cache->remove($key);
        }
    }

    /**
     * Puts an item to cache.
     *
     * @param string $key
     * @param mixed $value
     * @param string $cacheName
     */
    public static function put($key, $value, $cacheName = 'default') {
        $cacheManager = Ddth_Cache_CacheManager::getInstance();
        $cache = $cacheManager->getCache($cacheName);
        if ($cache !== NULL) {
            $cache->put($key, $value);
        }
    }

    /**
     * Gets an item from cache.
     *
     * @param string $key
     * @param string $cacheName
     * @return mixed
     */
    public static function get($key, $cacheName = 'default') {
        $cacheManager = Ddth_Cache_CacheManager::getInstance();
        $cache = $cacheManager->getCache($cacheName);
        $result = $cache !== NULL ? $cache->get($key) : NULL;
        return $result;
    }
}
