<?php
class Vushop_Controller_ChangeStatusOrderDetailController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'change_status';
    
    /**
     *
     * @var Vushop_Bo_Catalog_BoItem
     */
    private $orderDetail = NULL;
    private $orderId;
    private $itemId;
    private $status;
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
    
    /**
     * Populates itemId and item instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        $this->orderId = isset($_GET['oid']) ? $_GET['oid'] : 0;
        $this->itemId = isset($_GET['iid']) ? $_GET['iid'] : 0;
        $this->status = isset($_GET['s']) ? $_GET['s'] : 0;
        
        $orderDao = $this->getDao(DAO_ORDER);
        $this->orderDetail = $orderDao->getOrderDetailByOrderIdAndItemId($this->orderId, $this->itemId);
    }
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $orderDetail = $this->orderDetail;
        $orderDao = $this->getDao(DAO_ORDER);
        $currenUserId = $_SESSION[SESSION_USER_ID];
        if ($orderDetail !== NULL && $orderDetail->getItem()->getOwnerId() == $currenUserId) {
            $orderDetail->setStatus($this->status);
            $orderDao->updateOrderDetail($orderDetail);
        }
        
        $order = $orderDao->getOrderById($this->orderId);
        $url = $order->getUrlView();
        $view = new Dzit_View_RedirectView($url);
    }

}
