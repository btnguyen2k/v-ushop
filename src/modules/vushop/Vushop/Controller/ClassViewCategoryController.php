<?php
class Vushop_Controller_ViewCategoryController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'viewCategory';
    const VIEW_NAME_ERROR = 'error';
    
    /**
     * @var Vushop_Bo_Catalog_BoCategory
     */
    private $category = NULL;
    private $categoryId;
    private $itemSorting;
    private $pageNum;
    
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
        if ($this->category !== NULL) {
            $children = $catalogDao->getCategoryChildren($this->category);
            $this->category->setChildren($children);
        }
        
        $this->itemSorting = isset($_SESSION[SESSION_ITEM_SORTING]) ? $_SESSION[SESSION_ITEM_SORTING] : DEFAULT_ITEM_SORTING;
        if (isset($_GET['s'])) {
            $this->itemSorting = $_GET['s'];
        }
        if ($this->itemSorting !== ITEM_SORTING_PRICEASC && $this->itemSorting !== ITEM_SORTING_PRICEDESC && $this->itemSorting !== ITEM_SORTING_TIMEASC && $this->itemSorting !== ITEM_SORTING_TIMEDESC && $this->itemSorting !== ITEM_SORTING_TITLE) {
            $this->itemSorting = DEFAULT_ITEM_SORTING;
        }
        $_SESSION[SESSION_ITEM_SORTING] = $this->itemSorting;
        
        $this->pageNum = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        if ($this->pageNum < 1) {
            $this->pageNum = 1;
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
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }
        
        $model['categoryObj'] = $this->category;
        
        /**
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $pageSize = DEFAULT_PAGE_SIZE;
        $itemSorting = $this->itemSorting;
        if (isset($_SESSION[SESSION_SHOP_ID])) {
            $itemList = $catalogDao->getItemsForCategoryShop($this->category, $_SESSION[SESSION_SHOP_ID], $this->pageNum, $pageSize, $itemSorting);
            $model[MODEL_ITEM_LIST] = $itemList;
            $model[CATEGORY_NAME] = $this->category->getTitle();
            $urlTemplate = $this->category->getUrlView() . '?p=${PAGE}';
            $urlTemplate .= '&s=' . $this->itemSorting;
            $numItems = $catalogDao->countNumItemsForCategoryShop($this->category,$_SESSION[SESSION_SHOP_ID]);
            $paginator = new Quack_Model_Paginator($urlTemplate, $numItems, $pageSize, 
                    $this->pageNum);
            $model[MODEL_PAGINATOR] = $paginator;
        
        } else {
            $itemsInPage = $catalogDao->getItemsForCategory($this->category, $this->pageNum, $pageSize, $itemSorting);
            $model[MODEL_ITEM_LIST] = $itemsInPage;
            $model[CATEGORY_NAME] = $this->category->getTitle();
            $urlTemplate = $this->category->getUrlView() . '?p=${PAGE}';
            $urlTemplate .= '&s=' . $this->itemSorting;
            $numItems = $catalogDao->countNumItemsForCategory($this->category);
            $paginator = new Quack_Model_Paginator($urlTemplate, $numItems, $pageSize, 
                    $this->pageNum);
            $model[MODEL_PAGINATOR] = $paginator;
        }
        
        return $model;
    }
}
