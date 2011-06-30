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

        $model['urlSiteSettings'] = $_SERVER['SCRIPT_NAME'] . '/admin/siteSettings';

        $model['urlCategoryManagement'] = $this->getUrlCategoryManagement();
        $model['urlCreateCategory'] = $_SERVER['SCRIPT_NAME'] . '/admin/createCategory';
        $model['urlCreateItem'] = $_SERVER['SCRIPT_NAME'] . '/admin/createItem';

        $model['urlPageManagement'] = $this->getUrlPageManagement();
        $model['urlCreatePage'] = $_SERVER['SCRIPT_NAME'] . '/admin/createPage';

        return $model;
    }

    protected function getUrlCategoryManagement() {
        return $_SERVER['SCRIPT_NAME'] . '/admin/categories';
    }

    protected function getUrlPageManagement() {
        return $_SERVER['SCRIPT_NAME'] . '/admin/pages';
    }
}
