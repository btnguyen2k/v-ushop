<?php
class Vushop_Controller_Admin_BaseFlowController extends Vushop_Controller_BaseFlowController {
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model == NULL) {
            $model = Array();
        }
        
        $model['urlDashboard'] = $_SERVER['SCRIPT_NAME'] . '/dashboard';
        
        // $model['urlEmailSettings'] = $_SERVER['SCRIPT_NAME'] .
        // '/admin/emailSettings';
        // $model['urlSiteSettings'] = $_SERVER['SCRIPT_NAME'] .
        // '/admin/siteSettings';
        // $model['urlCatalogSettings'] = $_SERVER['SCRIPT_NAME'] .
        // '/admin/catalogSettings';
        $model['urlEmailSettings'] = $_SERVER['SCRIPT_NAME'] . '/emailSettings';
        $model['urlSiteSettings'] = $_SERVER['SCRIPT_NAME'] . '/siteSettings';
        $model['urlCatalogSettings'] = $_SERVER['SCRIPT_NAME'] . '/catalogSettings';
        
        $model['urlCategoryManagement'] = $this->getUrlCategoryManagement();
        // $model['urlCreateCategory'] = $_SERVER['SCRIPT_NAME'] .
        // '/admin/createCategory';
        $model['urlCreateCategory'] = $_SERVER['SCRIPT_NAME'] . '/createCategory';
        $model['urlItemManagement'] = $this->getUrlItemManagement();
        // $model['urlCreateItem'] = $_SERVER['SCRIPT_NAME'] .
        // '/admin/createItem';
        $model['urlCreateItem'] = $_SERVER['SCRIPT_NAME'] . '/createItem';
        
        $model['urlPageManagement'] = $this->getUrlPageManagement();
        // $model['urlCreatePage'] = $_SERVER['SCRIPT_NAME'] .
        // '/admin/createPage';
        $model['urlCreatePage'] = $_SERVER['SCRIPT_NAME'] . '/createPage';
        
        $model['urlAdsManagement'] = $this->getUrlAdsManagement();
        // $model['urlCreateAds'] = $_SERVER['SCRIPT_NAME'] .
        // '/admin/createAds';
        $model['urlCreateAds'] = $_SERVER['SCRIPT_NAME'] . '/createAds';
        
        // '/admin/userList';
        $model['urlUserManagement'] = $this->getUrlUserManagement();
        // '/admin/createUser';
        $model['urlCreateUser'] = $_SERVER['SCRIPT_NAME'] . '/createUser';
        
        return $model;
    }
    
    protected function getUrlCategoryManagement() {
        // return $_SERVER['SCRIPT_NAME'] . '/admin/categories';
        return $_SERVER['SCRIPT_NAME'] . '/categories';
    }
    
    protected function getUrlItemManagement() {
        // return $_SERVER['SCRIPT_NAME'] . '/admin/items';
        return $_SERVER['SCRIPT_NAME'] . '/items';
    }
    
    protected function getUrlPageManagement() {
        // return $_SERVER['SCRIPT_NAME'] . '/admin/pages';
        return $_SERVER['SCRIPT_NAME'] . '/pages';
    }
    
    protected function getUrlAdsManagement() {
        // return $_SERVER['SCRIPT_NAME'] . '/admin/ads';
        return $_SERVER['SCRIPT_NAME'] . '/ads';
    }
    
    protected function getUrlUserManagement() {
        // return $_SERVER['SCRIPT_NAME'] . '/admin/users';
        return $_SERVER['SCRIPT_NAME'] . '/users';
    }
}
