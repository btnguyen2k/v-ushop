<?php
/*
 * Configurations for Ddth::Cache
 */
global $DPHP_CACHE_CONFIG;
$DPHP_CACHE_CONFIG = Array(
        'default' => Array('cache.type' => 'memcache',
                'cache.keyPrefix' => $_SERVER['SERVER_ADDR'].$_SERVER['SCRIPT_NAME'],
                'memcache.servers' => Array(Array('host' => '127.0.0.1', 'port' => 11211))));
