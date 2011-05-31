<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * An abstract named logger.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Commons
 * @subpackage  Logging
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAbstractLog.php 255 2010-12-27 09:55:32Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * An abstract named logger.
 *
 * This class is the top level abstract class of all other concrete named
 * logger implementations.
 *
 * @package     Commons
 * @subpackage  Logging
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
abstract class Ddth_Commons_Logging_AbstractLog implements Ddth_Commons_Logging_ILog {
    /**
     * @var string
     */
    private $className;

    /**
     * @var Array
     */
    private $settings;

    private $isTrace = false;
    private $isDebug = false;
    private $isInfo = false;
    private $isWarn = false;
    private $isError = false;
    private $isFatal = false;

    /**
     * Constructs an new Ddth_Commons_Logging_AbstractLog object.
     *
     * @param $className logical name of the logger (usually name of a class)
     */
    public function __construct($className) {
        $this->className = $className;
    }

    /**
     * Initializes this logger.
     *
     * @param Array $config
     */
    public function init($config) {
        //normalize class name
        if ( !is_string($this->className) ) {
            $this->className = NULL;
        }
        if ( $this->className !== NULL ) {
            $this->className = trim(str_replace('::', '_', $this->className));
        }

        $this->settings = $config;

        //set up logging level
        $loggerClazzs = Array();
        $needle = Ddth_Commons_Logging_ILog::SETTING_PREFIX_LOGGER_CLASS;
        foreach ( $config as $key=>$value ) {
            $pos = strpos($key, $needle);
            if ( $pos !== false ) {
                $loggerClazzs[] = substr($key, $pos+strlen($needle));
            }
        }
        sort($loggerClazzs);
        $loggerClazzs = array_reverse($loggerClazzs);
        $found = false;
        $level = NULL;
        foreach ( $loggerClazzs as $clazz ) {
            if ( $this->className === $clazz || strpos($this->className, $clazz.'_')!==false ) {
                $key = Ddth_Commons_Logging_ILog::SETTING_PREFIX_LOGGER_CLASS.$clazz;
                $level = trim(strtoupper($config[$key]));
                $found = true;
                break;
            }
        }

        if ( !$found ) {
            $key = Ddth_Commons_Logging_ILog::SETTING_DEFAULT_LOG_LEVEL;
            $level = trim(strtoupper($config[$key]));
        }

        switch ($level) {
            case 'TRACE':
                $this->isTrace = true;
            case 'DEBUG':
                $this->isDebug = true;
            case 'INFO':
                $this->isInfo = true;
            case 'WARN':
                $this->isWarn = true;
            case 'ERROR':
                $this->isError = true;
            case 'FATAL':
                $this->isFatal = true;
            default:
                //default level = ERROR
                $this->isError = true;
                $this->isFatal = true;
        }
    }

    /**
     * Is debug logging currently enabled?
     *
     * @return bool
     */
    public function isDebugEnabled() {
        return $this->isDebug;
    }

    /**
     * Is error logging currently enabled?
     *
     * @return bool
     */
    public function isErrorEnabled() {
        return $this->isError;
    }

    /**
     * Is fatal logging currently enabled?
     *
     * @return bool
     */
    public function isFatalEnabled() {
        return $this->isFatal;
    }

    /**
     * Is info logging currently enabled?
     *
     * @return bool
     */
    public function isInfoEnabled() {
        return $this->isInfo;
    }

    /**
     * Is trace logging currently enabled?
     *
     * @return bool
     */
    public function isTraceEnabled() {
        return $this->isTrace;
    }

    /**
     * Is warn logging currently enabled?
     *
     * @return bool
     */
    public function isWarnEnabled() {
        return $this->isWarn;
    }
}
?>
