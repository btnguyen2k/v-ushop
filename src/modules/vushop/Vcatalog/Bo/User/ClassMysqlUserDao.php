<?php
class Vcatalog_Bo_User_MysqlUserDao extends Vcatalog_Bo_User_BaseUserDao implements
        Ddth_Dao_Mysql_IMysqlDao {

    protected function initSqlStatementFactory() {
        $this->setSqlStatementFile('Vcatalog/Bo/User/sql_user.mysql.properties');
        parent::initSqlStatementFactory();
    }

    protected function fetchResultAssoc($rs) {
        return mysql_fetch_array($rs, MYSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return mysql_fetch_array($rs, MYSQL_NUM);
    }
}
