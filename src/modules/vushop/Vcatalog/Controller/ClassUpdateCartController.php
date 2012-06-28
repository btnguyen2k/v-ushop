<?php
class Vcatalog_Controller_UpdateCartController extends Vcatalog_Controller_BaseFlowController {
    const VIEW_NAME_AFTER_POST = 'info';

    const FORM_FIELD_ITEM = 'item';
    const FORM_FIELD_QUANTITY = 'quantity';

    /**
     * @var Vcatalog_Bo_Catalog_BoItem
     */
    private $item = NULL;
    private $itemId;
    private $quantity = 0;

    /**
     * Populates item and quantity.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        if ($this->isPostRequest()) {
            $this->itemId = isset($_POST[self::FORM_FIELD_ITEM]) ? $_POST[self::FORM_FIELD_ITEM] : 0;
            $this->quantity = isset($_POST[self::FORM_FIELD_QUANTITY]) ? (double)$_POST[self::FORM_FIELD_QUANTITY] : 0.0;

            /**
             * @var Vcatalog_Bo_Cart_ICartDao
             */
            $catalogDao = $this->getDao(DAO_CATALOG);
            $this->item = $catalogDao->getItemById($this->itemId);
        }
    }

    /**
     * @see Dzit_Controller_FlowController::getModelAndView_FormSubmissionSuccessful()
     */
    protected function getModelAndView_FormSubmissionSuccessful() {
        $viewName = self::VIEW_NAME_AFTER_POST;
        $model = $this->buildModel();
        if ($model == NULL) {
            $model = Array();
        }

        $lang = $this->getLanguage();
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.updateCart.done'));
        $urlTransit = $this->getCurrentCart()->getUrlView();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $quantity = $this->quantity;
        $item = $this->item;
        /**
         * @var Vcatalog_Bo_Cart_BoCart
         */
        $cart = $this->getCurrentCart();
        /**
         * @var Vcatalog_Bo_Cart_ICartDao
         */
        $cartDao = $this->getDao(DAO_CART);
        if ($cart->existInCart($item)) {
            $cartItem = $cart->getItem($item);
            if ($quantity > 0) {
                $cartItem->setQuantity($quantity);
                $cartDao->updateCartItem($cartItem);
            } else {
                $cartDao->deleteCartItem($cartItem);
            }
        }
        return TRUE;
    }
}
