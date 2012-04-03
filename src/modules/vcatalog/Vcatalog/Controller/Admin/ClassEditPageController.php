<?php
class Vcatalog_Controller_Admin_EditPageController extends Vcatalog_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'admin_editPage';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';

    const FORM_FIELD_PAGE_CATEGORY = 'pageCategory';
    const FORM_FIELD_PAGE_TITLE = 'pageTitle';
    const FORM_FIELD_PAGE_CONTENT = 'pageContent';
    const FORM_FIELD_ON_MENU = 'onMenu';

    /**
     * @var Quack_Bo_Page_BoPage
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
        $this->pageId = $requestParser->getPathInfoParam(2);
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
        //$urlTransit = $this->getUrlPageManagement();
        //$model[MODEL_URL_TRANSIT] = $urlTransit;
        //$model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);


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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.editPage.done'));
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
                'name' => 'frmEditPage');

        $form[self::FORM_FIELD_ON_MENU] = PAGE_ATTR_ONMENU == ($this->page->getAttr() & PAGE_ATTR_ONMENU);
        $form[self::FORM_FIELD_PAGE_CONTENT] = $this->page->getContent();
        $form[self::FORM_FIELD_PAGE_TITLE] = $this->page->getTitle();
        $form[self::FORM_FIELD_PAGE_CATEGORY] = $this->page->getCategory();

        $this->populateForm($form, Array(self::FORM_FIELD_PAGE_CONTENT,
                self::FORM_FIELD_PAGE_CATEGORY,
                self::FORM_FIELD_PAGE_TITLE,
                self::FORM_FIELD_ON_MENU));
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
         * @var Ddth_Mls_ILanguage
         */
        $lang = $this->getLanguage();

        /**
         * @var Vcatalog_Bo_Page_IPageDao
         */
        $pageDao = $this->getDao(DAO_PAGE);

        $category = isset($_POST[self::FORM_FIELD_PAGE_CATEGORY]) ? trim($_POST[self::FORM_FIELD_PAGE_CATEGORY]) : '';

        $title = isset($_POST[self::FORM_FIELD_PAGE_TITLE]) ? trim($_POST[self::FORM_FIELD_PAGE_TITLE]) : '';
        if ($title == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyPageTitle'));
        }

        if ($this->hasError()) {
            return FALSE;
        }

        $onMenu = isset($_POST[self::FORM_FIELD_ON_MENU]) ? (boolean)$_POST[self::FORM_FIELD_ON_MENU] : FALSE;
        $content = isset($_POST[self::FORM_FIELD_PAGE_CONTENT]) ? trim($_POST[self::FORM_FIELD_PAGE_CONTENT]) : '';

        $this->page->setContent($content);
        $this->page->setTitle($title);
        $this->page->setCategory($category);
        if ( $onMenu ) {
            $this->page->setAttr($this->page->getAttr() | PAGE_ATTR_ONMENU);
        } else {
            $this->page->setAttr($this->page->getAttr() & !PAGE_ATTR_ONMENU);
        }

        $pageDao->updatePage($this->page);

        return TRUE;
    }
}
