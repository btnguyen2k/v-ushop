<?php
/**
 * A dummy logger, used when log4php is not available. It's a facade.
 *
 * PHP Version 5
 *
 * @category Ding
 * @package  Logger
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/ Apache License 2.0
 * @version  SVN: $Id$
 * @link     http://marcelog.github.com/
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
if (!class_exists('Logger')) {
/**
 * A dummy logger, used when log4php is not available. It's a facade.
 *
 * PHP Version 5
 *
 * @category Ding
 * @package  Logger
 * @author   Marcelo Gornstein <marcelog@gmail.com>
 * @license  http://marcelog.github.com/ Apache License 2.0
 * @link     http://marcelog.github.com/
 */
final class Logger
{
    /**
     * Holds our instance.
     * @var Logger
     */
    private static $_instance = false;

    /**
     * Returns a logger.
     *
     * @param mixed $options
     *
     * @return Logger
     */
    public final static function getLogger($options)
    {
        if (self::$_instance === false) {
            $ret = new Logger();
            self::$_instance = $ret;
        } else {
            $ret = self::$_instance;
        }
        return $ret;
    }

    /**
     * Dummy configuration.
     *
     * @param mixed $options
     *
     * @return void
     */
    public final static function configure($options)
    {
    }

    /**
     * Dummy log.
     *
     * @param string $msg Message not to log.
     *
     * @return void
     */
    public final static function debug($msg)
    {
        return;
    }

    /**
     * Dummy log.
     *
     * @param string $msg Message not to log.
     *
     * @return void
     */
    public final static function warn($msg)
    {
        return;
    }

    /**
     * Dummy log.
     *
     * @param string $msg Message not to log.
     *
     * @return void
     */
    public final static function trace($msg)
    {
        return;
    }

    /**
     * Dummy log.
     *
     * @param string $msg Message not to log.
     *
     * @return void
     */
    public final static function error($msg)
    {
        return;
    }

    /**
     * Dummy log.
     *
     * @param string $msg Message not to log.
     *
     * @return void
     */
    public final static function fatal($msg)
    {
        return;
    }

    /**
     * Dummy log.
     *
     * @param string $msg Message not to log.
     *
     * @return void
     */
    public final static function info($msg)
    {
        return;
    }

    /**
     * Dummy is debug enabled?
     *
     * @return false
     */
    public final function isDebugEnabled()
    {
        return getenv('TEST') === 'true';
    }

    /**
     * Dummy constructor.
     *
     * @return void
     */
    protected final function __construct()
    {

    }
}
}