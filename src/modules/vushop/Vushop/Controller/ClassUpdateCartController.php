<?php
class Vushop_Controller_UpdateCartController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME_AFTER_POST = 'info';
    
    const FORM_FIELD_ITEM_IDS = 'updateItemIds';
    const FORM_FIELD_QUANTITYS = 'quantitys';
    
    /**
     * @var Vushop_Bo_Catalog_BoItem
     */
    private $items = Array();
    private $itemIds = Array();
    private $quantitys = Array();
    
    /**
     * Populates item and quantity.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        if ($this->isPostRequest()) {
            $this->itemIds = isset($_POST[self::FORM_FIELD_ITEM_IDS]) ? $_POST[self::FORM_FIELD_ITEM_IDS] : 0;
            $this->quantitys = isset($_POST[self::FORM_FIELD_QUANTITYS]) ? $_POST[self::FORM_FIELD_QUANTITYS] : 0.0;
            
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
        $quantitys = $this->quantitys;
        $items = $this->items;
       
        /**
         * @var Vushop_Bo_Cart_BoCart
         */
        $cart = $this->getCurrentCart();
        /**
         * @var Vushop_Bo_Cart_ICartDao
         */
        if (is_array($items) && is_array($quantitys)) {
            for ($i = 0; $i < count($this->itemIds); $i++) {                
                $cartDao = $this->getDao(DAO_CART);
                if ($cart->existInCart($items[$i])) {
                    $cartItem = $cart->getItem($items[$i]);
                    if (isset($quantitys[$i]) && $quantitys[$i] > 0) {
                        $cartItem->setQuantity($quantitys[$i]);
                        $cartDao->updateCartItem($cartItem);
                    } else {
                        $cartDao->deleteCartItem($cartItem);
                    }
                }
            }
        }
        return TRUE;
    }
}
