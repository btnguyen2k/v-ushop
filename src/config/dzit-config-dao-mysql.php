<?php
/*
 * MySQL configurations for Ddth::Dao
 */

// For MySQL
global $DPHP_DAO_CONFIG_MYSQL_SITE;
$DPHP_DAO_CONFIG_MYSQL_SITE = Array('dphp-dao.factoryClass' => 'Ddth_Dao_Mysql_BaseMysqlDaoFactory',
        'dphp-dao.mysql.host' => '127.0.0.1',
        'dphp-dao.mysql.username' => 'gpv',
        'dphp-dao.mysql.password' => 'gpvm@st3r',
        'dphp-dao.mysql.database' => 'gpv',
        'dphp-dao.mysql.setupSqls' => Array("SET NAMES 'utf8'"),
        'dao._' => 'Quack_Bo_ConnectionHolderDao',
        DAO_SITE => Array('class' => 'Quack_Bo_Site_MysqlSiteDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_site.base.properties'));

// For MySQL
global $DPHP_DAO_CONFIG_MYSQL;
$DPHP_DAO_CONFIG_MYSQL = Array('dphp-dao.factoryClass' => 'Ddth_Dao_Mysql_BaseMysqlDaoFactory',
        'dphp-dao.mysql.host' => '127.0.0.1',
        'dphp-dao.mysql.username' => 'vushop',
        'dphp-dao.mysql.password' => 'vushop',
        'dphp-dao.mysql.database' => 'vushop',
        'dphp-dao.mysql.setupSqls' => Array("SET NAMES 'utf8'"),
        'dao._' => 'Quack_Bo_ConnectionHolderDao',
        DAO_SESSION => Array('class' => 'Quack_Bo_SessionS_MysqlSessionDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_session.base.properties'),
        DAO_USER => Array('class' => 'Vushop_Bo_User_MysqlUserDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_user.base.properties'),
        DAO_CATALOG => Array('class' => 'Vushop_Bo_Catalog_MysqlCatalogDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_catalog.base.properties'),
        DAO_CART => Array('class' => 'Vushop_Bo_Cart_MysqlCartDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_STM_FILE => 'MySql/sql_cart.mysql.properties',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_cart.base.properties'),
        DAO_SHOP => Array('class' => 'Vushop_Bo_Shop_MysqlShopDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_shop.base.properties'),
        DAO_PAGE => Array('class' => 'Quack_Bo_Page_MysqlPageDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_page.base.properties'),
        DAO_TEXTADS => Array('class' => 'Vushop_Bo_TextAds_MysqlAdsDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_textads.base.properties'),
        DAO_PROFILE => Array('class' => 'Quack_Bo_Profile_MysqlProfileDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_profile.base.properties'),
        DAO_CONFIG => Array('class' => 'Quack_Bo_AppConfig_MysqlAppConfigDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_config.base.properties'),
        DAO_PAPERCLIP => Array('class' => 'Paperclip_Bo_MysqlPaperclipDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_paperclip.base.properties'),
       DAO_ORDER => Array('class' => 'Vushop_Bo_Order_MysqlOrderDao',
                Ddth_Dao_AbstractSqlStatementDao::CONF_SQL_BASE_STM_FILE => 'Base/sql_order.base.properties'));
