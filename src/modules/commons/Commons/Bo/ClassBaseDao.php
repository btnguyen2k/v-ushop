<?php
abstract class Commons_Bo_BaseDao extends Ddth_Dao_AbstractSqlStatementDao {
    /**
     * Fetches result from the result set and returns as an associative array.
     *
     * @param resource $rs
     */
    protected abstract function fetchResultAssoc($rs);

    /**
     * Fetches result from the result set and returns as an index array.
     *
     * @param resource $rs
     */
    protected abstract function fetchResultArr($rs);

    /**
     * Gets a {@link Ddth_Dao_SqlStatement} object, throws exception if not found.
     *
     * @param string $name name of the statement to get
     * @return Ddth_Dao_SqlStatement
     */
    protected function getStatement($name) {
        $stm = $this->getSqlStatement($name);
        if ($stm === NULL) {
            $msg = "Can not obtain the statement [$name]!";
            throw new Exception($msg);
        }
        return $stm;
    }
}