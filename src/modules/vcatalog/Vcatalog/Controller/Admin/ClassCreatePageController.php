<?php
class Vcatalog_Controller_Admin_CreatePageController extends Vcatalog_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_create_page';
    const VIEW_NAME_AFTER_POST = 'info';

    const FORM_FIELD_PAGE_ID = 'pageId';
    const FORM_FIELD_PAGE_CATEGORY = 'pageCategory';
    const FORM_FIELD_PAGE_TITLE = 'pageTitle';
    const FORM_FIELD_PAGE_CONTENT = 'pageContent';
    const FORM_FIELD_ON_MENU = 'onMenu';

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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.createPage.done'));
        $urlTransit = $this->getUrlPageManagement();
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
                'actionCancel' => $this->getUrlPageManagement(),
                'name' => 'frmCreatePage');
        $this->populateForm($form, Array(self::FORM_FIELD_PAGE_CONTENT,
                self::FORM_FIELD_PAGE_ID,
                self::FORM_FIELD_PAGE_CATEGORY,
                self::FORM_FIELD_PAGE_TITLE,
                self::FORM_FIELD_ON_MENU));
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
         * @var Vcatalog_Bo_Page_IPageDao
         */
        $pageDao = $this->getDao(DAO_PAGE);

        $pageId = isset($_POST[self::FORM_FIELD_PAGE_ID]) ? trim(strtolower($_POST[self::FORM_FIELD_PAGE_ID])) : '';
        if ($pageDao->getPageById($pageId) !== NULL) {
            $this->addErrorMessage($lang->getMessage('error.pageExists', htmlspecialchars($pageId)));
        } elseif (!preg_match('/^\\w+$/', $pageId)) {
            $this->addErrorMessage($lang->getMessage('error.invalidPageId', htmlspecialchars($pageId)));
        }

        $category = isset($_POST[self::FORM_FIELD_PAGE_CATEGORY]) ? trim($_POST[self::FORM_FIELD_PAGE_CATEGORY]) : '';

        $title = isset($_POST[self::FORM_FIELD_PAGE_TITLE]) ? trim($_POST[self::FORM_FIELD_PAGE_TITLE]) : '';
        if ($title == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyPageTitle'));
        }

        if ($this->hasError()) {
            return FALSE;
        }

        $position = time();
        $onMenu = isset($_POST[self::FORM_FIELD_ON_MENU]) ? (boolean)$_POST[self::FORM_FIELD_ON_MENU] : FALSE;

        $content = isset($_POST[self::FORM_FIELD_PAGE_CONTENT]) ? trim($_POST[self::FORM_FIELD_PAGE_CONTENT]) : '';

        $page = new Quack_Bo_Page_BoPage();
        $page->populate(Array(Quack_Bo_Page_BoPage::COL_ID => $pageId,
                Quack_Bo_Page_BoPage::COL_ATTR => $onMenu ? PAGE_ATTR_ONMENU : 0,
                Quack_Bo_Page_BoPage::COL_CATEGORY => $category,
                Quack_Bo_Page_BoPage::COL_CONTENT => $content,
                Quack_Bo_Page_BoPage::COL_POSITION => $position,
                Quack_Bo_Page_BoPage::COL_TITLE => $title));
        $pageDao->createPage($page);
        // $pageDao->createPage($pageId, $position, $category, $title, $content,
        // $onMenu);

        return TRUE;
    }
}
