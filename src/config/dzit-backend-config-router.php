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
$dispatcherClass = 'Vushop_ProfiledDispatcher';
Dzit_Config::set(Dzit_Config::CONF_DISPATCHER, new $dispatcherClass());

/*
 * Router configurations. Router information is {key:value} based, as the
 * following: <code> { 'module1' => ControllerInstance1, 'module2' =>
 * 'ControllerClassName2', 'module3' => { 'action1' => ControllerInstance3,
 * 'action2' => 'ControllerClassName4' } } </code>
 */
/* NOTE: REMEMBER TO CONFIGURE YOUR OWN APPLICATION'S ROUTING HERE! */
$router = Array('*' => 'Vushop_Controller_Admin_HomeController',
        'login' => 'Vushop_Controller_LoginController',
        'logout' => 'Vushop_Controller_LogoutController',
        'dashboard' => 'Vushop_Controller_Admin_DashboardController',
        'paperclip' => Array('thumbnail' => 'Paperclip_Controller_ViewThumbnailController',
                'view' => 'Paperclip_Controller_ViewController',
                'download' => 'Paperclip_Controller_DownloadController'),
        'categories' => 'Vushop_Controller_Admin_CategoryListController',
        'createCategory' => 'Vushop_Controller_Admin_CreateCategoryController',
        'deleteCategory' => 'Vushop_Controller_Admin_DeleteCategoryController',
        'editCategory' => 'Vushop_Controller_Admin_EditCategoryController',
        'moveCategoryDown' => 'Vushop_Controller_Admin_MoveDownCategoryController',
        'moveCategoryUp' => 'Vushop_Controller_Admin_MoveUpCategoryController',
        'items' => 'Vushop_Controller_Admin_ItemListController',
        'createItem' => 'Vushop_Controller_Admin_CreateItemController',
        'editItem' => 'Vushop_Controller_Admin_EditItemController',
        'deleteItem' => 'Vushop_Controller_Admin_DeleteItemController',
        'pages' => 'Vushop_Controller_Admin_PageListController',
        'createPage' => 'Vushop_Controller_Admin_CreatePageController',
        'deletePage' => 'Vushop_Controller_Admin_DeletePageController',
        'editPage' => 'Vushop_Controller_Admin_EditPageController',
        'ads' => 'Vushop_Controller_Admin_AdsListController',
        'createAds' => 'Vushop_Controller_Admin_CreateAdsController',
        'deleteAds' => 'Vushop_Controller_Admin_DeleteAdsController',
        'editAds' => 'Vushop_Controller_Admin_EditAdsController',
        'siteSettings' => 'Vushop_Controller_Admin_SiteSettingsController',
        'emailSettings' => 'Vushop_Controller_Admin_EmailSettingsController',
        'catalogSettings' => 'Vushop_Controller_Admin_CatalogSettingsController',
        'updateIndex' => 'Vushop_Controller_Admin_UpdateIndexController',
 		'users' => 'Vushop_Controller_Admin_UserListController', 
        'deleteUser' => 'Vushop_Controller_Admin_DeleteUserController', 
        'createUser' => 'Vushop_Controller_Admin_CreateUserController', 
        'editUser' => 'Vushop_Controller_Admin_EditUserController');
Dzit_Config::set(Dzit_Config::CONF_ROUTER, $router);

/*
 * Action handler mapping configuration: the default action handler mapping
 * should work out-of-the-box. It follows the convensions of the above router
 * configurations. Action handler mapping is responsible for obtaining a
 * controller instance (type {@link Dzit_IController}) for a request
 * {module:action}.
 */
// $actionHandlerMappingClass = 'Dzit_DefaultActionHandlerMapping';
require_once 'Vushop/Controller/ClassActionHandlerMapping.php';
$actionHandlerMappingClass = 'Vushop_Controller_ActionHandlerMapping';
Dzit_Config::set(Dzit_Config::CONF_ACTION_HANDLER_MAPPING, new $actionHandlerMappingClass($router));
