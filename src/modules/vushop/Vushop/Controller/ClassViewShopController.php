<?php
class Vushop_Controller_ViewShopController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'viewShop';
    const VIEW_NAME_ERROR = 'error';
    
    /**
     * @var Vushop_Bo_Catalog_BoCategory
     */
    private $shop = NULL;
    private $ownerId;
    
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
        $this->ownerId = (int)$requestParser->getPathInfoParam(1);
        /**
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $shopDao = $this->getDao(DAO_SHOP);
        $this->shop = $shopDao->getShopById($this->ownerId);
        
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
        $shop = $this->shop;
        $ownerId = $this->ownerId;
        if ($shop === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.shopNotFound', (int)$ownerId));
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
        
        $model['shopObject'] = $this->shop;
        
        /**
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $categories=$catalogDao->getCategoryTree();  
        foreach ($categories as $category) {
            $itemList=$catalogDao->getItemsForCategoryShop($category,$this->ownerId,1,PHP_INT_MAX);
            if (isset($itemList) && count($itemList) > 0 ) {
                $category->setItemsForCategoryShop($itemList);
            }            
        }   
        $model[MODEL_CATEGORY_LIST]=$categories;
        
        return $model;
    }
}
