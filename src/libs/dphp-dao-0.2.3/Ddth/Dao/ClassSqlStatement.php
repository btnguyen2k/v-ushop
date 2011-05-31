<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * SQL query wrapper.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSqlStatement.php 267 2011-05-23 09:06:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.2.2
 */

/**
 * SQL query wrapper.
 *
 * This class encapsulates an SQL statement, which is a SQL query with placeholders.
 * For example: <i>SELECT * FROM tbl_user WHERE id=${id}</i>.
 *
 * Note: do NOT use quotes (' or ") around the place-holders. Single quotes (') will be
 * automatically added when needed.
 *
 * Usage:
 * <code>
 * //obtain a db connection
 * $dbConn = ...;
 *
 * //construct a Ddth_Dao_SqlStatement object
 * $sql = 'SELECT * FROM tbl_user WHERE id=${id}';
 * $sqlStm = new Ddth_Dao_Mysql_MysqlSqlStatement($sql);
 *
 * //execute the query
 * $values = Array('id' => 1);
 * $result = $sqlStm->execute($dbConn, $values);
 *
 * //another way to execute the query
 * $values = Array('id' => 1);
 * $sql = $sqlStm->prepare($dbConn, $values);
 * $result = mysql_query($sql, $dbConn);
 * </code>
 *
 * Another example using {@link Ddth_Dao_SqlStatementFactory}:
 * <code>
 * //obtain a db connection
 * $dbConn = ...;
 *
 * $configFile = 'user-dao.sql.properties';
 * $dbConnFactory = Ddth_Dao_SqlStatementFactory::getInstance($configFile);
 *
 * $sqlStm = $dbConnFactory->getSqlStatement('selectUserById');
 * $values = Array('id' => 1);
 * $resultSet = $sqlStm->execute($dbConn, $value);
 * </code>
 *
 * @package    	Dao
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2.2
 */
abstract class Ddth_Dao_SqlStatement {

    private $sql = '';

    /**
     * Constructs a new Ddth_Dao_SqlStatement object.
     *
     * @param string $sql
     */
    public function __construct($sql = '') {
        $this->setSql($sql);
    }

    /**
     * Gets the sql query.
     * @return string
     */
    public function getSql() {
        return $this->sql;
    }

    /**
     * Sets the sql command.
     * @param string
     */
    public function setSql($sql) {
        $this->sql = $sql;
    }

    /**
     * Prepares the SQL statement.
     *
     * @param mixed $conn an open database connection
     * @param Array $values parameters to be bind to the query (an associative array)
     * @return string the prepared SQL statement
     */
    public function prepare($conn, $values = Array()) {
        $sql = $this->sql;
        foreach ($values as $key => $value) {
            $v = $this->escape($conn, $value);
            if (is_string($value)) {
                $v = "'$v'";
            }
            $sql = str_replace('${' . $key . '}', $v, $sql);
        }
        return $sql;
    }

    /**
     * Escapes a value to be used in a SQL statement. Sub-class must implement this function.
     *
     * Note: sub-class should not add quotes (" or ') around the value, leave that to
     * {@link prepare()} function.
     *
     * @param mixed $conn an open database connection
     * @param mixed $value the value to escape
     * @return string the escaped string
     */
    protected abstract function escape($conn, $value);

    /**
     * Prepares and executes the statement.
     *
     * @param mixed $conn an open database connection
     * @param Array $values parameters to be bind to the query (an associative array)
     * @return mixed
     */
    public function execute($conn, $values = Array()) {
        $sql = $this->prepare($conn, $values);
        return $this->doExecute($sql, $conn);
    }

    /**
     * Executes the prepared sql query. Sub-class must implement this function.
     *
     * @param string $preparedSql the prepared sql query
     * @param mixed $conn an open database connection
     * @return mixed
     */
    protected abstract function doExecute($preparedSql, $conn);
}
?>
