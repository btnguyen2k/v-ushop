<?php

include_once 'Yadif/Exception.php';
include_once 'Yadif/Container.php';

global $YADIF_CONFIG;
$YADIF_CONFIG = Array(
        'Vlistings_Controller_HomeController' => Array(
                'class' => 'Vlistings_Controller_HomeController',
                'scope' => 'singleton'),
        'Vlistings_Controller_LoginController' => Array(
                'class' => 'Vlistings_Controller_LoginController',
                'scope' => 'singleton',
                'methods' => Array(Array('method' => 'setSaveUrl', 'arguments' => Array(FALSE)))),
        'Vlistings_Controller_LogoutController' => Array(
                'class' => 'Vlistings_Controller_LogoutController',
                'scope' => 'singleton',
                'methods' => Array(Array('method' => 'setSaveUrl', 'arguments' => Array(FALSE)))),
        'Vlistings_Controller_Admin_HomeController' => Array(
                'class' => 'Vlistings_Controller_Admin_HomeController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vlistings_Controller_Admin_CategoryListController' => Array(
                'class' => 'Vlistings_Controller_Admin_CategoryListController',
                'scope' => 'singleton',
                'methods' => Array(
                        Array('method' => 'setRequireAuthentication', 'arguments' => Array(TRUE)),
                        Array('method' => 'setAllowedUserGroups', 'arguments' => Array(1)))),
        'Vlistings_Controller_Admin_SiteSettingsController' => Array(
                'class' => 'Vlistings_Controller_Admin_SiteSettingsController',
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

class Vlistings_Controller_ActionHandlerMapping extends Dzit_DefaultActionHandlerMapping {

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
