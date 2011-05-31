<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Wrapper for a MySQL connection.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @subpackage  Mysql
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassMysqlConnection.php 267 2011-05-23 09:06:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * An object of this class wraps a MySQL connection inside.
 *
 * @package     Dao
 * @subpackage  Mysql
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Ddth_Dao_Mysql_MysqlConnection {

    /**
     * @var bool
     */
    private $hasTransaction = FALSE;

    /**
     * @var resource
     */
    private $mysqlConn;

    /**
     * Constructs a new Ddth_Dao_Mysql_MysqlConnection object.
     *
     * @param resource $mysqlConn a MySQL connection to wrap.
     */
    public function __construct($mysqlConn) {
        $this->mysqlConn = $mysqlConn;
    }

    /**
     * Gets the wrapped MySQL connection.
     *
     * @return resource
     */
    public function getMysqlConnection() {
        return $this->mysqlConn;
    }

    /**
     * Alias of {@link getMysqlConnection()}
     */
    public function getConn() {
        return $this->mysqlConn;
    }

    /**
     * Close the wrapped MySQL Connection.
     *
     * @param bool $hasError indicates that an error has occurred during the usage of the connection
     */
    public function closeMysqlConnection($hasError = FALSE) {
        if ($this->mysqlConn === NULL) {
            $msg = 'The MySQL connection has already been closed!';
            throw new Ddth_Dao_DaoException($msg);
        }
        if ($this->hasTransaction) {
            if ($hasError) {
                $this->rollbackTransaction();
            } else {
                $this->commitTransaction();
            }
        }
        mysql_close($this->mysqlConn);
        $this->mysqlConn = NULL;
    }

    /**
     * Alias of {@link closeMysqlConnection()}
     */
    public function closeConn($hasError = FALSE) {
        $this->closeMysqlConnection($hasError);
    }

    /**
     * Checks if the connection is inside a transaction.
     *
     * @return bool
     */
    public function hasTransaction() {
        return $this->hasTransaction;
    }

    /**
     * Commits the current transaction (if any).
     *
     * @return bool FALSE if there is no current transaction, TRUE otherwise
     */
    public function commitTransaction() {
        if ($this->hasTransaction) {
            mysql_query("COMMIT", $this->mysqlConn);
            $this->hasTransaction = FALSE;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Rollbacks the current transaction (if any).
     *
     * @return bool FALSE if there is no current transaction, TRUE otherwise
     */
    public function rollbackTransaction() {
        if ($this->hasTransaction) {
            mysql_query("ROLLBACK", $this->mysqlConn);
            $this->hasTransaction = FALSE;
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Starts a transaction.
     */
    public function startTransaction() {
        if (!$this->hasTransaction) {
            mysql_query("BEGIN", $this->mysqlConn);
            $this->hasTransaction = TRUE;
        }
    }
}
?>
