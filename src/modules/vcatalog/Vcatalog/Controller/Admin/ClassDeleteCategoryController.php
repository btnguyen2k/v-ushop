<?php
class Vcatalog_Controller_Admin_DeleteCategoryController extends Vcatalog_Controller_Admin_BaseController {
    const VIEW_NAME = 'admin_deleteCategory';

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
        $catalogDao = $this->getDao(DAO_CATALOG);
        $cat = $catalogDao->getCategoryById($catId);
        return $cat !== NULL;
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
        return $model;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $_SERVER['SCRIPT_NAME'] . '/admin/categories',
                'name' => 'frmCreateCategory');
        if ($this->hasError()) {
            $form['errorMessage'] = $this->errorMsg;
        }
        if (isset($_POST)) {
            $form['parentId'] = isset($_POST['parentId']) ? (int)$_POST['parentId'] : 0;
            $form['categoryTitle'] = isset($_POST['categoryTitle']) ? $_POST['categoryTitle'] : '';
            $form['categoryDescription'] = isset($_POST['categoryDescription']) ? $_POST['categoryDescription'] : '';
        }
        return $form;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::validatePostData()
     */
    protected function validatePostData() {
        /**
         * @var Ddth_Mls_ILanguage
         */
        $lang = $this->getLanguage();

        $parentId = isset($_POST['parentId']) ? (int)$_POST['parentId'] : 0;
        if ($parentId > 0) {
            /**
             * @var Vcatalog_Bo_Catalog_ICatalogDao
             */
            $catalogDao = $this->getDao(DAO_CATALOG);
            $cat = $catalogDao->getCategoryById($parentId);
            if ($cat === NULL || ($cat->getParentId() !== NULL && $cat->getParentId() !== 0)) {
                $this->errorMsg = $lang->getMessage('error.invalidParentCategory');
                return FALSE;
            }
        }

        $title = isset($_POST['categoryTitle']) ? trim($_POST['categoryTitle']) : '';
        if ($title == '') {
            $this->errorMsg = $lang->getMessage('error.emptyCategoryTitle');
            return FALSE;
        }

        return TRUE;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::doFormSubmission()
     */
    protected function doFormSubmission() {
        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $position = time();
        $parentId = isset($_POST['parentId']) ? (int)$_POST['parentId'] : NULL;
        if ($parentId < 1) {
            $parentId = NULL;
        }
        $title = isset($_POST['categoryTitle']) ? trim($_POST['categoryTitle']) : '';
        $desc = isset($_POST['categoryDescription']) ? trim($_POST['categoryDescription']) : '';
        $catalogDao->createCategory($position, $parentId, $title, $desc);

        return TRUE;
    }
}
