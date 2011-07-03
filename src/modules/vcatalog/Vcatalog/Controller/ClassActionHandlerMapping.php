<?php

include_once 'Yadif/Exception.php';
include_once 'Yadif/Container.php';

global $YADIF_CONFIG;
$YADIF_CONFIG = Array(
        'Vcatalog_Controller_HomeController' => Array(
                'class' => 'Vcatalog_Controller_HomeController',
                'scope' => 'singleton'),

        'Vcatalog_Controller_ViewPageController' => Array(
                'class' => 'Vcatalog_Controller_ViewPageController',
                'scope' => 'singleton'),

        'Vcatalog_Controller_LoginController' => Array(
                'class' => 'Vcatalog_Controller_LoginController',
                'scope' => 'singleton',
                'methods' => Array(Array('method' => 'setSaveUrl', 'arguments' => Array(FALSE)))),
        'Vcatalog_Controller_LogoutController' => Array(
                'class' => 'Vcatalog_Controller_LogoutController',
                'scope' => 'singleton',
                'methods' => Array(Array('method' => 'setSaveUrl', 'arguments' => Array(FALSE)))),

        'Vcatalog_Controller_Admin_HomeController' => Array(
                'class' => 'Vcatalog_Controller_Admin_HomeController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vcatalog_Controller_Admin_PageListController' => Array(
                'class' => 'Vcatalog_Controller_Admin_PageListController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_CreatePageController' => Array(
                'class' => 'Vcatalog_Controller_Admin_CreatePageController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_DeletePageController' => Array(
                'class' => 'Vcatalog_Controller_Admin_DeletePageController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_EditPageController' => Array(
                'class' => 'Vcatalog_Controller_Admin_EditPageController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vcatalog_Controller_Admin_CategoryListController' => Array(
                'class' => 'Vcatalog_Controller_Admin_CategoryListController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_CreateCategoryController' => Array(
                'class' => 'Vcatalog_Controller_Admin_CreateCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_DeleteCategoryController' => Array(
                'class' => 'Vcatalog_Controller_Admin_DeleteCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_EditCategoryController' => Array(
                'class' => 'Vcatalog_Controller_Admin_EditCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_MoveDownCategoryController' => Array(
                'class' => 'Vcatalog_Controller_Admin_MoveDownCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_MoveUpCategoryController' => Array(
                'class' => 'Vcatalog_Controller_Admin_MoveUpCategoryController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vcatalog_Controller_Admin_ItemListController' => Array(
                'class' => 'Vcatalog_Controller_Admin_ItemListController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_CreateItemController' => Array(
                'class' => 'Vcatalog_Controller_Admin_CreateItemController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_EditItemController' => Array(
                'class' => 'Vcatalog_Controller_Admin_EditItemController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vcatalog_Controller_Admin_DeleteItemController' => Array(
                'class' => 'Vcatalog_Controller_Admin_DeleteItemController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),

        'Vcatalog_Controller_Admin_SiteSettingsController' => Array(
                'class' => 'Vcatalog_Controller_Admin_SiteSettingsController',
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

class Vcatalog_Controller_ActionHandlerMapping extends Dzit_DefaultActionHandlerMapping {

    /**
     * @var Yadif_Container
     */
    private $yadif;

    public function __construct($router = NULL) {
        parent::__construct($router);
        global $YADIF_CONFIG;
        $this->yadif = new Yadif_Container($YADIF_CONFIG);
    }

    /**
     * @see Dzit_DefaultActionHandlerMapping::getControllerByString()
     */
    protected function getControllerByString($className) {
        return $this->yadif->getComponent($className);
    }
}
