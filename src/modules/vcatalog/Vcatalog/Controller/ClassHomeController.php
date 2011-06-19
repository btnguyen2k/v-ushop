<?php
class Vcatalog_Controller_HomeController extends Vcatalog_Controller_BaseController {
    const VIEW_NAME = 'home';

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
        $catalogDao = $this->getDao(DAO_CATALOG);
        $catTree = $catalogDao->getCategoryTree();
        $model['categoryTree'] = $catTree;
        return $model;
    }
}
