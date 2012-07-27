<?php
class Vushop_Controller_HomeController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'home';
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
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
       
        
        /**
         *
         * @var Vushop_Bo_Catalog_BoItem
         */
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::push('getItems.hot');
        }
        $hotItems = $catalogDao->getAllItems(1, PHP_INT_MAX, DEFAULT_ITEM_SORTING, FEATURED_ITEM_HOT);
        if ($hotItems !== NULL && count($hotItems) > 0) {
            $model[MODEL_HOT_ITEMS] = $hotItems;
        }
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::pop();
        }
        
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::push('getItems.new');
        }
        $newItems = $catalogDao->getAllItems(1, PHP_INT_MAX, DEFAULT_ITEM_SORTING, FEATURED_ITEM_NEW);
        if ($newItems !== NULL && count($newItems) > 0) {
            $model[MODEL_NEW_ITEMS] = $newItems;
        }
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::pop();
        }
        
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::push('getItems.featured');
        }
        $featuredItems = $catalogDao->getAllItems(1, 30, DEFAULT_ITEM_SORTING, FEATURED_ITEM_ALL);
        if ($featuredItems !== NULL && count($featuredItems) > 0) {
            $model[MODEL_FEATURED_ITEMS] = $featuredItems;
        }
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::pop();
        }
        
        return $model;
    }
}
