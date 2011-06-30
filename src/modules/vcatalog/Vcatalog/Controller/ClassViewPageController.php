<?php
class Vcatalog_Controller_ViewPageController extends Vcatalog_Controller_BaseFlowController {
    const VIEW_NAME = 'viewPage';
    const VIEW_NAME_ERROR = 'error';

    /**
     * @var Vcatalog_Bo_Page_BoPage
     */
    private $page = NULL;
    private $pageId;

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * Populates pageId and page instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->pageId = $requestParser->getPathInfoParam(1);
        /**
         * @var Vcatalog_Bo_Page_IPageDao
         */
        $pageDao = $this->getDao(DAO_PAGE);
        $this->page = $pageDao->getPageById($this->pageId);
    }

    /**
     * Test if the page to be edited is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $page = $this->page;
        $pageId = $this->pageId;
        if ($page === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.pageNotFound', htmlspecialchars($pageId)));
            return FALSE;
        }
        return TRUE;
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

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }

        $model['pageObj'] = $this->page;

        return $model;
    }
}
