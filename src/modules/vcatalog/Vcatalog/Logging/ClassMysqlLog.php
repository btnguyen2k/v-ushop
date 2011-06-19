<?php
/**
 * This class extends the {@link Ddth_Commons_Logging_AbstractLog} and utilize MySQL to store logs.
 *
 * @package     Vcatalog
 * @subpackage  Logging
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
class Vcatalog_Logging_MysqlLog extends Ddth_Commons_Logging_AbstractLog {

    const SETTING_MYSQL_HOST = 'mysql.host';
    const SETTING_MYSQL_PORT = 'mysql.port';
    const SETTING_MYSQL_USERNAME = 'mysql.username';
    const SETTING_MYSQL_PASSWORD = 'mysql.password';
    const SETTING_MYSQL_DBNAME = 'mysql.dbname';
    const SETTING_TABLE_NAME = 'mysql.table_name';

    private $mysqlHost, $mysqlPort, $mysqlUsername, $mysqlPassword, $mysqlDbName;
    private $tableName;

    /**
     * Initializes this logger.
     *
     * @param Array $config
     */
    public function init($config) {
        parent::init($config);
        $this->mysqlHost = isset($config[self::SETTING_MYSQL_HOST]) ? $config[self::SETTING_MYSQL_HOST] : 'localhost';
        $this->mysqlPort = isset($config[self::SETTING_MYSQL_PORT]) ? $config[self::SETTING_MYSQL_PORT] : 3306;
        $this->mysqlUsername = isset($config[self::SETTING_MYSQL_USERNAME]) ? $config[self::SETTING_MYSQL_USERNAME] : '';
        $this->mysqlPassword = isset($config[self::SETTING_MYSQL_PASSWORD]) ? $config[self::SETTING_MYSQL_PASSWORD] : '';
        $this->mysqlDbName = isset($config[self::SETTING_MYSQL_DBNAME]) ? $config[self::SETTING_MYSQL_DBNAME] : NULL;
        $this->tableName = isset($config[self::SETTING_TABLE_NAME]) ? $config[self::SETTING_TABLE_NAME] : NULL;

        if ($this->mysqlDbName === NULL || $this->mysqlDbName === '') {
            $msg = 'Please specify a MySQL database!';
            throw new Exception($msg);
        }
        if ($this->tableName === NULL || $this->tableName === '') {
            $msg = 'Please specify a MySQL table!';
            throw new Exception($msg);
        }
    }

    /**
     * Writes a log entry.
     *
     * @param string $logLevel
     * @param string $logMsg
     * @param Exception $e
     */
    protected function writeLog($logLevel, $logMsg, $e) {
        $conn = @mysql_connect($this->mysqlHost, $this->mysqlUsername, $this->mysqlPassword, TRUE);
        if ($conn === FALSE || $conn === NULL) {
            die("Can not connect to MySQL server {$this->mysqlHost}!");
        }
        if (!mysql_select_db($this->mysqlDbName, $conn)) {
            die("Can not switch to database {$this->mysqlDbName}!");
        }
        $stacktrace = $e !== NULL ? $e->getTraceAsString() : NULL;
        $className = $e !== NULL ? $e->getFile() : '';
        $sql = "INSERT INTO {$this->tableName} (logTimestamp, logLevel, logClass, logMessage, logStacktrace)";
        $sql .= "VALUES (";
        $sql .= time() . ",";
        $sql .= "'" . mysql_real_escape_string($logLevel, $conn) . "',";
        $sql .= "'" . mysql_real_escape_string($className, $conn) . "',";
        $sql .= "'" . mysql_real_escape_string($logMsg, $conn) . "',";
        $sql .= "'" . mysql_real_escape_string($stacktrace, $conn) . "')";
        mysql_query($sql, $conn);
        mysql_close($conn);
    }

    /**
     * Logs a message with debug log level.
     *
     * @param string
     * @param Exception
     */
    public function debug($message, $e = NULL) {
        if (!$this->isDebugEnabled()) {
            return;
        }
        $this->writeLog('DEBUG', $message, $e);
    }

    /**
     * Logs a message with error log level.
     *
     * @param string
     * @param Exception
     */
    public function error($message, $e = NULL) {
        if (!$this->isErrorEnabled()) {
            return;
        }
        $this->writeLog('ERROR', $message, $e);
    }

    /**
     * Logs a message with fatal log level.
     *
     * @param string
     * @param Exception
     */
    public function fatal($message, $e = NULL) {
        if (!$this->isFatalEnabled()) {
            return;
        }
        $this->writeLog('FATAL', $message, $e);
    }

    /**
     * Logs a message with info log level.
     *
     * @param string
     * @param Exception
     */
    public function info($message, $e = NULL) {
        if (!$this->isInfoEnabled()) {
            return;
        }
        $this->writeLog('INFO', $message, $e);
    }

    /**
     * Logs a message with trace log level.
     *
     * @param string
     * @param Exception
     */
    public function trace($message, $e = NULL) {
        if (!$this->isTraceEnabled()) {
            return;
        }
        $this->writeLog('TRACE', $message, $e);
    }

    /**
     * Logs a message with warn log level.
     *
     * @param string
     * @param Exception
     */
    public function warn($message, $e = NULL) {
        if (!$this->isWarnEnabled()) {
            return;
        }
        $this->writeLog('WARN', $message, $e);
    }
}