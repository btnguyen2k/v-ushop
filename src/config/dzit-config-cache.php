<?php
/*
 * Configurations for Ddth::Cache
 */
$cachePrefix = VCATALOG_VERSION . '/' . $_SERVER["HTTP_HOST"] . $_SERVER['SERVER_ADDR'];
$cachePrefix = crc32($cachePrefix);

global $DPHP_CACHE_CONFIG_MEMCACHE;
$DPHP_CACHE_CONFIG_MEMCACHE = Array(
        'default' => Array('cache.type' => 'memcache',
                'cache.keyPrefix' => $cachePrefix,
                'memcache.servers' => Array(Array('host' => '127.0.0.1', 'port' => 11211))));

global $DPHP_CACHE_CONFIG_MEMCACHED;
$DPHP_CACHE_CONFIG_MEMCACHED = Array(
        'default' => Array('cache.type' => 'memcached',
                'cache.keyPrefix' => $cachePrefix,
                'memcached.servers' => Array(Array('host' => '127.0.0.1', 'port' => 11211))));

global $DPHP_CACHE_CONFIG_MEMORY;
$DPHP_CACHE_CONFIG_MEMORY = Array('default' => Array('cache.type' => 'memory'));

global $DPHP_CACHE_CONFIG;
if (class_exists('Memcache')) {
    $DPHP_CACHE_CONFIG = &$DPHP_CACHE_CONFIG_MEMCACHE;
} else if (class_exists('Memcached')) {
    $DPHP_CACHE_CONFIG = &$DPHP_CACHE_CONFIG_MEMCACHED;
} else {
    $DPHP_CACHE_CONFIG = &$DPHP_CACHE_CONFIG_MEMORY;
}
