<?php
class Vcatalog_Controller_Admin_HomeController extends Vcatalog_Controller_Admin_BaseController {

    const VIEW_NAME = 'admin_home';

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
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
        $model['numCategories'] = $catalogDao->countNumCategories();
        return $model;
    }
}
