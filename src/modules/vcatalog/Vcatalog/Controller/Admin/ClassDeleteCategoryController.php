<?php
class Vcatalog_Controller_Admin_DeleteCategoryController extends Vcatalog_Controller_Admin_BaseController {
    const VIEW_NAME = 'admin_deleteCategory';
    const VIEW_NAME_ERROR = 'error';

    private $errorMsg = '';

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::getViewName()
     */
    protected function validateParams() {
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $catId = $requestParser->getPathInfoParam(2);
        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $cat = $catalogDao->getCategoryById($catId);
        if ($cat === NULL) {
            $lang = $this->getLanguage();
            $this->errorMsg = $lang->getMessage('error.categoryNotFound', (int)$catId);
            return FALSE;
        } else {
            $children = $catalogDao->getCategoryChildren($cat);
            if (count($children) > 0) {
                $lang = $this->getLanguage();
                $this->errorMsg = $lang->getMessage('error.deleteNonEmptyCategory', (int)$catId);
                return FALSE;
            }
        }
        return TRUE;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::buildModel()
     */
    protected function buildModel() {
        $model = parent::buildModel();
        if ($model === NULL) {
            $model = Array();
        }
        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $catTree = $catalogDao->getCategoryTree();
        $model['categoryTree'] = $catTree;
        if ($this->hasError()) {
            $model['errorMessage'] = $this->errorMsg;
        }
        return $model;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::getModelAndView_ParamsValidationFails()
     */
    protected function getModelAndView_ParamsValidationFails() {
        $viewName = self::VIEW_NAME_ERROR;
        $model = $this->buildModel_NonPost();
        return new Dzit_ModelAndView($viewName, $model);
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::getModelAndView_AfterPost()
     */
    protected function getModelAndView_AfterPost() {
        $url = $_SERVER['SCRIPT_NAME'] . '/admin/categories';
        $view = new Dzit_View_RedirectView($url);
        return new Dzit_ModelAndView($view);
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $_SERVER['SCRIPT_NAME'] . '/admin/categories',
                'name' => 'frmDeleteCategory');
        $requestParser = Dzit_RequestParser::getInstance();
        $catId = $requestParser->getPathInfoParam(2);
        $catalogDao = $this->getDao(DAO_CATALOG);
        $cat = $catalogDao->getCategoryById($catId);
        $lang = $this->getLanguage();
        $form['infoMessage'] = $lang->getMessage('msg.deleteCategory.confirmation', htmlspecialchars($cat->getTitle()));
        if ($this->hasError()) {
            $form['errorMessage'] = $this->errorMsg;
        }
        return $form;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::doFormSubmission()
     */
    protected function doFormSubmission() {
        $requestParser = Dzit_RequestParser::getInstance();
        $catId = $requestParser->getPathInfoParam(2);
        $catalogDao = $this->getDao(DAO_CATALOG);
        $cat = $catalogDao->getCategoryById($catId);
        $catalogDao->deleteCategory($cat);
        return TRUE;
    }
}
