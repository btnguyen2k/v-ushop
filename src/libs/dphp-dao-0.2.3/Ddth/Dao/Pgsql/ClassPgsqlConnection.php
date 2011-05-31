<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Wrapper for a PostgreSQL connection.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @subpackage  Pgsql
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassPgsqlConnection.php 267 2011-05-23 09:06:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * An object of this class wraps a PostgreSQL connection inside.
 *
 * @package     Dao
 * @subpackage  Pgsql
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2
 */
class Ddth_Dao_Pgsql_PgsqlConnection {

    /**
     * @var bool
     */
    private $hasTransaction = FALSE;

    /**
     * @var resource
     */
    private $pgsqlConn;

    /**
     * Constructs a new Ddth_Dao_Pgsql_PgsqlConnection object.
     *
     * @param resource $pgsqlConn a PostgreSQL connection to wrap.
     */
    public function __construct($pgsqlConn) {
        $this->pgsqlConn = $pgsqlConn;
    }

    /**
     * Gets the wrapped PostgreSQL connection.
     *
     * @return resource
     */
    public function getPgsqlConnection() {
        return $this->pgsqlConn;
    }

    /**
     * Alias of {@link getPgsqlConnection()}
     */
    public function getConn() {
        return $this->pgsqlConn;
    }

    /**
     * Close the wrapped PostgreSQL Connection.
     *
     * @param bool $hasError indicates that an error has occurred during the usage of the connection
     */
    public function closePgsqlConnection($hasError = FALSE) {
        if ($this->pgsqlConn === NULL) {
            $msg = 'The PostgreSQL connection has already been closed!';
            throw new Ddth_Dao_DaoException($msg);
        }
        if ($this->hasTransaction) {
            if ($hasError) {
                $this->rollbackTransaction();
            } else {
                $this->commitTransaction();
            }
        }
        pg_close($this->pgsqlConn);
        $this->pgsqlConn = NULL;
    }

    /**
     * Alias of {@link closePgsqlConnection()}
     */
    public function closeConn($hasError = FALSE) {
        $this->closePgsqlConnection($hasError);
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
