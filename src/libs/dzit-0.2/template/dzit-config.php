<?php
defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's core configuration file.
 * Note: Add/Remove/Modify your own configurations if needed!
 */

/*
 * If environment variable DEV_ENV exists then we are on development server.
 */
define('IN_DEV_ENV', getenv('DEV_ENV'));

/*
 * If CLI_MODE is TRUE, the application is running in CLI (command line interface) mode.
 */
define('CLI_MODE', strtolower(php_sapi_name()) == 'cli' && empty($_SERVER['REMOTE_ADDR']));

/*
 * Since PHP 5.3, you should not rely on the default time zone setting any more!
 * Note: See http://www.php.net/manual/en/timezones.php for list of supported timezones.
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');

/*
 * Configurations for Ddth::Commons::Logging
 * Note: the default logger (SimpleLog which writes log to php's system log) should
 * be sufficient for most cases. Change it if you want to use another logger.
 */
global $DPHP_COMMONS_LOGGING_CONFIG;
$DPHP_COMMONS_LOGGING_CONFIG = Array(
        'ddth.commons.logging.Logger' => 'Ddth_Commons_Logging_SimpleLog',
        'logger.setting.default' => IN_DEV_ENV ? 'DEBUG' : 'WARN');

/*
 * Configurations for Ddth::Dao
 */
/*
 * Note: Below is just an example. Configure your own DAOs here!
 */
global $DPHP_DAO_CONFIG;
$DPHP_DAO_CONFIG = Array('ddth-dao.factoryClass' => 'Ddth_Dao_Mysql_BaseMysqlDaoFactory',
        'dphp-dao.mysql.host' => '127.0.0.1',
        'dphp-dao.mysql.username' => 'username',
        'dphp-dao.mysql.password' => 'secret',
        'dphp-dao.mysql.database' => 'dbname',
        'dao.dao1' => 'Dzit_Demo_Bo_MysqlDao1');

/*
 * Configurations for Ddth::Adodb
 */
/*
 * Note: If you use Ddth::Adodb package, configure it here!
 */
global $DPHP_ADODB_CONFIG;
$DPHP_ADODB_CONFIG = Array('adodb.url' => 'mysql://username:password@127.0.0.1/dbname',
        'adodb.setupSqls' => Array("SET NAMES 'utf8'"));

/*
 * Configurations for Ddth::Mls
 */
/*
 * Note: Below is an example of 2 language packs (ENglish and VietNamese)!
 */
global $DPHP_MLS_CONFIG;
$DPHP_MLS_CONFIG = Array('factory.class' => 'Ddth_Mls_BaseLanguageFactory',
        'languages' => 'vn, en',
        // Note: Language base directory is relative to the [www] directory!
        'language.baseDirectory' => '../config/languages',
        'language.class' => 'Ddth_Mls_FileLanguage',
        'language.vn.location' => 'vi_vn',
        'language.vn.displayName' => 'Tiếng Việt',
        'language.vn.locale' => 'vi_VN',
        'language.vn.description' => 'Ngôn ngữ tiếng Việt',
        'language.en.location' => 'en_us',
        'language.en.displayName' => 'English',
        'language.en.locale' => 'en_US',
        'language.en.description' => 'English (US) language pack');

/*
 * Configurations for Ddth::Template
 */
/*
 * Note: Below is an example of 2 template packs (PHP and Smarty)!
 */
