<?php
class Vushop_Controller_HomeController extends Vushop_Controller_BaseFlowController {
    
    const VIEW_NAME = 'home';
    
    private $pageNum;
    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
    
    /**
     * Populates shop and paging info.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        $this->pageNum = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        $catId = isset($_GET['c']) ? (int)$_GET['c'] : 0;
        
        if ($this->pageNum < 1) {
            $this->pageNum = 1;
        }
    }
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        /**
         *
         * Clear SESSION_SHOP_ID
         */
        if (isset($_SESSION[SESSION_SHOP_ID])) {
            unset($_SESSION[SESSION_SHOP_ID]);
        }
        
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }
        $model[MODEL_REQUEST_MODULE] = 'home';
        
        /**
         *
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        
        $catTree = $catalogDao->getCategoryTree();
        $model[MODEL_CATEGORY_LIST] = $catTree;
        
        // shop
        $shopDao = $this->getDao(DAO_SHOP);
        $pageSize = DEFAULT_PAGE_SIZE_SHOP;
        $shopOwners = $shopDao->getShops($this->pageNum, $pageSize);
        $model[MODEL_SHOP_LIST] = Vushop_Model_ShopModel::createModelObj($shopOwners);
        // paging
        $numItems = $shopDao->getCountNumShops();
        $urlTemplate =$_SERVER['SCRIPT_NAME'] . '?p=${page}';
        $paginator = new Quack_Model_Paginator($urlTemplate, $numItems, $pageSize, $this->pageNum);
        $model[MODEL_PAGINATOR] = $paginator;
        return $model;
    }
}
