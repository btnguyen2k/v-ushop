<?php
class Vcatalog_Controller_Admin_DeletePageController extends Vcatalog_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_delete_page';
    const VIEW_NAME_AFTER_POST = 'info';
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
     * Test if the page to be deleted is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $page = $this->page;
        $pageId = $this->pageId;
        $lang = $this->getLanguage();
        if ($page === NULL) {
            //the page must exist
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
                $lang->getMessage('msg.deletePage.done', htmlspecialchars($this->pageId)));
        $urlTransit = $this->getUrlPageManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        if ($this->page === NULL) {
            return NULL;
        }
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $this->getUrlPageManagement(),
                'name' => 'frmDeletePage');
        $lang = $this->getLanguage();
        $page = $this->page;
        $infoMsg = $lang->getMessage('msg.deletePage.confirmation', htmlspecialchars($page->getTitle()));
        $form['infoMessages'] = Array($infoMsg);
        if ($this->hasError()) {
            $form['errorMessages'] = $this->getErrorMessages();
        }
        return $form;
    }

    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        /**
         * @var Vcatalog_Bo_Page_IPageDao
         */
        $pageDao = $this->getDao(DAO_PAGE);
        $pageDao->deletePage($this->page);
        return TRUE;
    }
}
