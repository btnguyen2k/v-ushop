<?php
class Vcatalog_Controller_Admin_CategoryListController extends Vcatalog_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'inline_category_list';

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * @see Vcatalog_Controller_Admin_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }
        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $catTree = $catalogDao->getCategoryTree();
        $model[MODEL_CATEGORY_TREE] = $catTree;
        return $model;
    }
}