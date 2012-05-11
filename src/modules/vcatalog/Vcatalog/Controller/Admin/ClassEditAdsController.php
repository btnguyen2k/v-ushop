<?php
class Vcatalog_Controller_Admin_EditAdsController extends Vcatalog_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_edit_ads';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';

    const FORM_FIELD_ADS_TITLE = 'adsTitle';
    const FORM_FIELD_ADS_URL = 'adsUrl';

    /**
     *
     * @var Vcatalog_Bo_TextAds_BoAds
     */
    private $ads = NULL;
    private $adsId;

    /**
     *
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * Populates adsId and ads instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         *
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->adsId = $requestParser->getPathInfoParam(1);
        /**
         *
         * @var Vcatalog_Bo_TextAds_IAdsDao
         */
        $adsDao = $this->getDao(DAO_TEXTADS);
        $this->ads = $adsDao->getAdsById($this->adsId);
    }

    /**
     * Test if the ads to be edited is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $ads = $this->ads;
        $adsId = $this->adsId;
        if ($ads === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.adsNotFound', htmlspecialchars($adsId)));
            return FALSE;
        }
        return TRUE;
    }

    /**
     *
     * @see Dzit_Controller_FlowController::getModelAndView_Error()
     */
    protected function getModelAndView_Error() {
        $viewName = self::VIEW_NAME_ERROR;
        $model = $this->buildModel();
        if ($model == NULL) {
            $model = Array();
        }

        $lang = $this->getLanguage();
        $model[MODEL_ERROR_MESSAGES] = $this->getErrorMessages();

        return new Dzit_ModelAndView($viewName, $model);
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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.editAds.done'));
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
        if ($this->ads === NULL) {
            return NULL;
        }
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $this->getUrlAdsManagement(),
                'name' => 'frmEditAds');

        $form[self::FORM_FIELD_ADS_TITLE] = $this->ads->getTitle();
        $form[self::FORM_FIELD_ADS_URL] = $this->ads->getUrl();

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

        $this->ads->setTitle($title);
        $this->ads->setUrl($url);

        $adsDao->updateAds($this->ads);

        return TRUE;
    }
}
