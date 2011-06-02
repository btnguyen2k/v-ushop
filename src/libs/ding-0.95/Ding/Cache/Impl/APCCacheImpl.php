<?php
/**
 * Simple apc cache implementation.
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Cache
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @version    SVN: $Id$
 * @link       http://marcelog.github.com/
 *
 * Copyright 2011 Marcelo Gornstein <marcelog@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */
namespace Ding\Cache\Impl;
use Ding\Cache\ICache;

/**
 * Simple apc cache implementation.
 *
 * PHP Version 5
 *
 * @category   Ding
 * @package    Cache
 * @subpackage Impl
 * @author     Marcelo Gornstein <marcelog@gmail.com>
 * @license    http://marcelog.github.com/ Apache License 2.0
 * @link       http://marcelog.github.com/
 */
class APCCacheImpl implements ICache
{
    /**
     * Holds current instance.
     * @var APCCacheImpl
     */
    private static $_instance = false;

    /**
     * Returns a cached value.
     *
     * @param string  $name    Key to look for.
     * @param boolean &$result True on success, false otherwise.
     *
     * @return mixed
     */
    public function fetch($name, &$result)
    {
        return apc_fetch($name, $result);
    }

    /**
     * Stores a key/value.
     *
     * @param string $name  Key to use.
     * @param mixed  $value Value.
     *
     * @return boolean
     */
    public function store($name, $value)
    {
        return apc_store($name, $value);
    }

    /**
     * Empties the cache.
     *
	 * @return boolean
     */
    public function flush()
    {
        return apc_clear_cache();
    }

    /**
     * Removes a key from the cache.
     *
     * @param string $name Key to remove.
     *
     * @return boolean
     */
    public function remove($name)
    {
        return apc_delete($name);
    }

    /**
     * Returns an instance of a cache.
     *
     * @param array $options Options for the cache backend.
     *
     * @return APCCacheImpl
     */
    public static function getInstance($options = array())
    {
        if (self::$_instance == false) {
            self::$_instance = new APCCacheImpl;
        }
        return self::$_instance;
    }

    /**
     * Constructor.
     *
	 * @return void
     */
    private function __construct()
    {
    }
}