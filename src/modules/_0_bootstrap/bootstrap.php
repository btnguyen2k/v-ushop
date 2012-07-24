<?php
/* vuShop's global boostrap file */

// disable cache
//global $DPHP_CACHE_CONFIG;
//global $DPHP_CACHE_CONFIG_MEMORY;
//$DPHP_CACHE_CONFIG = &$DPHP_CACHE_CONFIG_MEMORY;

function bootstrap_getSiteInfo() {
    global $DPHP_DAO_CONFIG_SITE;
    $siteDao = Ddth_Dao_BaseDaoFactory::getInstance($DPHP_DAO_CONFIG_SITE)->getDao(DAO_SITE);
    $tokens = explode(":", $_SERVER["HTTP_HOST"]);
    $host = trim($tokens[0]);
    $site = $siteDao->getSiteByDomain($host);
    return $site;
}

function bootstrap_getProductConfig() {
    $site = bootstrap_getSiteInfo();
    if ($site === NULL) {
        die("Domain '{$_SERVER["HTTP_HOST"]}' does not exist!");
    }
    $product = $site->getProduct(PRODUCT_CODE);
    if ($product === NULL) {
        die("Product '" . PRODUCT_CODE . "' does not exist!");
    }
    if ($product->isExpired()) {
        die("Product '" . PRODUCT_CODE . "' has expired!");
    }
    $prodConfig = $product->getProductConfigMap();
    return $prodConfig;
}

function bootstrap_configureSiteLogging() {
    // temporarily switch to simple log
    global $DPHP_COMMONS_LOGGING_CONFIG_SIMPLE;
    global $DPHP_COMMONS_LOGGING_CONFIG;
    $SAVE_LOGGING_CONFIG = &$DPHP_COMMONS_LOGGING_CONFIG;
    $DPHP_COMMONS_LOGGING_CONFIG = &$DPHP_COMMONS_LOGGING_CONFIG_SIMPLE;

    // pre-open db connection(s) for latter use
    global $DPHP_DAO_CONFIG_SITE;
    $_dao = Ddth_Dao_BaseDaoFactory::getInstance($DPHP_DAO_CONFIG_SITE)->getDao('dao._');
    $_dao->getConnection();

    $prodConfig = bootstrap_getProductConfig();

    // setup logger
    if (strtoupper($prodConfig['DB']['TYPE']) == 'MYSQL') {
        global $DPHP_COMMONS_LOGGING_CONFIG_MYSQL;
        $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.host'] = $prodConfig['DB']['HOST'];
        $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.username'] = $prodConfig['DB']['USER'];
        $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.password'] = $prodConfig['DB']['PASSWORD'];
        $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.dbname'] = $prodConfig['DB']['DATABASE'];
        $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.setupSqls'] = $prodConfig['DB']['SETUP_SQLS'];
    } else if (strtoupper($prodConfig['DB']['TYPE']) == 'PGSQL') {
        global $DPHP_COMMONS_LOGGING_CONFIG_PGSQL;
        $DPHP_COMMONS_LOGGING_CONFIG_PGSQL['logger.setting.pgsql.host'] = $prodConfig['DB']['HOST'];
        $DPHP_COMMONS_LOGGING_CONFIG_PGSQL['logger.setting.pgsql.username'] = $prodConfig['DB']['USER'];
        $DPHP_COMMONS_LOGGING_CONFIG_PGSQL['logger.setting.pgsql.password'] = $prodConfig['DB']['PASSWORD'];
        $DPHP_COMMONS_LOGGING_CONFIG_PGSQL['logger.setting.pgsql.dbname'] = $prodConfig['DB']['DATABASE'];
    } else {
        die("Db type {$prodConfig['DB']['TYPE']} is not supported!");
    }

    // switch back to configured logging
    $DPHP_COMMONS_LOGGING_CONFIG = &$SAVE_LOGGING_CONFIG;
}

