<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * PgSQL-specific {@link Ddth_Dao_SqlStatement}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @subpackage  Pgsql
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassPgsqlSqlStatement.php 272 2011-05-24 09:31:04Z btnguyen2k@gmail.com $
 * @since       File available since v0.2.3
 */

/**
 * PgSQL-specific {@link Ddth_Dao_SqlStatement}.
 *
 * @package    	Dao
 * @subpackage  Pgsql
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2.3
 */
class Ddth_Dao_Pgsql_PgsqlSqlStatement extends Ddth_Dao_SqlStatement {
    /**
     * @see Ddth_Dao_SqlStatement::escape()
     */
    protected function escape($conn, $value, $bytea = FALSE) {
        return $bytea ? pg_escape_string($conn, $value) : pg_escape_bytea($conn, $value);
    }

    /**
     * @see Ddth_Dao_SqlStatement::doExecute()
     */
    protected function doExecute($preparedSql, $conn) {
        $result = pg_query($conn, $preparedSql);
        if ($result === FALSE) {
            throw new Ddth_Dao_DaoException(pg_last_error($conn));
        }
        return $result;
    }
}
?>
