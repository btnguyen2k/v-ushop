<?php
class Vlistings_Controller_HomeController extends Vlistings_Controller_BaseController {
    const VIEW_NAME = 'home';

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::buildModel()
     */
    protected function buildModel() {
        $model = parent::buildModel();
        if ($model === NULL) {
            $model = Array();
        }
        $listingsDao = $this->getDao('dao.listings');
        $catTree = $listingsDao->getCategoryTree();
        $model['categoryTree'] = $catTree;
        return $model;
    }
}
