<?php
class Vlistings_Controller_Admin_CreateCategoryController extends Vlistings_Controller_Admin_BaseController {
    const VIEW_NAME = 'admin_createCategory';

    private $errorMsg = '';

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::getModelAndView_AfterPost()
     */
    protected function getModelAndView_AfterPost() {
        $url = $_SERVER['SCRIPT_NAME'] . '/admin/categories';
        $view = new Dzit_View_RedirectView($url);
        return new Dzit_ModelAndView($view);
    }

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::buildModel()
     */
    protected function buildModel() {
        $model = parent::buildModel();
        if ($model === NULL) {
            $model = Array();
        }
        /**
         * @var Vlistings_Bo_Listings_IListingsDao
         */
        $listingsDao = $this->getDao('dao.listings');
        $catTree = $listingsDao->getCategoryTree();
        $model['categoryTree'] = $catTree;
        return $model;
    }

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::buildModel_Form()
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
     * @see Vlistings_Controller_BaseController::validatePostData()
     */
    protected function validatePostData() {
        /**
         * @var Ddth_Mls_ILanguage
         */
        $lang = $this->getLanguage();

        $parentId = isset($_POST['parentId']) ? (int)$_POST['parentId'] : 0;
        if ($parentId > 0) {
            /**
             * @var Vlistings_Bo_Listings_IListingsDao
             */
            $listingsDao = $this->getDao('dao.listings');
            $cat = $listingsDao->getCategoryById($parentId);
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
     * @see Vlistings_Controller_BaseController::doFormSubmission()
     */
    protected function doFormSubmission() {
        /**
         * @var Vlistings_Bo_Listings_IListingsDao
         */
        $listingsDao = $this->getDao('dao.listings');
        $position = time();
        $parentId = isset($_POST['parentId']) ? (int)$_POST['parentId'] : NULL;
        if ($parentId < 1) {
            $parentId = NULL;
        }
        $title = isset($_POST['categoryTitle']) ? trim($_POST['categoryTitle']) : '';
        $desc = isset($_POST['categoryDescription']) ? trim($_POST['categoryDescription']) : '';
        $listingsDao->createCategory($position, $parentId, $title, $desc);

        return TRUE;
    }
}
