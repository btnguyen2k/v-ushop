<?php
abstract class Vcatalog_Controller_Admin_BaseController extends Vcatalog_Controller_BaseController {
    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::buildModel()
     */
    protected function buildModel() {
        $model = parent::buildModel();
        if ($model === NULL) {
            $model = Array();
        }

        $model['urlSiteSettings'] = $_SERVER['SCRIPT_NAME'] . '/admin/siteSettings';

        $model['urlCategoryManagement'] = $_SERVER['SCRIPT_NAME'] . '/admin/categories';
        $model['urlCreateCategory'] = $_SERVER['SCRIPT_NAME'] . '/admin/createCategory';
        $model['urlCreateItem'] = $_SERVER['SCRIPT_NAME'] . '/admin/createItem';

        $model['urlPageManagement'] = $_SERVER['SCRIPT_NAME'] . '/admin/pages';
        return $model;
    }
}
