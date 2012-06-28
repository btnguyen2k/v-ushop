<?php
class Vushop_Bo_Catalog_MysqlCatalogDao extends Vushop_Bo_Catalog_BaseCatalogDao implements
        Ddth_Dao_Mysql_IMysqlDao {

    protected function initSqlStatementFactory() {
        $this->setSqlStatementFile('Vushop/Bo/Catalog/sql_catalog.mysql.properties');
        parent::initSqlStatementFactory();
    }

    protected function fetchResultAssoc($rs) {
        return mysql_fetch_array($rs, MYSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return mysql_fetch_array($rs, MYSQL_NUM);
    }
}
