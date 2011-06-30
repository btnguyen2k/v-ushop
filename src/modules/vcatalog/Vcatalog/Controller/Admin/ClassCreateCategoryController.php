<?php
class Vcatalog_Controller_Admin_CreateCategoryController extends Vcatalog_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'admin_createCategory';
    const VIEW_NAME_AFTER_POST = 'info';

    const FORM_FIELD_PARENT_ID = 'parentId';
    const FORM_FIELD_CATEGORY_TITLE = 'categoryTitle';
    const FORM_FIELD_CATEGORY_DESCRIPTION = 'categoryDescription';

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.createCategory.done'));
        $urlTransit = $this->getUrlCategoryManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Vcatalog_Controller_Admin_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model == NULL) {
            $model = Array();
        }
        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $catTree = $catalogDao->getCategoryTree();
        $model[MODEL_CATEGORY_TREE] = $catTree;
        return $model;
    }

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $this->getUrlCategoryManagement(),
                'name' => 'frmCreateCategory');
        $this->populateForm($form, Array(self::FORM_FIELD_CATEGORY_DESCRIPTION,
                self::FORM_FIELD_CATEGORY_TITLE,
                self::FORM_FIELD_PARENT_ID));
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
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);

        $parentId = isset($_POST[self::FORM_FIELD_PARENT_ID]) ? (int)$_POST[self::FORM_FIELD_PARENT_ID] : 0;
        if ($parentId > 0) {
            /**
             * @var Vcatalog_Bo_Catalog_ICatalogDao
             */
            $catalogDao = $this->getDao(DAO_CATALOG);
            $cat = $catalogDao->getCategoryById($parentId);
            if ($cat === NULL || ($cat->getParentId() !== NULL && $cat->getParentId() !== 0)) {
                $this->addErrorMessage($lang->getMessage('error.invalidParentCategory'));
            }
        }

        $title = isset($_POST[self::FORM_FIELD_CATEGORY_TITLE]) ? trim($_POST[self::FORM_FIELD_CATEGORY_TITLE]) : '';
        if ($title == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyCategoryTitle'));
        }

        if ($this->hasError()) {
            return FALSE;
        }

        $position = time();
        if ($parentId < 1) {
            $parentId = NULL;
        }
        $desc = isset($_POST[self::FORM_FIELD_CATEGORY_DESCRIPTION]) ? trim($_POST[self::FORM_FIELD_CATEGORY_DESCRIPTION]) : '';
        $catalogDao->createCategory($position, $parentId, $title, $desc);

        return TRUE;
    }
}
