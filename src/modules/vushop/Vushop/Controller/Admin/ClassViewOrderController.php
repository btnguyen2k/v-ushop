<?php
class Vushop_Controller_Admin_ViewOrderController extends Vushop_Controller_Admin_BaseFlowController {
    
    const VIEW_NAME = 'inline_view_order';
    private $order;
    
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
        $requestParser = Dzit_RequestParser::getInstance();
        $orderId = $requestParser->getPathInfoParam(1);
        $orderDao = $this->getDao(DAO_ORDER);
        $this->order = $orderDao->getOrderById($orderId);
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
         * @var Vushop_Bo_Order_IOrderDao
         */
        $page_size = DEFAULT_PAGE_SIZE;
        $orderDetailList = array();
        $numOrders = 0;
        if ($this->order !== NULL) {
            $orderDao = $this->getDao(DAO_ORDER);
            $orderDetailList = $orderDao->getOrderDetailForOrder($this->order);
            $model['orderObj'] = $this->order;
        }
        $model[MODEL_ORDER_DETAIL] = $orderDetailList;
        if ($orderDetailList != NULL) {
            $priceTotal=0;
            foreach ($orderDetailList as $orderItem) {
                $priceTotal+=$orderItem->getTotal();
            }
            $model['priceTotal'] = Vushop_Utils::formatPrice($priceTotal);
        }
        return $model;
    }
}
