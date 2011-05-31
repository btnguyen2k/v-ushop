<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Wrapper for a SQLite connection.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @subpackage  Sqlite
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSqliteConnection.php 267 2011-05-23 09:06:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.2.2
 */

/**
 * An object of this class wraps a SQLite connection inside.
 *
 * @package     Dao
 * @subpackage  Sqlite
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2.2
 */
class Ddth_Dao_Sqlite_SqliteConnection {

    /**
     * @var bool
     */
    private $hasTransaction = FALSE;

    /**
     * @var resource
     */
    private $sqliteConn;

    /**
     * Constructs a new Ddth_Dao_Sqlite_SqliteConnection object.
     *
     * @param resource $sqliteConn a SQLite connection to wrap.
     */
    public function __construct($sqliteConn) {
        $this->sqliteConn = $sqliteConn;
    }

    /**
     * Gets the wrapped SQLite connection.
     *
     * @return resource
     */
    public function getSqliteConnection() {
        return $this->sqliteConn;
    }

    /**
     * Alias of {@link getSqliteConnection()}
     */
    public function getConn() {
        return $this->sqliteConn;
    }

    /**
     * Close the wrapped SQLite connection.
     *
     * @param bool $hasError indicates that an error has occurred during the usage of the connection
     */
    public function closeSqliteConnection($hasError = FALSE) {
        if ($this->sqliteConn === NULL) {
            $msg = 'The SQLite connection has already been closed!';
            throw new Ddth_Dao_DaoException($msg);
        }
        if ($this->hasTransaction) {
            if ($hasError) {
                $this->rollbackTransaction();
            } else {
                $this->commitTransaction();
            }
        }
        sqlite_close($this->sqliteConn);
        $this->sqliteConn = NULL;
    }

    /**
     * Alias of {@link closeSqliteConnection()}
     */
    public function closeConn($hasError = FALSE) {
        $this->closeSqliteConnection($hasError);
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
            sqlite_query("COMMIT TRANSACTION", $this->sqliteConn);
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
            sqlite_query("ROLLBACK TRANSACTION", $this->sqliteConn);
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
            sqlite_query("BEGIN TRANSACTION", $this->sqliteConn);
            $this->hasTransaction = TRUE;
        }
    }
}
?>
