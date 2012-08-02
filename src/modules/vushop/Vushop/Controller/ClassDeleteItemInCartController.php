<?php
class Vushop_Controller_DeleteItemInCartController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME_ERROR = 'error';
    const VIEW_NAME_AFTER_POST = 'info';
    
    const FORM_FIELD_ITEM_IDs = 'itemIds';
    
    /**
     * @var Vushop_Bo_Catalog_BoItem
     */
    private $items = array();
    private $itemIds= array();
    
    /**
     * Populates item and quantity.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        if ($this->isPostRequest()) {
            $this->itemIds = isset($_POST[self::FORM_FIELD_ITEM_IDs]) ? $_POST[self::FORM_FIELD_ITEM_IDs] : 0;
            
            /**
             * @var Vushop_Bo_Cart_ICartDao
             */
            for ($i = 0; $i < count($this->itemIds); $i++) {
                $catalogDao = $this->getDao(DAO_CATALOG);
                $this->items[] = $catalogDao->getItemById($this->itemIds[$i]);
            }
        
        }       
    }
    
    /**
     * Test if the item to be added is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        return TRUE;
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
        $url = $this->getCurrentCart()->getUrlView();
        $view = new Dzit_View_RedirectView($url);
        return new Dzit_ModelAndView($view, NULL);
    }
    
    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $items = $this->items;
        /**
         * @var Vushop_Bo_Cart_BoCart
         */
        $cart = $this->getCurrentCart();
        /**
         * @var Vushop_Bo_Cart_ICartDao
         */
        if (is_array($items)) {
            foreach ($items as $item) {
                $cartDao = $this->getDao(DAO_CART);
                if ($cart->existInCart($item)) {
                    $cartItem = $cart->getItem($item);
                    $cartDao->deleteCartItem($cartItem);
                }
            }
        }
        return TRUE;
    }
}