global $DPHP_TEMPLATE_CONFIG;
$DPHP_TEMPLATE_CONFIG = Array('factory.class' => 'Ddth_Template_BaseTemplateFactory',
        'templates' => 'default, fancy',
        // Note: Template base directory is relative to the [www] directory!
        'template.baseDirectory' => './skins',
        'template.default.class' => 'Ddth_Template_Php_PhpTemplate',
        'template.default.pageClass' => 'Ddth_Template_Php_PhpPage',
        'template.default.location' => 'default',
        'template.default.charset' => 'utf-8',
        'template.default.configFile' => 'config.properties',
        'template.default.displayName' => 'Default',
        'template.default.description' => 'Default template pack',
        'template.fancy.class' => 'Ddth_Template_Smarty_SmartyTemplate',
        'template.fancy.pageClass' => 'Ddth_Template_Smarty_SmartyPage',
        'template.fancy.location' => 'fancy',
        //- Name of the directory to store Smarty's cache files (located under template.<name>.location)
        'template.fancy.smarty.cache' => 'cache',
        //- Name of the directory to store Smarty's compiled template files (located under template.<name>.location)
        'template.fancy.smarty.compile' => 'templates_c',
        //- Name of the directory to store Smarty's configuration files (located under template.<name>.location)
        'template.fancy.smarty.configs' => 'configs',
        'template.fancy.charset' => 'utf-8',
        'template.fancy.configFile' => 'config.properties',
        'template.fancy.displayName' => 'Fancy',
        'template.fancy.description' => 'Fancy template pack');

/*
 * Action dispatcher configuration: the default dispatcher should work out-of-the-box.
 *
 * Dispatcher is responsible for:
 * <ul>
 *     <li>Routing the request {module:action} to the corresponding controller.</li>
 *     <li>Rendering the view.</li>
 * </ul>
 */
$dispatcherClass = 'Dzit_DefaultDispatcher';
Dzit_Config::set(Dzit_Config::CONF_DISPATCHER, new $dispatcherClass());

/*
 * Router configurations.
 *
 * Router information is {key:value} based, as the following:
 * <code>
 * {
 *     'module1' => ControllerInstance1,
 *     'module2' => 'ControllerClassName2',
 *     'module3' =>
 *     {
 *         'action1' => ControllerInstance3,
 *         'action2' => 'ControllerClassName4'
 *     }
 * }
 * </code>
 */
/*
 * Note: Configure your routings here!
 */
$router = Array();
Dzit_Config::set(Dzit_Config::CONF_ROUTER, $router);

/*
 * Action handler mapping configuration: the default action handler mapping should work
 * out-of-the-box. It follows the convensions of the above router configurations.
 *
 * Action handler mapping is responsible for obtaining a controller instance
 * (type {@link Dzit_IController}) for a request {module:action}.
 */
$actionHandlerMappingClass = 'Dzit_DefaultActionHandlerMapping';
Dzit_Config::set(Dzit_Config::CONF_ACTION_HANDLER_MAPPING, new $actionHandlerMappingClass($router));

/*
 * View resolver configuration.
 *
 * View resolver is responsible for resolving a view name (string) to instance of {@link Dzit_IView}.
 *
 * Built-in view resolvers:
 * <ul>
 *     <li>{@link Dzit_View_PhpViewResolver}: use this view resolver if the application
 *     uses only one single PHP-based template.</li>
 *     <li>{@link Dzit_View_SmartyViewResolver}: use this view resolver if the application
 *     uses only one single Smarty-based template.</li>
 * </ul>
 */
$viewResolverClass = 'Dzit_View_PhpViewResolver';
Dzit_Config::set(Dzit_Config::CONF_VIEW_RESOLVER, new $viewResolverClass('skins/default/page_'));
//$viewResolverClass = 'Dzit_View_SmartyViewResolver';
//Dzit_Config::set(Dzit_Config::CONF_VIEW_RESOLVER, new $viewResolverClass('skins/default/page_'));


/*
 * Name of the default language pack.
 */
Dzit_Config::set(Dzit_Config::CONF_DEFAULT_LANGUAGE_NAME, 'default');

/*
 * Name of the default template pack.
 */
Dzit_Config::set(Dzit_Config::CONF_DEFAULT_TEMPLATE_NAME, 'default');

/*
 * Name of the module's bootstrap file.
 */
define('MODULE_BOOTSTRAP_FILE', 'bootstrap.php');
