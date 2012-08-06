<?php
class Vushop_Controller_Admin_AdsListController extends Vushop_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'inline_ads_list';

    /**
     *
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
        if ($model === NULL) {
            $model = Array();
        }
        /**
         *
         * @var Vushop_Bo_TextAds_IAdsDao
         */
        $adsDao = $this->getDao(DAO_TEXTADS);
        $allAds = $adsDao->getAds();       
        $model[MODEL_ADS_LIST] = Vushop_Model_AdsBEModel::createModelObj($allAds);
        return $model;
    }
}