<?php
class Vcatalog_Controller_Admin_AdsListController extends Vcatalog_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'inline_ads_list';

    /**
     *
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     *
     * @see Vcatalog_Controller_Admin_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }
        /**
         *
         * @var Vcatalog_Bo_TextAds_IAdsDao
         */
        $adsDao = $this->getDao(DAO_TEXTADS);
        $allAds = $adsDao->getAds();
        $model[MODEL_ADS_LIST] = Vcatalog_Model_AdsBEModel::createModelObj($allAds);
        return $model;
    }
}