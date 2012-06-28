<?php
class Vcatalog_Controller_Admin_CreateAdsController extends Vcatalog_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_create_ads';
    const VIEW_NAME_AFTER_POST = 'info';

    const FORM_FIELD_ADS_TITLE = 'adsTitle';
    const FORM_FIELD_ADS_URL = 'adsUrl';

    /**
     *
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     *
     * @see Dzit_Controller_FlowController::getModelAndView_FormSubmissionSuccessful()
     */
    protected function getModelAndView_FormSubmissionSuccessful() {
        $viewName = self::VIEW_NAME_AFTER_POST;
        $model = $this->buildModel();
        if ($model == NULL) {
            $model = Array();
        }

        $lang = $this->getLanguage();
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.createAds.done'));
        $urlTransit = $this->getUrlAdsManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     *
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $this->getUrlAdsManagement(),
                'name' => 'frmCreateAds');
        $this->populateForm($form, Array(self::FORM_FIELD_ADS_TITLE, self::FORM_FIELD_ADS_URL));
        if ($this->hasError()) {
            $form['errorMessages'] = $this->getErrorMessages();
        }
        return $form;
    }

    /**
     *
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        /**
         *
         * @var Ddth_Mls_ILanguage
         */
        $lang = $this->getLanguage();

        /**
         *
         * @var Vcatalog_Bo_TextAds_IAdsDao
         */
        $adsDao = $this->getDao(DAO_TEXTADS);

        $title = isset($_POST[self::FORM_FIELD_ADS_TITLE]) ? trim($_POST[self::FORM_FIELD_ADS_TITLE]) : '';
        if ($title == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyAdsTitle'));
        }

        $url = isset($_POST[self::FORM_FIELD_ADS_URL]) ? trim($_POST[self::FORM_FIELD_ADS_URL]) : '';
        if ($url == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyAdsUrl'));
        }

        if ($this->hasError()) {
            return FALSE;
        }

        $ads = new Vcatalog_Bo_TextAds_BoAds();
        $ads->populate(Array(Vcatalog_Bo_TextAds_BoAds::COL_TITLE => $title,
                Vcatalog_Bo_TextAds_BoAds::COL_URL => $url,
                Vcatalog_Bo_TextAds_BoAds::COL_CLICKS => 0));
        $adsDao->createAds($ads);

        return TRUE;
    }
}
