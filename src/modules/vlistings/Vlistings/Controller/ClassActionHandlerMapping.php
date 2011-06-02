<?php

include_once 'Yadif/Container.php';

global $YADIF_CONFIG;
$YADIF_CONFIG = Array(
        'Vlistings_Controller_HomeController' => Array(
                'class' => 'Vlistings_Controller_HomeController',
                'scope' => 'singleton'));

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
