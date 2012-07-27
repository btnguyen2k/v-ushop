<?php
class Vushop_Controller_ViewCartController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'viewCart';

    /**
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
}
