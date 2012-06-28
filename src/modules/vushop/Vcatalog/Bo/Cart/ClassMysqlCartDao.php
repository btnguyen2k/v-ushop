<?php
class Vcatalog_Bo_Cart_MysqlCartDao extends Vcatalog_Bo_Cart_BaseCartDao implements
        Ddth_Dao_Mysql_IMysqlDao {

    protected function initSqlStatementFactory() {
        $this->setSqlStatementFile('Vcatalog/Bo/Cart/sql_cart.mysql.properties');
        parent::initSqlStatementFactory();
    }

    protected function fetchResultAssoc($rs) {
        return mysql_fetch_array($rs, MYSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return mysql_fetch_array($rs, MYSQL_NUM);
    }
}
