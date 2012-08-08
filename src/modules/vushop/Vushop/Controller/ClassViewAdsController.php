<?php
class Vushop_Controller_ViewAdsController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME_ERROR = 'error';

    /**
     * @var Vushop_Bo_TextAds_BoAds
     */
    private $ads = NULL;
    private $adsId;

    /**
     * Populates adsId and ads instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->adsId = $requestParser->getPathInfoParam(1);
        /**
         * @var Vushop_Bo_TextAds_IAdsDao
         */
        $adsDao = $this->getDao(DAO_TEXTADS);
        $this->ads = $adsDao->getAdsById($this->adsId);
    }

    /**
     * Test if the ads to be viewed is valid.
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
     * @see Dzit_Controller_FlowController::getModelAndView()
     */
    protected function getModelAndView() {
        $adsDao = $this->getDao(DAO_TEXTADS);
        $adsDao->incClicksCount($this->ads);
        $view = new Dzit_View_RedirectView($this->ads->getUrl());
        return new Dzit_ModelAndView($view);
    }

    /**
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
}
