<?php
class Vcatalog_Bo_TextAds_MysqlAdsDao extends Vcatalog_Bo_TextAds_BaseAdsDao implements
        Ddth_Dao_Mysql_IMysqlDao {

    protected function fetchResultAssoc($rs) {
        return mysql_fetch_array($rs, MYSQL_ASSOC);
    }

    protected function fetchResultArr($rs) {
        return mysql_fetch_array($rs, MYSQL_NUM);
    }
}