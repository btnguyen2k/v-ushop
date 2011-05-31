<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Simple logger that sends log messages to PHP's system logger.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Commons
 * @subpackage  Logging
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSimpleLog.php 255 2010-12-27 09:55:32Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Simple logger that sends log messages to PHP's system logger.
 *
 * This logger uses {@link http://www.php.net/error_log error_log()}
 * function to send log messages to PHP's system logger.
 *
 * This logger has several settings which can be set via log factory configuration array:
 * <code>
 * Array(
 *     # Format of the log message (multiline is supported!)
 *     # Supported "placeholder" tags:
 *     # - {datetime}: date/time when the log is created. Date/time follows
 *     #           follow PHP's date() format (see http://www.php.net/date)
 *     # - {level}: log level (one of TRACE, DEBUG, INFO, WARN, ERROR, FATAL)
 *     # - {message}: log message
 *     # - {stacktrace}: stacktrace (if any)
 *     # - {message_auto_stacktrace}: log message, then if stacktrace exists, followed
 *     #           by a newline chacter and the stacktrace
 *     # - {nl}: newline character
 *     'logger.setting.simple.logFormat' => '{level}: {message_auto_stacktrace}',
 *
 *     # Date/time format (follow PHP's date() format, see http://www.php.net/date)
 *     'logger.setting.simple.datetimeFormat' => 'Y-m-d H:i:s'
 * )
 * </code>
 *
 * Note: since PHP automatically adds timestamp to any log message, the default
 * log message format is "{level}: {message_auto_stacktrace}".
 *
 *
 * @package     Commons
 * @subpackage  Logging
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
class Ddth_Commons_Logging_SimpleLog extends Ddth_Commons_Logging_AbstractLog {
    /**
     * Default log message format.
     */
    const DEFAULT_LOG_FORMAT = '{level}: {message_auto_stacktrace}';

    /**
     * Default date/time format
     */
    const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * Configuration etting key for log message format
     */
    const SETTING_LOG_FORMAT = 'simple.logFormat';

    /**
     * Configuration etting key for date/time format
     */
    const SETTING_DATETIME_FORMAT = 'simple.datetimeFormat';

    const PLACE_HOLDER_NL                  = '{nl}';

    const PLACE_HOLDER_DATETIME            = '{datetime}';

    const PLACE_HOLDER_LEVEL               = '{level}';

    const PLACE_HOLDER_MESSAGE             = '{message}';

    const PLACE_HOLDER_STACKTRACE          = '{stacktrace}';

    const PLACE_HOLDER_MSG_AUTO_STACKTRACE = '{message_auto_stacktrace}';

    private $logFormat = NULL;

    private $datetimeFormat = NULL;

    /**
     * Constructs an new Ddth_Commons_Logging_AbstractLog object.
     *
     * @param logical name of the logger
     */
    public function __construct($className) {
        parent::__construct($className);
    }

    /**
     * Initializes this logger.
     *
     * @param Array $config
     */
    public function init($config) {
        parent::init($config);

        //retrieves configuration settings
        $logFormat = isset($config[self::SETTING_LOG_FORMAT])?$config[self::SETTING_LOG_FORMAT]:NULL;
        $datetimeFormat = isset($config[self::SETTING_DATETIME_FORMAT])?$config[self::SETTING_DATETIME_FORMAT]:NULL;

        //setup log message format
        if ( $logFormat === NULL || trim($logFormat) === "" ) {
            $logFormat = self::DEFAULT_LOG_FORMAT;
        }
        $this->logFormat = trim($logFormat);

        //setup date/time format
        if ( $datetimeFormat === NULL || trim($datetimeFormat) === "" ) {
            $datetimeFormat = self::DEFAULT_DATETIME_FORMAT;
        }
        $this->datetimeFormat = trim($datetimeFormat);
    }

    private function buildLogMessage($level, $message, $e=NULL) {
        $datetime = date($this->datetimeFormat, time());
        $level = strtoupper($level);
        $stacktrace = $e!==NULL ? $e->getTraceAsString() : NULL;
        $msgAutoStacktrace = $message;
        if ( $e !== NULL ) {
            $msgAutoStacktrace .= "\n" . $e->getTraceAsString();
        }
        $msg = $this->logFormat;
        $msg = str_ireplace(self::PLACE_HOLDER_NL, "\n", $msg);
        $msg = str_ireplace(self::PLACE_HOLDER_DATETIME, $datetime, $msg);
        $msg = str_ireplace(self::PLACE_HOLDER_LEVEL, strtoupper($level), $msg);
        $msg = str_ireplace(self::PLACE_HOLDER_MESSAGE, $message, $msg);
        $msg = str_ireplace(self::PLACE_HOLDER_MSG_AUTO_STACKTRACE, $msgAutoStacktrace, $msg);
        if ( $stacktrace !== NULL ) {
            $msg = str_ireplace(self::PLACE_HOLDER_STACKTRACE, $stacktrace, $msg);
        }
        return $msg;
    }

    /**
     * Logs a message with debug log level.
     *
     * @param string
     * @param Exception
     */
    public function debug($message, $e = NULL) {
        if ( !$this->isDebugEnabled() ) return;
        $msg = $this->buildLogMessage('DEBUG', $message, $e);
        error_log($msg, 0 /* PHP's system logger */);
    }

    /**
     * Logs a message with error log level.
     *
     * @param string
     * @param Exception
     */
    public function error($message, $e = NULL) {
        if ( !$this->isErrorEnabled() ) return;
        $msg = $this->buildLogMessage('ERROR', $message, $e);
        error_log($msg, 0 /* PHP's system logger */);
    }

    /**
     * Logs a message with fatal log level.
     *
     * @param string
     * @param Exception
     */
    public function fatal($message, $e = NULL) {
        if ( !$this->isFatalEnabled() ) return;
        $msg = $this->buildLogMessage('FATAL', $message, $e);
        error_log($msg, 0 /* PHP's system logger */);
    }

    /**
     * Logs a message with info log level.
     *
     * @param string
     * @param Exception
     */
    public function info($message, $e = NULL) {
        if ( !$this->isInfoEnabled() ) return;
        $msg = $this->buildLogMessage('INFO', $message, $e);
        error_log($msg, 0 /* PHP's system logger */);
    }

    /**
     * Logs a message with trace log level.
     *
     * @param string
     * @param Exception
     */
    public function trace($message, $e = NULL) {
        if ( !$this->isTraceEnabled() ) return;
        $msg = $this->buildLogMessage('TRACE', $message, $e);
        error_log($msg, 0 /* PHP's system logger */);
    }

    /**
     * Logs a message with warn log level.
     *
     * @param string
     * @param Exception
     */
    public function warn($message, $e = NULL) {
        if ( !$this->isWarnEnabled() ) return;
        $msg = $this->buildLogMessage('WARN', $message, $e);
        error_log($msg, 0 /* PHP's system logger */);
    }
}
?>
