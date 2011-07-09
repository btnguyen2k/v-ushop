<?php
class Vcatalog_Controller_ViewCategoryController extends Vcatalog_Controller_BaseFlowController {
    const VIEW_NAME = 'viewCategory';
    const VIEW_NAME_ERROR = 'error';

    /**
     * @var Vcatalog_Bo_Catalog_BoCategory
     */
    private $category = NULL;
    private $categoryId;

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
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
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $this->category = $catalogDao->getCategoryById($this->categoryId);
        if ($this->category != NULL) {
            $children = $catalogDao->getCategoryChildren($this->category);
            $this->category->setChildren($children);
            //print_r($children);
        }
    }

    /**
     * Test if the category to be viewed is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $category = $this->category;
        $categoryId = $this->categoryId;
        if ($category === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.categoryNotFound', (int)$categoryId));
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

        $model['categoryObj'] = $this->category;

        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $allItems = $catalogDao->getItemsForCategory($this->category);
        $model[MODEL_ITEM_LIST] = $allItems;

        return $model;
    }
}
