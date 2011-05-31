<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * "Getting started" for Ddth_Dao package. See {@link _getting_started here} for document.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: _getting_started.php 272 2011-05-24 09:31:04Z btnguyen2k@gmail.com $
 * @since       File available since v0.2.3
 */

/**
 * "Getting started" for Ddth_Dao package.
 *
 * Ddth_Dao is a generic multi-purposes implementation of DAO pattern.
 *
 * <b>"Quick & Dirty":</b>
 * <code>
 * $DPHP_CACHE_CONFIG = Array(
 *     'default' => Array(
 *         #the 'default' cache (where 'default' is cache's name), required
 *         'cache.type'         => 'type of cache, either: memcache, memcached, apc, or memory',
 *         'cache.class'        => '(optional) name of the cache class,
 *                                  must implement Ddth_Cache_ICache',
 *         'cache.engine.class' => '(optional) name of the cache engine class (if Ddth_Cache_GenericCache
 *                                  is used - which is the default), must implement Ddth_Cache_ICacheEngine',
 *         'other configs'      => 'specified by each type of cache/engine'
 *     ),
 *     'memory' => Array(
 *         #example of in-memory cache. Cache entries will NOT be persisted across HTTP requests!
 *         'cache.type'         => 'memory'
 *     ),
 *     'apc' => Array(
 *         #example of APC cache. Cache entries will be persisted across HTTP requests.
 *         'cache.type'         => 'apc'
 *     ),
 *     'memcache' => Array(
 *         #example of MemcacheD cache (use php-memcache APIs). Cache entries will be persisted across HTTP requests.
 *         'cache.type'         => 'memcache',
 *         'memcache.servers'   => Array(
 *             #list of MemcacheD servers
 *             Array(
 *                 #see http://www.php.net/manual/en/memcache.addserver.php for more information
 *                 'host'       => '192.168.0.1',
 *                 'port'       => 11211, #optional
 *                 'weight'     => 1 #optional
 *             ),
 *             Array(
 *                 'host'       => 'unix:///path/to/memcached.sock',
 *                 'port'       => 0, #must be 0 if using UNIX socket
 *                 'weight'     => 1 #optional
 *             )
 *         )
 *     ),
 *     'memcached' => Array(
 *         #example of MemcacheD cache (use php-memcached APIs). Cache entries will be persisted across HTTP requests.
 *         'cache.type'         => 'memcached',
 *         'memcached.servers'   => Array(
 *             #list of MemcacheD servers
 *             Array(
 *                 #see http://www.php.net/manual/en/memcached.addserver.php for more information
 *                 'host'       => '192.168.0.1',
 *                 'port'       => 11211, #optional
 *                 'weight'     => 1 #optional
 *             ),
 *             Array(
 *                 'host'       => '192.168.0.2',
 *                 'port'       => 11211, #optional
 *                 'weight'     => 1 #optional
 *             )
 *         )
 *     )
 * );
 * $cacheManager = Ddth_Cache_CacheManager::getInstance($DPHP_CACHE_CONFIG);
 * $cache = $cacheManager->getCache('apc');
 *
 * $key = 'key1';
 * $value = 'value1';
 * $cache->put($key, $value);
 * print_r($cache->get($key));
 * </code>
 *
 * <b>0. The configuration:</b> it's an associative array with the following structure
 * <code>
 * $config = Array(
 *     'default' => Array(
 *         #the 'default' cache (where 'default' is cache's name), required
 *         'cache.type'         => 'type of cache, either: memcache, memcached, apc, or memory',
 *         'cache.class'        => '(optional) name of the cache class,
 *                                  must implement Ddth_Cache_ICache',
 *         'cache.engine.class' => '(optional) name of the cache engine class (if Ddth_Cache_GenericCache
 *                                  is used - which is the default), must implement Ddth_Cache_ICacheEngine',
 *         'other configs'      => 'specified by each type of cache/engine'
 *     ),
 *     'memory' => Array(
 *         #example of in-memory cache. Cache entries will NOT be persisted across HTTP requests!
 *         'cache.type'         => 'memory'
 *     ),
 *     'apc' => Array(
 *         #example of APC cache. Cache entries will be persisted across HTTP requests.
 *         'cache.type'         => 'apc'
 *     ),
 *     'memcache' => Array(
 *         #example of MemcacheD cache (use php-memcache APIs). Cache entries will be persisted across HTTP requests.
 *         'cache.type'         => 'memcache',
 *         'memcache.servers'   => Array(
 *             #list of MemcacheD servers
 *             Array(
 *                 #see http://www.php.net/manual/en/memcache.addserver.php for more information
 *                 'host'       => '192.168.0.1',
 *                 'port'       => 11211, #optional
 *                 'weight'     => 1 #optional
 *             ),
 *             Array(
 *                 'host'       => 'unix:///path/to/memcached.sock',
 *                 'port'       => 0, #must be 0 if using UNIX socket
 *                 'weight'     => 1 #optional
 *             )
 *         )
 *     ),
 *     'memcached' => Array(
 *         #example of MemcacheD cache (use php-memcached APIs). Cache entries will be persisted across HTTP requests.
 *         'cache.type'         => 'memcached',
 *         'memcached.servers'   => Array(
 *             #list of MemcacheD servers
 *             Array(
 *                 #see http://www.php.net/manual/en/memcached.addserver.php for more information
 *                 'host'       => '192.168.0.1',
 *                 'port'       => 11211, #optional
 *                 'weight'     => 1 #optional
 *             ),
 *             Array(
 *                 'host'       => '192.168.0.2',
 *                 'port'       => 11211, #optional
 *                 'weight'     => 1 #optional
 *             )
 *         )
 *     )
 * );
 * </code>
 *
 * <b>1. Obtain an instance of {@link Ddth_Cache_CacheManager}:</b>
 * <code>
 * $cacheManager = Ddth_Cache_CacheManager::getInstance();
 * //or:
 * $cacheManager = Ddth_Cache_CacheManager::getInstance($config);
 * </code>
 * If there is argument supplied, function {@link Ddth_Cache_CacheManager::getInstance()} will
 * look for the global variable $DPHP_CACHE_CONFIG. If there is no such global variable, the
 * function will then look for the global variable $DPHP_CACHE_CONF.
 *
 * <b>2. Obtain instances of Ddth_Cache_ICache:</b>
 * <code>
 * $cacheName = 'default';
 * $cache = $cacheManager->getCache($cacheName);
 * </code>
 *
 * <b>3. Use the cache in your way</b>
 * $cache->put($key, $value);
 * $value = $cache->get($key);
 * </code>
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2.3
 */
class _getting_started {
}
?>
