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

        return $model;
    }
}
