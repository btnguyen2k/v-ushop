<?php
class Vushop_Controller_PrintCartController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'printCart';

    /**
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
    
/**
     *
     * @see Vushop_Controller_Admin_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
          $lang = $this->getLanguage();
        $model['msgDelete'] = $lang->getMessage('msg.areYouSureYouWantToDeleteThereItems');
        return $model;
    }
}
