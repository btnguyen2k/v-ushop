<?php
/*
 * Configurations for Ddth::Dao
 */

$DPHP_DAO_CONFIG_MYSQL_SITE = Array('dphp-dao.factoryClass' => 'Ddth_Dao_Mysql_BaseMysqlDaoFactory',
        'dphp-dao.mysql.host' => '127.0.0.1',
        'dphp-dao.mysql.username' => 'gpv',
        'dphp-dao.mysql.password' => 'gpvm@st3r',
        'dphp-dao.mysql.database' => 'gpv',
        'dphp-dao.mysql.setupSqls' => Array("SET NAMES 'utf8'"),
        DAO_SITE => Array('class' => 'Quack_Bo_Site_MysqlSiteDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_STM_FILE => 'MySql/sql_site.mysql.properties'));

// For MySQL
global $DPHP_DAO_CONFIG_MYSQL;
$DPHP_DAO_CONFIG_MYSQL = Array('dphp-dao.factoryClass' => 'Ddth_Dao_Mysql_BaseMysqlDaoFactory',
        'dphp-dao.mysql.host' => '127.0.0.1',
        'dphp-dao.mysql.username' => 'vcatalog',
        'dphp-dao.mysql.password' => 'vcatalog',
        'dphp-dao.mysql.database' => 'vcatalog',
        'dphp-dao.mysql.setupSqls' => Array("SET NAMES 'utf8'"),
        // DAO_SESSION => 'Vcatalog_Bo_Session_MysqlSessionDao',
        DAO_SESSION => 'Quack_Bo_SessionS_MysqlSessionDao',
        DAO_USER => 'Vcatalog_Bo_User_MysqlUserDao',
        DAO_CATALOG => 'Vcatalog_Bo_Catalog_MysqlCatalogDao',
        DAO_CART => 'Vcatalog_Bo_Cart_MysqlCartDao',
        DAO_PAGE => Array('class' => 'Quack_Bo_Page_MysqlPageDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_STM_FILE => 'MySql/sql_page.mysql.properties'),
        DAO_TEXTADS => Array('class' => 'Vcatalog_Bo_TextAds_MysqlAdsDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_STM_FILE => 'MySql/sql_textads.mysql.properties'),
        DAO_CONFIG => 'Vcatalog_Bo_Config_MysqlConfigDao',
        DAO_PAPERCLIP => 'Paperclip_Bo_MysqlPaperclipDao');

global $DPHP_DAO_CONFIG;
$DPHP_DAO_CONFIG = &$DPHP_DAO_CONFIG_MYSQL;
