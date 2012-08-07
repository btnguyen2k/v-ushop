<?php
class Vushop_Controller_OrderDetailController extends Vushop_Controller_BaseFlowController {
    
    const VIEW_NAME = 'orderDetail';
    private $order;
    private $shop;
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
    
    /**
     * Populates category and paging info.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        $requestParser = Dzit_RequestParser::getInstance();
        $orderId = $requestParser->getPathInfoParam(1);
        $orderDao = $this->getDao(DAO_ORDER);
        $this->order = $orderDao->getOrderById($orderId);
        
        $shopId=$_SESSION[SESSION_USER_ID];
        $shopDao=$this->getDao(DAO_SHOP);
        $this->shop=$shopDao->getShopById($shopId);
    }
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }
        
        /**
         *
         * @var Vushop_Bo_Order_IOrderDao
         */
        $page_size = DEFAULT_PAGE_SIZE;
        $orderDetailList=array();
        $numOrders = 0;
        if ($this->order !== NULL && $this->shop!==NULL) {
            $orderDao = $this->getDao(DAO_ORDER);
            $orderDetailList = $orderDao->getOrderDetailForOrderShop($this->order,$this->shop);            
            $model['orderObj'] = $this->order;
        }
        $model[MODEL_ORDER_DETAIL] = $orderDetailList;
        
        return $model;
    }
}
