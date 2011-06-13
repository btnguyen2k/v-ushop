<?php
class Vlistings_Controller_Admin_CategoryListController extends Vlistings_Controller_Admin_BaseController {

    const VIEW_NAME = 'admin_categoryList';

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