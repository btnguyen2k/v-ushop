<?php
class Vushop_Controller_ChangeStatusOrderDetailController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME_ERROR = 'error';
    const VIEW_NAME_AFTER_POST = 'info';
    
    const FORM_FIELD_ORDER_ID = 'orderId';
    const FORM_FIELD_ITEM_ID = 'itemId';
    const FORM_FIELD_STATUS = 'status';
    
    /**
     * @var Vushop_Bo_Catalog_BoItem
     */
    private $orderItem = NULL;
    private $status;
    private $order = NULL;
    
    /**
     * Populates item and quantity.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        if ($this->isPostRequest()) {
            $itemId = isset($_POST[self::FORM_FIELD_ITEM_ID]) ? $_POST[self::FORM_FIELD_ITEM_ID] : 0;
            $orderId = isset($_POST[self::FORM_FIELD_ORDER_ID]) ? $_POST[self::FORM_FIELD_ORDER_ID] : 0;
            $this->status = isset($_POST[self::FORM_FIELD_STATUS]) ? $_POST[self::FORM_FIELD_STATUS] : 0;
          
            /**
             * @var Vushop_Bo_Cart_ICartDao
             */
            $orderDao = $this->getDao(DAO_ORDER);
            $this->order = $orderDao->getOrderById($orderId);
            $this->orderItem = $orderDao->getOrderDetailByOrderIdAndItemId($orderId, $itemId);
        
        }
    }
    
    /**
     * Test if the item to be added is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $lang = $this->getLanguage();
        $result = TRUE;
        if ($this->order === NULL) {
            $this->addErrorMessage($lang->getMessage('error.orderNotFound'));
            $result = FALSE;
        } else if ($this->orderItem === NULL) {
            $this->addErrorMessage($lang->getMessage('error.orderItemNotFound'));
            $result = FALSE;
        }
        return $result;
    }
    
    /**
     * @see Dzit_Controller_FlowController::getModelAndView_Error()
     */
    protected function getModelAndView_Error() {
        $viewName = self::VIEW_NAME_ERROR;
        $model = $this->buildModel();
        if ($model == NULL) {
            $model = Array();
        }
        
        $lang = $this->getLanguage();
        $model[MODEL_ERROR_MESSAGES] = $this->getErrorMessages();
        
        return new Dzit_ModelAndView($viewName, $model);
    }
    
    /**
     * @see Dzit_Controller_FlowController::getModelAndView_FormSubmissionSuccessful()
     */
    protected function getModelAndView_FormSubmissionSuccessful() {
        $url = $this->order->getUrlView();
        $view = new Dzit_View_RedirectView($url);
        return new Dzit_ModelAndView($view, NULL);
    }
    
    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $orderItem = $this->orderItem;
        $status = $this->status;
        $orderItem->setStatus($status);
        $orderDao = $this->getDao(DAO_ORDER);
        $orderDao->updateOrderDetail($orderItem);
        return TRUE;
    }

}
