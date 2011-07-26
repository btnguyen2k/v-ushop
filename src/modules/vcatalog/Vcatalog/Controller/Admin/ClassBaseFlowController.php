<?php
class Vcatalog_Controller_Admin_BaseFlowController extends Vcatalog_Controller_BaseFlowController {

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model == NULL) {
            $model = Array();
        }

        $model['urlEmailSettings'] = $_SERVER['SCRIPT_NAME'] . '/admin/emailSettings';
        $model['urlSiteSettings'] = $_SERVER['SCRIPT_NAME'] . '/admin/siteSettings';
        $model['urlCatalogSettings'] = $_SERVER['SCRIPT_NAME'] . '/admin/catalogSettings';

        $model['urlCategoryManagement'] = $this->getUrlCategoryManagement();
        $model['urlCreateCategory'] = $_SERVER['SCRIPT_NAME'] . '/admin/createCategory';
        $model['urlItemManagement'] = $this->getUrlItemManagement();
        $model['urlCreateItem'] = $_SERVER['SCRIPT_NAME'] . '/admin/createItem';

        $model['urlPageManagement'] = $this->getUrlPageManagement();
        $model['urlCreatePage'] = $_SERVER['SCRIPT_NAME'] . '/admin/createPage';

        return $model;
    }

    protected function getUrlCategoryManagement() {
        return $_SERVER['SCRIPT_NAME'] . '/admin/categories';
    }

    protected function getUrlItemManagement() {
        return $_SERVER['SCRIPT_NAME'] . '/admin/items';
    }

    protected function getUrlPageManagement() {
        return $_SERVER['SCRIPT_NAME'] . '/admin/pages';
    }
}
