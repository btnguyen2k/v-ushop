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
$router = Array('*' => 'Vushop_Controller_HomeController',
        'login' => 'Vushop_Controller_LoginController',
        'logout' => 'Vushop_Controller_LogoutController',
        'ads' => 'Vushop_Controller_ViewAdsController',
        'page' => 'Vushop_Controller_ViewPageController',
        'category' => 'Vushop_Controller_ViewCategoryController',
		'shop' => 'Vushop_Controller_ViewShopController',
        'item' => 'Vushop_Controller_ViewItemController',
        'addToCart' => 'Vushop_Controller_AddToCartController',
        'cart' => 'Vushop_Controller_ViewCartController',
        'updateCart' => 'Vushop_Controller_UpdateCartController',
        'checkout' => 'Vushop_Controller_CheckoutController',
        'search' => 'Vushop_Controller_SearchController',
        'profilecp' => Array('*' => 'Vushop_Controller_ProfileCp_ProfileController'),
		'changePassword' => Array('*' => 'Vushop_Controller_ProfileCp_ChangePasswordController'),
        'paperclip' => Array('thumbnail' => 'Paperclip_Controller_ViewThumbnailController',
                'view' => 'Paperclip_Controller_ViewController',
                'download' => 'Paperclip_Controller_DownloadController'),
        'admin' => Array('*' => new Dzit_Controller_RedirectController('../backend/')));
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
