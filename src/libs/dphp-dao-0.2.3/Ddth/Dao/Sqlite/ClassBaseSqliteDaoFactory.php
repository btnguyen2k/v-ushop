<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create {@link Ddth_Dao_Sqlite_ISqliteDao} instances.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @subpackage  Sqlite
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassBaseSqliteDaoFactory.php 272 2011-05-24 09:31:04Z btnguyen2k@gmail.com $
 * @since       File available since v0.2.2
 */

/**
 * Factory to create {@link Ddth_Dao_Sqlite_ISqliteDao} instances. This can be used as a base
 * implementation of SQLite-based DAO factory.
 *
 * This factory uses the same configuration array as {@link Ddth_Dao_BaseDaoFactory}, with additional
 * configurations:
 * <code>
 * Array(
 * #other configurations used by Ddth_Dao_Sqlite_BaseSqliteDaoFactory
 *
 * # SQLite filename and mode
 * # See http://www.php.net/manual/en/function.sqlite-open.php for more information
 * 'dphp-dao.sqlite.filename'   => '/tmp/user.db',
 * 'dphp-dao.sqlite.mode'       => 0666, #default value is 0666
 * 'dphp-dao.sqlite.persistent' => FALSE
 * #indicate if sqlite_popen (TRUE) or sqlite_open (FALSE) is used. Default value is FALSE
 * )
 * </code>
 *
 * @package     Dao
 * @subpackage  Sqlite
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2.2
 */
class Ddth_Dao_Sqlite_BaseSqliteDaoFactory extends Ddth_Dao_AbstractConnDaoFactory {

    const DEFAULT_FILE_MODE = 0666;

    const CONF_SQLITE_FILENAME = 'dphp-dao.sqlite.filename';
    const CONF_SQLITE_MODE = 'dphp-dao.sqlite.mode';
    const CONF_SQLITE_PERSISTENT = 'dphp-dao.sqlite.persistent';

    private $sqliteFilename = NULL;
    private $sqliteMode = 0666;
    private $sqlitePersistent = FALSE;

    /**
     * Constructs a new Ddth_Dao_Sqlite_BaseSqliteDaoFactory object.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @see Ddth_Dao_IDaoFactory::init();
     */
    public function init($config) {
        parent::init($config);
        $this->sqliteFilename = isset($config[self::CONF_SQLITE_FILENAME]) ? $config[self::CONF_SQLITE_FILENAME] : NULL;
        $this->sqliteMode = isset($config[self::CONF_SQLITE_MODE]) ? ($config[self::CONF_SQLITE_MODE] + 0) : self::DEFAULT_FILE_MODE;
        $this->sqlitePersistent = isset($config[self::CONF_SQLITE_PERSISTENT]) ? $config[self::CONF_SQLITE_PERSISTENT] : FALSE;
    }

    /**
     * Gets the SQLite persistent setting.
     *
     * @return bool
     */
    protected function getSqlitePersistent() {
        return $this->sqlitePersistent;
    }

    /**
     * Sets the SQLite persistent setting.
     * @param bool $persistent
     */
    protected function setSqlitePersistent($persistent) {
        $this->sqlitePersistent = $persistent;
    }

    /**
     * Gets the SQLite filename.
     *
     * @return string
     */
    protected function getSqliteFilename() {
        return $this->sqliteFilename;
    }

    /**
     * Sets the SQLite filename.
     * @param string $filename
     */
    protected function setSqliteFilename($filename) {
        $this->sqliteFilename = $filename;
    }

    /**
     * Gets the file mode.
     *
     * @return int
     */
    protected function getSqlliteMode() {
        return $this->sqliteMode;
    }

    /**
     * Sets the file mode.
     * @param int $mode
     */
    protected function setSqliteMode($mode) {
        $this->sqliteMode = $mode;
    }

    /**
     * Gets a DAO by name.
     *
     * @param string $name
     * @return Ddth_Dao_Sqlite_ISqliteDao
     * @throws Ddth_Dao_DaoException
     */
    public function getDao($name) {
        $dao = parent::getDao($name);
        if ($dao !== NULL && !($dao instanceof Ddth_Dao_Sqlite_ISqliteDao)) {
            $msg = 'DAO [' . $name . '] is not of type [Ddth_Dao_Sqlite_ISqliteDao]!';
            throw new Ddth_Dao_DaoException($msg);
        }
        return $dao;
    }

    /**
     * This function returns an object of type {@link Ddth_Dao_Sqlite_SqliteConnection}.
     *
     * @see Ddth_Dao_AbstractConnDaoFactory::createConnection()
     */
    protected function createConnection($startTransaction = FALSE) {
        $sqliteConn = NULL;
        if ($this->sqlitePersistent) {
            $sqliteConn = @sqlite_popen($this->sqliteFilename, $this->sqliteMode);
        } else {
            $sqliteConn = @sqlite_open($this->sqliteFilename, $this->sqliteMode);
        }
        if ($sqliteConn === FALSE || $sqliteConn === NULL) {
            $msg = "Can not create the SQLite connection ({$this->sqliteFilename}:{$this->sqliteMode})!";
            throw new Ddth_Dao_DaoException($msg);
        }
        $result = new Ddth_Dao_Sqlite_SqliteConnection($sqliteConn);
        if ($startTransaction) {
            $result->startTransaction();
        }
        return $result;
    }

    /**
     * This function expects the first argument is of type {@link Ddth_Dao_Sqlite_SqliteConnection}.
     *
     * @see Ddth_Dao_AbstractConnDaoFactory::forceCloseConnection()
     */
    protected function forceCloseConnection($conn, $hasError = FALSE) {
        if ($conn instanceof Ddth_Dao_Sqlite_SqliteConnection) {
            try {
                $conn->closeConn($hasError);
            } catch ( Ddth_Dao_DaoException $de ) {
                //ignore the case when the connection is closed twice
            }
        } else {
            $msg = 'I expect the first parameter is of type [Ddth_Dao_Sqlite_SqliteConnection]!';
            throw new Ddth_Dao_DaoException($msg);
        }
    }
}
?>
