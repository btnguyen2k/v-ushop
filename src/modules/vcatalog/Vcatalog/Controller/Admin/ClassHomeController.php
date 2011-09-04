<?php
class Vcatalog_Controller_Admin_HomeController extends Vcatalog_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'admin_home';

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
        $model['numCategories'] = $catalogDao->countNumCategories();
        $model['numItems'] = $catalogDao->countNumItems();
        return $model;
    }
}
