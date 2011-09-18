<?php
defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's core configuration file.
 */

/*
 * If environment variable DEV_ENV exists then we are on development server.
 */
define('IN_DEV_ENV', getenv('DEV_ENV'));

if ( IN_DEV_ENV ) {
    define('REPORT_ERROR', TRUE);
}

/*
 * If CLI_MODE is TRUE, the application is running in CLI (command line interface) mode.
 */
define('CLI_MODE', strtolower(php_sapi_name()) == 'cli' && empty($_SERVER['REMOTE_ADDR']));

/*
 * Since PHP 5.3, you should not rely on the default time zone setting any more!
 * Do set your own timezone here!
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');

/*
 * Put list of classes that should be ignored by Dzit's auto loading.
 * Note: PCRE regular expression supported (http://www.php.net/manual/en/pcre.pattern.php).
 */
global $DZIT_IGNORE_AUTOLOAD;
$DZIT_IGNORE_AUTOLOAD = Array('/^Smarty_*/', '/^Yadif_*/');

include 'vcatalog-config-constants.php';

include 'vcatalog-config-version.php';

include 'dzit-config-logging.php';

include 'dzit-config-cache.php';

include 'dzit-config-dao.php';

include 'dzit-config-mls.php';

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
/* NOTE: REMEMBER TO CONFIGURE YOUR OWN APPLICATION'S ROUTING HERE! */
$router = Array('*' => 'Vcatalog_Controller_HomeController',
        'login' => 'Vcatalog_Controller_LoginController',
        'logout' => 'Vcatalog_Controller_LogoutController',
        'page' => 'Vcatalog_Controller_ViewPageController',
        'category' => 'Vcatalog_Controller_ViewCategoryController',
        'item' => 'Vcatalog_Controller_ViewItemController',
        'addToCart' => 'Vcatalog_Controller_AddToCartController',
        'cart' => 'Vcatalog_Controller_ViewCartController',
        'updateCart' => 'Vcatalog_Controller_UpdateCartController',
        'checkout' => 'Vcatalog_Controller_CheckoutController',
        'search' => 'Vcatalog_Controller_SearchController',
        'profilecp' => Array('*' => 'Vcatalog_Controller_ProfileCp_ProfileController'),
        'paperclip' => Array('thumbnail' => 'Paperclip_Controller_ViewThumbnailController',
                'view' => 'Paperclip_Controller_ViewController',
                'download' => 'Paperclip_Controller_DownloadController'),
        'admin' => Array('*' => 'Vcatalog_Controller_Admin_HomeController',
                'categories' => 'Vcatalog_Controller_Admin_CategoryListController',
                'createCategory' => 'Vcatalog_Controller_Admin_CreateCategoryController',
                'deleteCategory' => 'Vcatalog_Controller_Admin_DeleteCategoryController',
                'editCategory' => 'Vcatalog_Controller_Admin_EditCategoryController',
                'moveCategoryDown' => 'Vcatalog_Controller_Admin_MoveDownCategoryController',
                'moveCategoryUp' => 'Vcatalog_Controller_Admin_MoveUpCategoryController',
                'items' => 'Vcatalog_Controller_Admin_ItemListController',
                'createItem' => 'Vcatalog_Controller_Admin_CreateItemController',
                'editItem' => 'Vcatalog_Controller_Admin_EditItemController',
                'deleteItem' => 'Vcatalog_Controller_Admin_DeleteItemController',
                'pages' => 'Vcatalog_Controller_Admin_PageListController',
                'createPage' => 'Vcatalog_Controller_Admin_CreatePageController',
                'deletePage' => 'Vcatalog_Controller_Admin_DeletePageController',
                'editPage' => 'Vcatalog_Controller_Admin_EditPageController',
                'siteSettings' => 'Vcatalog_Controller_Admin_SiteSettingsController',
                'emailSettings' => 'Vcatalog_Controller_Admin_EmailSettingsController',
                'catalogSettings' => 'Vcatalog_Controller_Admin_CatalogSettingsController',
                'updateIndex' => 'Vcatalog_Controller_Admin_UpdateIndexController'));
Dzit_Config::set(Dzit_Config::CONF_ROUTER, $router);

/*
 * Action handler mapping configuration: the default action handler mapping should work
 * out-of-the-box. It follows the convensions of the above router configurations.
 *
 * Action handler mapping is responsible for obtaining a controller instance
 * (type {@link Dzit_IController}) for a request {module:action}.
 */
//$actionHandlerMappingClass = 'Dzit_DefaultActionHandlerMapping';
require_once 'Vcatalog/Controller/ClassActionHandlerMapping.php';
$actionHandlerMappingClass = 'Vcatalog_Controller_ActionHandlerMapping';
Dzit_Config::set(Dzit_Config::CONF_ACTION_HANDLER_MAPPING, new $actionHandlerMappingClass($router));

/*
 * View resolver configuration.
 *
 * View resolver is responsible for resolving a {@link Dzit_IView} from name (string).
 *
 * Built-in view resolvers:
 * <ul>
 *     <li>{@link Dzit_View_PhpViewResolver}: use this view resolver if the application use a single PHP-based template.</li>
 * </ul>
 */
include_once ('Smarty.class.php');

define('SKIN_DIR', 'skins/knbabyshop/');
$params = Array('templateDir' => SKIN_DIR,
        'prefix' => 'page_',
        'suffix' => '.tpl',
        'smartyCacheDir' => '../../../smarty/cache',
        'smartyConfigDir' => '../../../smarty/config',
        'smartyCompileDir' => '../../../smarty/template_c',
        'smartyLeftDelimiter' => '[:',
        'smartyRightDelimiter' => ':]');
$viewResolverClass = 'Dzit_View_SmartyViewResolver';
Dzit_Config::set(Dzit_Config::CONF_VIEW_RESOLVER, new $viewResolverClass($params));

/*
 * Name of the default language pack.
 */
Dzit_Config::set(Dzit_Config::CONF_DEFAULT_LANGUAGE_NAME, 'vn');

/*
 * Name of the default template pack.
 */
Dzit_Config::set(Dzit_Config::CONF_DEFAULT_TEMPLATE_NAME, 'default');

/*
 * Name of the module's bootstrap file.
 */

define('MODULE_BOOTSTRAP_FILE', 'bootstrap.php');
