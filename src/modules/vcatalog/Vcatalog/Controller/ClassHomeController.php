<?php
class Vcatalog_Controller_HomeController extends Vcatalog_Controller_BaseFlowController {
    const VIEW_NAME = 'home';

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }

        return $model;
    }
}
