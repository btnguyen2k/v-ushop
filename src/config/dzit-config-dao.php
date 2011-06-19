<?php
/*
 * Configurations for Ddth::Dao
 */
global $DPHP_DAO_CONFIG;
//For MySQL
$DPHP_DAO_CONFIG = Array('dphp-dao.factoryClass' => 'Ddth_Dao_Mysql_BaseMysqlDaoFactory',
        'dphp-dao.mysql.host' => '127.0.0.1',
        'dphp-dao.mysql.username' => 'vcatalog',
        'dphp-dao.mysql.password' => 'vcatalog',
        'dphp-dao.mysql.database' => 'vcatalog',
        'dphp-dao.mysql.setupSqls' => Array("SET NAMES 'utf8'"),
        'dao.session' => 'Vcatalog_Bo_Session_MysqlSessionDao',
        'dao.user' => 'Vcatalog_Bo_User_MysqlUserDao',
        'dao.listings' => 'Vcatalog_Bo_Listings_MysqlListingsDao',
        'dao.config' => 'Vcatalog_Bo_Config_MysqlConfigDao');
