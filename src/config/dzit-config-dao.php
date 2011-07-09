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
        DAO_SESSION => 'Vcatalog_Bo_Session_MysqlSessionDao',
        DAO_USER => 'Vcatalog_Bo_User_MysqlUserDao',
        DAO_CATALOG => 'Vcatalog_Bo_Catalog_MysqlCatalogDao',
        DAO_CART => 'Vcatalog_Bo_Cart_MysqlCartDao',
        DAO_PAGE => 'Vcatalog_Bo_Page_MysqlPageDao',
        DAO_CONFIG => 'Vcatalog_Bo_Config_MysqlConfigDao');
