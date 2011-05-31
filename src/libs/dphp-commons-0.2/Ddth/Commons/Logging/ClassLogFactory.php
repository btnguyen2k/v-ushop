<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create {@link Ddth_Commons_Logging_ILog} instances.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Commons
 * @subpackage  Logging
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassLogFactory.php 255 2010-12-27 09:55:32Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Factory to create {@link Ddth_Commons_Logging_ILog} instances.
 *
 * Usage:
 * <code>
 * $logger = Ddth_Commons_Logging_LogFactory::getLog($logName, $config);
 * $logger->debug('Debug message');
 * $logger->error('Error message', $exception);
 * </code>
 * See {@link Ddth_Commons_Logging_LogFactory::getLog()} for configuration details.
 *
 * Note: {@link ClassLoader.php Classes and files naming conventions}.
 *
 * Note: The APIs of this package mimics Apache's commons-logging library.
 *
 * @package     Commons
 * @subpackage  Logging
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
final class Ddth_Commons_Logging_LogFactory {

    const SETTING_LOGGER = "ddth.commons.logging.Logger";
    const SETTING_PREFIX_LOGGER_SETTING = "logger.setting.";

    const DEFAULT_LOGGER = "Ddth_Commons_Logging_SimpleLog";

    /**
     * Gets a named logger.
     *
     * This function accepts an associative array as parameter. If the argument is NULL,
     * the global variable $DPHP_COMMONS_LOGGING_CONFIG is used instead (if there is no global
     * variable $DPHP_COMMONS_LOGGING_CONFIG, the function falls back to use the global variable
     * $DPHP_COMMONS_LOGGING_CONF).
     *
     * Detailed specs of the configuration array:
     * <code>
     * Array(
     *     # Class name of the logger (an implementation of ILog)
     *     # Default value is Ddth_Commons_Logging_SimpleLog
     *     'ddth.commons.logging.Logger' => 'Ddth_Commons_Logging_SimpleLog',
     *
     *     # logger.setting.xxx=setting xxx for the underlying logger
     *     'logger.setting.default' => 'default log level (TRACE, DEBUG, INFO, WARN, ERROR, or FATAL)',
     *
     *     # The following settings are used by class AbstractLog:
     *     # Set DEBUG log level for package Ddth
     *     'logger.setting.loggerClass.Ddth'                    => 'DEBUG',
     *
     *     # Set INFO log level for package Ddth_Commons
     *     'logger.setting.loggerClass.Ddth_Commons'            => 'INFO',
     *
     *     # Set WARN log level for class Ddth_Commons_LogFactory
     *     'logger.setting.loggerClass.Ddth_Commons_LogFactory' => 'WARN'
     * )
     * </code>
     *
     * @param string $className name of the logger (usually name of the current class)
     * @param Array $config the configuration array
     * @return Ddth_Commons_Logging_ILog
     */
    public static function getLog($className, $config=NULL) {
        if ( $config === NULL ) {
            global $DPHP_COMMONS_LOGGING_CONFIG;
            $config = isset($DPHP_COMMONS_LOGGING_CONFIG)?$DPHP_COMMONS_LOGGING_CONFIG:NULL;
        }
        if ( $config === NULL ) {
            global $DPHP_COMMONS_LOGGING_CONF;
            $config = isset($DPHP_COMMONS_LOGGING_CONF)?$DPHP_COMMONS_LOGGING_CONF:NULL;
        }
        if ( $config === NULL ) {
            global $DPHP_COMMONS_LOGGING_CFG;
            $config = isset($DPHP_COMMONS_LOGGING_CFG)?$DPHP_COMMONS_LOGGING_CFG:NULL;
        }
        if ( $config === NULL ) {
            return NULL;
        }
        $loggerClass = isset($config[self::SETTING_LOGGER])?$config[self::SETTING_LOGGER]:NULL;
        if ( $loggerClass === NULL || trim($loggerClass)==="" ) {
            $loggerClass = self::DEFAULT_LOGGER;
        }
        try {
            $log = new $loggerClass($className);
            $loggerConfig = self::buildLogConfig($config);
            $log->init($loggerConfig);
            return $log;
        } catch (Ddth_Commons_Logging_LogConfigurationException $lce) {
            throw $lce;
        } catch (Exception $e) {
            $msg = '['.$e->getMessage().']\n'.$e->getTraceAsString();
            throw new Ddth_Commons_Logging_LogConfigurationException($msg);
        }
    }

    /**
     * Builds logger configuration settings from factory configuration settings.
     *
     * @param Array $factoryConfig factory configuration settings. See {@link getLog()} for more information
     * @return Array the logger configurations built from the factory configuration settings
     */
    private static function buildLogConfig($factoryConfig) {
        $loggerConfig = Array();
        foreach ( $factoryConfig as $key=>$value ) {
            $found = strpos($key, self::SETTING_PREFIX_LOGGER_SETTING);
            if ( $found !== false ) {
                $k = substr($key, $found+strlen(self::SETTING_PREFIX_LOGGER_SETTING));
                $loggerConfig[$k] = $value;
            }
        }
        return $loggerConfig;
    }
}
?>
