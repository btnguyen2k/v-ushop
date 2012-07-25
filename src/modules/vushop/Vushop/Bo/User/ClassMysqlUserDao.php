<?php
class Vushop_Bo_User_MysqlUserDao extends Vushop_Bo_User_BaseUserDao implements
        Ddth_Dao_Mysql_IMysqlDao {

    protected function fetchResultAssoc($rs) {
        return mysql_fetch_array($rs, MYSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return mysql_fetch_array($rs, MYSQL_NUM);
    }
}