function bootstrap_configureDAOs() {
    $prodConfig = bootstrap_getProductConfig();

    // setup DAOs
    if (strtoupper($prodConfig['DB']['TYPE']) == 'MYSQL') {
        global $DPHP_DAO_CONFIG_MYSQL;
        $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_MYSQL_HOST] = $prodConfig['DB']['HOST'];
        $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_MYSQL_DATABASE] = $prodConfig['DB']['DATABASE'];

        $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_MYSQL_PORT] = isset($prodConfig['DB']['PORT']) ? $prodConfig['DB']['PORT'] : NULL;
        $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_MYSQL_USERNAME] = isset($prodConfig['DB']['USER']) ? $prodConfig['DB']['USER'] : NULL;
        $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_MYSQL_PASSWORD] = isset($prodConfig['DB']['PASSWORD']) ? $prodConfig['DB']['PASSWORD'] : NULL;

        $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_SETUP_SQLS] = isset($prodConfig['DB']['SETUP_SQLS']) ? $prodConfig['DB']['SETUP_SQLS'] : NULL;
    } elseif (strtoupper($prodConfig['DB']['TYPE']) == 'PGSQL') {
        global $DPHP_DAO_CONFIG_PGSQL;
        $DPHP_DAO_CONFIG_PGSQL[Ddth_Dao_Pgsql_BasePgsqlDaoFactory::CONF_PGSQL_CONNECTION_STRING] = isset($prodConfig['DB']['CONNECTION_STRING']) ? $prodConfig['DB']['CONNECTION_STRING'] : NULL;

        $DPHP_DAO_CONFIG_PGSQL[Ddth_Dao_Pgsql_BasePgsqlDaoFactory::CONF_PGSQL_HOST] = isset($prodConfig['DB']['HOST']) ? $prodConfig['DB']['HOST'] : NULL;
        $DPHP_DAO_CONFIG_PGSQL[Ddth_Dao_Pgsql_BasePgsqlDaoFactory::CONF_PGSQL_DATABASE] = isset($prodConfig['DB']['DATABASE']) ? $prodConfig['DB']['DATABASE'] : NULL;
        $DPHP_DAO_CONFIG_PGSQL[Ddth_Dao_Pgsql_BasePgsqlDaoFactory::CONF_PGSQL_PORT] = isset($prodConfig['DB']['PORT']) ? $prodConfig['DB']['PORT'] : NULL;
        $DPHP_DAO_CONFIG_PGSQL[Ddth_Dao_Pgsql_BasePgsqlDaoFactory::CONF_PGSQL_USERNAME] = isset($prodConfig['DB']['USER']) ? $prodConfig['DB']['USER'] : NULL;
        $DPHP_DAO_CONFIG_PGSQL[Ddth_Dao_Pgsql_BasePgsqlDaoFactory::CONF_PGSQL_PASSWORD] = isset($prodConfig['DB']['PASSWORD']) ? $prodConfig['DB']['PASSWORD'] : NULL;
    } else {
        die("Db type {$prodConfig['DB']['TYPE']} is not supported!");
    }

    // pre-open db connection(s) for latter use
    $_dao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao('dao._');
    $_dao->getConnection();
}

function bootstrap_configSkin() {
    if (!defined('SKIN_DIR_BACKEND')) {
        // if it's not backend, we switch to user-defined skin if possible
        $configDao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao(DAO_CONFIG);
        $siteSkin = $configDao->loadConfig(CONFIG_SITE_SKIN);
        if ($siteSkin == NULL || $siteSkin->getValue() == '') {
            $siteSkin = 'default';
        } else {
            $siteSkin = $siteSkin->getValue();
        }

        $skinDir = SITE_SKINS_ROOT_DIR . $siteSkin . "/";
        if (!is_dir($skinDir)) {
            // fallback to default skin
            $skinDir = SITE_SKINS_ROOT_DIR . "default/";
        }
        define('SKIN_DIR_EX', $skinDir);
        $params = Array('templateDir' => $skinDir,
                'prefix' => 'page_',
                'suffix' => '.tpl',
                'smartyCacheDir' => '../../../smarty/cache',
                'smartyConfigDir' => '../../../smarty/config',
                'smartyCompileDir' => '../../../smarty/template_c',
                'smartyLeftDelimiter' => '[:',
                'smartyRightDelimiter' => ':]');
        $viewResolverClass = 'Dzit_View_SmartyViewResolver';
        Dzit_Config::set(Dzit_Config::CONF_VIEW_RESOLVER, new $viewResolverClass($params));
    }
}

function bootstrap_cleanupCart() {
    if (rand(0, 10) < 2) {
        $cartDao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao(DAO_CART);
        $cartDao->cleanup();
    }
}

bootstrap_configureSiteLogging();
bootstrap_configureDAOs();
bootstrap_configSkin();
bootstrap_cleanupCart();

/*
 * Use Quack's session handler. Comment the next line if you want to use PHP's
* default session handler
*/
Quack_SessionS_SessionHandler::startSession(DAO_SESSION);
