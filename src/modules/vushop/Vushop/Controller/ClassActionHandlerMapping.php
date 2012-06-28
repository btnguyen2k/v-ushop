<?php

include_once 'Yadif/Exception.php';
include_once 'Yadif/Container.php';

global $YADIF_CONFIG;
$YADIF_CONFIG = Array(
        'Paperclip_Controller_ViewThumbnailController' => Array(
                'class' => 'Paperclip_Controller_ViewThumbnailController',
                'scope' => 'singleton'),
        'Paperclip_Controller_ViewController' => Array(
                'class' => 'Paperclip_Controller_ViewController',
                'scope' => 'singleton'),
        'Paperclip_Controller_DownloadController' => Array(
                'class' => 'Paperclip_Controller_DownloadController',
                'scope' => 'singleton'),

        'Vushop_Controller_HomeController' => Array('class' => 'Vushop_Controller_HomeController',
                'scope' => 'singleton'),

        'Vushop_Controller_ViewAdsController' => Array(
                'class' => 'Vushop_Controller_ViewAdsController',
                'scope' => 'singleton'),

        'Vushop_Controller_ViewPageController' => Array(
                'class' => 'Vushop_Controller_ViewPageController',
                'scope' => 'singleton'),

        'Vushop_Controller_ViewCartController' => Array(
                'class' => 'Vushop_Controller_ViewCartController',
                'scope' => 'singleton'),

        'Vushop_Controller_UpdateCartController' => Array(
                'class' => 'Vushop_Controller_UpdateCartController',
                'scope' => 'singleton'),

        'Vushop_Controller_ViewCategoryController' => Array(
                'class' => 'Vushop_Controller_ViewCategoryController',
                'scope' => 'singleton'),

        'Vushop_Controller_ViewItemController' => Array(
                'class' => 'Vushop_Controller_ViewItemController',
                'scope' => 'singleton'),

        'Vushop_Controller_AddToCartController' => Array(
                'class' => 'Vushop_Controller_AddToCartController',
                'scope' => 'singleton',
                'methods' => Array(Array('method' => 'setSaveUrl', 'arguments' => Array(FALSE)))),

        'Vushop_Controller_CheckoutController' => Array(
                'class' => 'Vushop_Controller_CheckoutController',
                'scope' => 'singleton',
                'methods' => Array(Array('method' => 'setSaveUrl', 'arguments' => Array(FALSE)))),

        'Vushop_Controller_SearchController' => Array(
                'class' => 'Vushop_Controller_SearchController',
                'scope' => 'singleton'),

        'Vushop_Controller_LoginController' => Array('class' => 'Vushop_Controller_LoginController',
                'scope' => 'singleton',
                'methods' => Array(Array('method' => 'setSaveUrl', 'arguments' => Array(FALSE)))),
        'Vushop_Controller_RegisterController' => Array(
                'class' => 'Vushop_Controller_RegisterController',
                'scope' => 'singleton',
                'methods' => Array(Array('method' => 'setSaveUrl', 'arguments' => Array(FALSE)))),
        'Vushop_Controller_LogoutController' => Array(
                'class' => 'Vushop_Controller_LogoutController',
                'scope' => 'singleton',
                'methods' => Array(Array('method' => 'setSaveUrl', 'arguments' => Array(FALSE)))),

        'Vushop_Controller_ProfileCp_ProfileController' => Array(
                'class' => 'Vushop_Controller_ProfileCp_ProfileController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)))),

        'Vushop_Controller_Admin_HomeController' => Array(
                'class' => 'Vushop_Controller_Admin_HomeController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups',
                                'arguments' => Array(USER_GROUP_ADMIN, USER_GROUP_SITE_OWNER)))),

        'Vushop_Controller_Admin_DashboardController' => Array(
                'class' => 'Vushop_Controller_Admin_DashboardController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vushop_Controller_Admin_PageListController' => Array(
                'class' => 'Vushop_Controller_Admin_PageListController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_CreatePageController' => Array(
                'class' => 'Vushop_Controller_Admin_CreatePageController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_DeletePageController' => Array(
                'class' => 'Vushop_Controller_Admin_DeletePageController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_EditPageController' => Array(
                'class' => 'Vushop_Controller_Admin_EditPageController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vushop_Controller_Admin_AdsListController' => Array(
                'class' => 'Vushop_Controller_Admin_AdsListController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_CreateAdsController' => Array(
                'class' => 'Vushop_Controller_Admin_CreateAdsController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_DeleteAdsController' => Array(
                'class' => 'Vushop_Controller_Admin_DeleteAdsController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_EditAdsController' => Array(
                'class' => 'Vushop_Controller_Admin_EditAdsController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vushop_Controller_Admin_CategoryListController' => Array(
                'class' => 'Vushop_Controller_Admin_CategoryListController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_CreateCategoryController' => Array(
                'class' => 'Vushop_Controller_Admin_CreateCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_DeleteCategoryController' => Array(
                'class' => 'Vushop_Controller_Admin_DeleteCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_EditCategoryController' => Array(
                'class' => 'Vushop_Controller_Admin_EditCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_MoveDownCategoryController' => Array(
                'class' => 'Vushop_Controller_Admin_MoveDownCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_MoveUpCategoryController' => Array(
                'class' => 'Vushop_Controller_Admin_MoveUpCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vushop_Controller_Admin_ItemListController' => Array(
                'class' => 'Vushop_Controller_Admin_ItemListController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_CreateItemController' => Array(
                'class' => 'Vushop_Controller_Admin_CreateItemController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_EditItemController' => Array(
                'class' => 'Vushop_Controller_Admin_EditItemController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vushop_Controller_Admin_DeleteItemController' => Array(
                'class' => 'Vushop_Controller_Admin_DeleteItemController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vushop_Controller_Admin_SiteSettingsController' => Array(
                'class' => 'Vushop_Controller_Admin_SiteSettingsController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vushop_Controller_Admin_EmailSettingsController' => Array(
                'class' => 'Vushop_Controller_Admin_EmailSettingsController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vushop_Controller_Admin_CatalogSettingsController' => Array(
                'class' => 'Vushop_Controller_Admin_CatalogSettingsController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vushop_Controller_Admin_UpdateIndexController' => Array(
                'class' => 'Vushop_Controller_Admin_UpdateIndexController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))));

/**
 * This class utilizes yadif (http://github.com/beberlei/yadif/)
 * to obtain the controller instance.
 *
 * @author ThanhNB
 */

class Vushop_Controller_ActionHandlerMapping extends Dzit_DefaultActionHandlerMapping {

    /**
     *
     * @var Yadif_Container
     */
    private $yadif;

    public function __construct($router = NULL) {
        parent::__construct($router);
        global $YADIF_CONFIG;
        $this->yadif = new Yadif_Container($YADIF_CONFIG);
    }

    /**
     *
     * @see Dzit_DefaultActionHandlerMapping::getControllerByString()
     */
    protected function getControllerByString($className) {
        return $this->yadif->getComponent($className);
    }
}
