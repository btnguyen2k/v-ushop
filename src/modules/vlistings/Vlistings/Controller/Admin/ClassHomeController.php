<?php
class Vlistings_Controller_Admin_HomeController extends Vlistings_Controller_Admin_BaseController {

    const VIEW_NAME = 'admin_home';

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
        /**
         * @var Vlistings_Bo_Listings_IListingsDao
         */
        $listingsDao = $this->getDao('dao.listings');
        $model['numCategories'] = $listingsDao->countNumCategories();
        return $model;
    }
}
