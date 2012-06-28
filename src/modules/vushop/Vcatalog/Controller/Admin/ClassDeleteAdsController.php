<?php
class Vcatalog_Controller_Admin_DeleteAdsController extends Vcatalog_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_delete_ads';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';

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
     * Test if the ads to be deleted is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $ads = $this->ads;
        $adsId = $this->adsId;
        $lang = $this->getLanguage();
        if ($ads === NULL) {
            // the ads must exist
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
        $model[MODEL_INFO_MESSAGES] = Array(
                $lang->getMessage('msg.deleteAds.done', htmlspecialchars($this->adsId)));
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
                'name' => 'frmDeleteAds');
        $lang = $this->getLanguage();
        $ads = $this->ads;
        $infoMsg = $lang->getMessage('msg.deleteAds.confirmation', htmlspecialchars($ads->getTitle()));
        $form['infoMessages'] = Array($infoMsg);
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
         * @var Vcatalog_Bo_TextAds_IAdsDao
         */
        $adsDao = $this->getDao(DAO_TEXTADS);
        $adsDao->deleteAds($this->ads);
        return TRUE;
    }
}
