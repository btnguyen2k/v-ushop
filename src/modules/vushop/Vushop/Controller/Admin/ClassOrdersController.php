<?php
class Vushop_Controller_Admin_OrdersController extends Vushop_Controller_Admin_BaseFlowController {
    
    const VIEW_NAME = 'inline_order_list';
    
    private $pageNum;
    private $status;
    
    /**
     *
     * @see Vushop_Controller_Admin_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
    
    /**
     * Populates category and paging info.
     *
     * @see Vushop_Controller_Admin_BaseFlowController::populateParams()
     */
    protected function populateParams() {
        $this->pageNum = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        $this->status = isset($_GET['status']) ? (int)$_GET['status'] : 0;
        if ($this->pageNum < 1) {
            $this->pageNum = 1;
        }
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
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $orderDao = $this->getDao(DAO_ORDER);
        $ownerId = isset($_SESSION[SESSION_USER_ID]) ? $_SESSION[SESSION_USER_ID] : 0;
        $shopDao = $this->getDao(DAO_SHOP);
        $page_size = DEFAULT_PAGE_SIZE;
        $orderList = array();
        $numOrders = 0;
        switch ($this->status) {
            case 1:
                $orderList = $orderDao->getAllOrders($this->pageNum, $page_size, DEFAULT_ORDER_SORTING, FEATURED_ORDER_COMPLETED);
                // paging
                $numOrders = $orderDao->countNumOrders(FEATURED_ORDER_COMPLETED);
                break;
            default:
                $orderList = $orderDao->getAllOrders($this->pageNum, $page_size, DEFAULT_ORDER_SORTING, FEATURED_ORDER_NOT_COMPLETE);
                // paging
                $numOrders = $orderDao->countNumOrders(FEATURED_ORDER_NOT_COMPLETE);
        
        }
        $urlTemplate = $_SERVER['SCRIPT_NAME'] . '/orders/' . '?p=${page}';
        $paginator = new Quack_Model_Paginator($urlTemplate, $numOrders, $page_size, $this->pageNum);
        $model[MODEL_MY_ORDERS] = $orderList;
        $model[MODEL_PAGINATOR] = $paginator;
        $model['status'] = $this->status;
        
        return $model;
    }
}
