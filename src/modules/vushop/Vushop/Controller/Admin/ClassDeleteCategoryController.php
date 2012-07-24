<?php
class Vushop_Controller_Admin_DeleteCategoryController extends Vushop_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_delete_category';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';

    /**
     * @var Vushop_Bo_Catalog_BoCategory
     */
    private $category = NULL;
    private $categoryId;

    /**
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * Populates categoryId and category instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->categoryId = (int)$requestParser->getPathInfoParam(1);
        /**
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $this->category = $catalogDao->getCategoryById($this->categoryId);
        if ($this->category != NULL) {
            $children = $catalogDao->getCategoryChildren($this->category);
            $this->category->setChildren($children);
        }
    }

    /**
     * Test if the category to be deleted is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $cat = $this->category;
        $catId = $this->categoryId;
        $lang = $this->getLanguage();
        if ($cat === NULL) {
            //the category must exist
            $this->addErrorMessage($lang->getMessage('error.categoryNotFound', $catId));
            return FALSE;
        } else if (count($cat->getChildren()) > 0) {
            //the category must not have any child
            $this->addErrorMessage($lang->getMessage('error.deleteNonEmptyCategory', htmlspecialchars($cat->getTitle())));
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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.deleteCategory.done'));
        $urlTransit = $this->getUrlCategoryManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        if ($this->category === NULL) {
            return NULL;
        }
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $this->getUrlCategoryManagement(),
                'name' => 'frmDeleteCategory');
        $lang = $this->getLanguage();
        $cat = $this->category;
        $infoMsg = $lang->getMessage('msg.deleteCategory.confirmation', htmlspecialchars($cat->getTitle()));
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
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $catalogDao->deleteCategory($this->category);
        return TRUE;
    }
}
