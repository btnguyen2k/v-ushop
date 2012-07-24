<?php
class Vushop_Controller_Admin_PageListController extends Vushop_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'inline_page_list';

    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     *
     * @see Vushop_Controller_Admin_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }
        /**
         *
         * @var Vushop_Bo_Page_IPageDao
         */
        $pageDao = $this->getDao(DAO_PAGE);
        // $allPages = $pageDao->getAllPages();
        $allPages = $pageDao->getPages();
        // $model[MODEL_PAGE_LIST] = $allPages;
        $model[MODEL_PAGE_LIST] = Vushop_Model_PageBEModel::createModelObj($allPages);
        return $model;
    }
}