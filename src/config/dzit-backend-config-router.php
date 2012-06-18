<?php
/*
 * Configurations for action routing
 */
/*
 * Action dispatcher configuration: the default dispatcher should work out-of-the-box.
*
* Dispatcher is responsible for:
* <ul>
*     <li>Routing the request {module:action} to the corresponding controller.</li>
*     <li>Rendering the view.</li>
* </ul>
*/
$dispatcherClass = 'Vcatalog_ProfiledDispatcher';
Dzit_Config::set(Dzit_Config::CONF_DISPATCHER, new $dispatcherClass());

/*
 * Router configurations. Router information is {key:value} based, as the
 * following: <code> { 'module1' => ControllerInstance1, 'module2' =>
 * 'ControllerClassName2', 'module3' => { 'action1' => ControllerInstance3,
 * 'action2' => 'ControllerClassName4' } } </code>
 */
/* NOTE: REMEMBER TO CONFIGURE YOUR OWN APPLICATION'S ROUTING HERE! */
$router = Array('*' => 'Vcatalog_Controller_Admin_HomeController',
        'login' => 'Vcatalog_Controller_LoginController',
        'logout' => 'Vcatalog_Controller_LogoutController',
		'dashboard' => 'Vcatalog_Controller_Admin_DashboardController',
        'paperclip' => Array('thumbnail' => 'Paperclip_Controller_ViewThumbnailController',
                'view' => 'Paperclip_Controller_ViewController',
                'download' => 'Paperclip_Controller_DownloadController'),
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
        'ads' => 'Vcatalog_Controller_Admin_AdsListController',
        'createAds' => 'Vcatalog_Controller_Admin_CreateAdsController',
        'deleteAds' => 'Vcatalog_Controller_Admin_DeleteAdsController',
        'editAds' => 'Vcatalog_Controller_Admin_EditAdsController',
        'siteSettings' => 'Vcatalog_Controller_Admin_SiteSettingsController',
        'emailSettings' => 'Vcatalog_Controller_Admin_EmailSettingsController',
        'catalogSettings' => 'Vcatalog_Controller_Admin_CatalogSettingsController',
        'updateIndex' => 'Vcatalog_Controller_Admin_UpdateIndexController');
Dzit_Config::set(Dzit_Config::CONF_ROUTER, $router);

/*
 * Action handler mapping configuration: the default action handler mapping
 * should work out-of-the-box. It follows the convensions of the above router
 * configurations. Action handler mapping is responsible for obtaining a
 * controller instance (type {@link Dzit_IController}) for a request
 * {module:action}.
 */
// $actionHandlerMappingClass = 'Dzit_DefaultActionHandlerMapping';
require_once 'Vcatalog/Controller/ClassActionHandlerMapping.php';
$actionHandlerMappingClass = 'Vcatalog_Controller_ActionHandlerMapping';
Dzit_Config::set(Dzit_Config::CONF_ACTION_HANDLER_MAPPING, new $actionHandlerMappingClass($router));
