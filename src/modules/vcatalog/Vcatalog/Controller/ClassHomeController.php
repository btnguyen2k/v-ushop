<?php
class Vcatalog_Controller_HomeController extends Vcatalog_Controller_BaseFlowController {
    const VIEW_NAME = 'home';

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }
        $model[MODEL_REQUEST_MODULE] = 'home';

        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $catTree = $catalogDao->getCategoryTree();
        $model[MODEL_CATEGORY_LIST] = $catTree;

        //$allItems = $catalogDao->getAllItems();
        //$model[MODEL_ITEM_LIST] = $allItems;

        return $model;
    }
}
