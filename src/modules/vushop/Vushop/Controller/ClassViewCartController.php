<?php
class Vcatalog_Controller_ViewCartController extends Vcatalog_Controller_BaseFlowController {
    const VIEW_NAME = 'viewCart';

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
}
