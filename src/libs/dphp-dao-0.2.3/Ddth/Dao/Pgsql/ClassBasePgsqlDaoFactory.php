<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create {@link Ddth_Dao_Pgsql_IPgsqlDao} instances.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @subpackage  Pgsql
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassBasePgsqlDaoFactory.php 272 2011-05-24 09:31:04Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * Factory to create {@link Ddth_Dao_Pgsql_IPgsqlDao} instances. This can be used as a base
 * implementation of PostgreSQL-based DAO factory.
 *
 * This factory uses the same configuration array as {@link Ddth_Dao_BaseDaoFactory}, with additional
 * configurations:
 * <code>
 * Array(
 * #other configurations used by Ddth_Dao_Pgsql_BasePgsqlDaoFactory
 *
 * # PostgreSQL connection string
 * # See http://php.net/manual/en/function.pg-connect.php for more information
 * 'dphp-dao.pgsql.persistent'
 * => FALSE,   #indicate if pgsql_pconnect (TRUE) or pgsql_connect (FALSE) is used. Default value is FALSE
 * 'dphp-dao.pgsql.connectionString'
 * => "host=localhost port=5432 dbname=testdb user=foouser password=barpwd options='--client_encoding=UTF8'"
 * )
 * </code>
 *
 * @package     Dao
 * @subpackage  Pgsql
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2
 */
class Ddth_Dao_Pgsql_BasePgsqlDaoFactory extends Ddth_Dao_AbstractConnDaoFactory {

    const CONF_PGSQL_CONNECTION_STRING = 'dphp-dao.pgsql.connectionString';
    const CONF_PGSQL_PERSISTENT = 'dphp-dao.pgsql.persistent';

    private $pgsqlConnectionString = '';
    private $pgsqlPersistent = FALSE;

    /**
     * Constructs a new Ddth_Dao_Pgsql_BasePgsqlDaoFactory object.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @see Ddth_Dao_IDaoFactory::init();
     */
    public function init($config) {
        parent::init($config);
        $this->pgsqlConnectionString = isset($config[self::CONF_PGSQL_CONNECTION_STRING]) ? $config[self::CONF_PGSQL_CONNECTION_STRING] : '';

        $this->pgsqlPersistent = isset($config[self::CONF_PGSQL_PERSISTENT]) ? $config[self::CONF_PGSQL_PERSISTENT] : FALSE;
    }

    /**
     * Gets the PostgreSQL connection string.
     *
     * @return string
     */
    protected function getPgsqlConnectionString() {
        return $this->pgsqlConnectionString;
    }

    /**
     * Sets the PostgreSQL connection string.
     * @param string $connectionString
     */
    protected function setPgsqlConnectionString($connectionString) {
        $this->pgsqlConnectionString = $connectionString;
    }

    /**
     * Gets the PostgreSQL persistent setting.
     *
     * @return bool
     */
    protected function getPgsqlPersistent() {
        return $this->pgsqlPersistent;
    }

    /**
     * Sets the PostgreSQL persistent setting.
     * @param bool $persistent
     */
    protected function setPgsqlPersistent($persistent) {
        $this->pgsqlPersistent = $persistent;
    }

    /**
     * Gets a DAO by name.
     *
     * @param string $name
     * @return Ddth_Dao_Pgsql_IPgsqlDao
     * @throws Ddth_Dao_DaoException
     */
    public function getDao($name) {
        $dao = parent::getDao($name);
        if ($dao !== NULL && !($dao instanceof Ddth_Dao_Pgsql_IPgsqlDao)) {
            $msg = 'DAO [' . $name . '] is not of type [Ddth_Dao_Pgsql_IPgsqlDao]!';
            throw new Ddth_Dao_DaoException($msg);
        }
        return $dao;
    }

    /**
     * This function returns an object of type {@link Ddth_Dao_Pgsql_PgsqlConnection}.
     *
     * @see Ddth_Dao_AbstractConnDaoFactory::createConnection()
     */
    protected function createConnection($startTransaction = FALSE) {
        $pgsqlConn = NULL;
        if ($this->pgsqlPersistent) {
            $pgsqlConn = @pg_pconnect($this->pgsqlConnectionString);
        } else {
            $pgsqlConn = @pg_connect($this->pgsqlConnectionString);
        }
        if ($pgsqlConn === FALSE || $pgsqlConn === NULL) {
            throw new Ddth_Dao_DaoException('Can not make connection to PostgreSQL server!');
        }
        $result = new Ddth_Dao_Pgsql_PgsqlConnection($pgsqlConn);
        if ($startTransaction) {
            $result->startTransaction();
        }
        return $result;
    }

    /**
     * This function expects the first argument is of type {@link Ddth_Dao_Pgsql_PgsqlConnection}.
     *
     * @see Ddth_Dao_AbstractConnDaoFactory::forceCloseConnection()
     */
    protected function forceCloseConnection($conn, $hasError = FALSE) {
        if ($conn instanceof Ddth_Dao_Pgsql_PgsqlConnection) {
            $conn->closeConn($hasError);
        } else {
            $msg = 'I expect the first parameter is of type [Ddth_Dao_Pgsql_PgsqlConnection]!';
            throw new Ddth_Dao_DaoException($msg);
        }
    }
}
?>
