<?php
/* vCatalog's boostrap file */

global $DPHP_DAO_CONFIG_MYSQL_SITE;
$siteDao = Ddth_Dao_BaseDaoFactory::getInstance($DPHP_DAO_CONFIG_MYSQL_SITE)->getDao(DAO_SITE);
$tokens = explode(":", $_SERVER["HTTP_HOST"]);
$host = trim($tokens[0]);
$site = $siteDao->getSiteByDomain($host);
if ($site === NULL) {
    die("Domain '{$_SERVER["HTTP_HOST"]}' does not exist!");
}
$product = $site->getProduct('VCATALOG');
if ($product === NULL) {
    die("Product 'VCATALOG' does not exist!");
}
if ($product->isExpired()) {
    die("Product 'VCATALOG' has expired!");
}

$prodConfig = $product->getProductConfigMap();

// setup logger
if (strtoupper($prodConfig['DB']['TYPE']) == 'MYSQL') {
    global $DPHP_COMMONS_LOGGING_CONFIG_MYSQL;
    $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.host'] = $prodConfig['DB']['HOST'];
    $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.username'] = $prodConfig['DB']['USER'];
    $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.password'] = $prodConfig['DB']['PASSWORD'];
    $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.dbname'] = $prodConfig['DB']['DATABASE'];
    $DPHP_COMMONS_LOGGING_CONFIG_MYSQL['logger.setting.mysql.setupSqls'] = $prodConfig['DB']['SETUP_SQLS'];
} else {
    die("Db type {$prodConfig['DB']['TYPE']} is not supported!");
}

// setup DAOs
if (strtoupper($prodConfig['DB']['TYPE']) == 'MYSQL') {
    global $DPHP_DAO_CONFIG_MYSQL;
    $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_MYSQL_HOST] = $prodConfig['DB']['HOST'];
    $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_MYSQL_USERNAME] = $prodConfig['DB']['USER'];
    $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_MYSQL_PASSWORD] = $prodConfig['DB']['PASSWORD'];
    $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_MYSQL_DATABASE] = $prodConfig['DB']['DATABASE'];
    $DPHP_DAO_CONFIG_MYSQL[Ddth_Dao_Mysql_BaseMysqlDaoFactory::CONF_SETUP_SQLS] = $prodConfig['DB']['SETUP_SQLS'];
} else {
    die("Db type {$prodConfig['DB']['TYPE']} is not supported!");
}

if (!defined('SKIN_DIR_BACKEND')) {
    // if it's not backend, we switch to user-defined skin if possible
    $configDao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao(DAO_CONFIG);
    $siteSkin = $configDao->loadConfig(CONFIG_SITE_SKIN);
    if ($siteSkin == NULL || $siteSkin == '') {
        $siteSkin = 'default';
    }

    $skinDir = SITE_SKINS_ROOT_DIR . "$siteSkin/";
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