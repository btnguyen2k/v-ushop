<?php
class Vushop_Controller_AddToCartController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME_ERROR = 'error';
    const VIEW_NAME_AFTER_POST = 'info';

    const FORM_FIELD_ITEM = 'item';
    const FORM_FIELD_QUANTITY = 'quantity';

    /**
     * @var Vushop_Bo_Catalog_BoItem
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
             * @var Vushop_Bo_Cart_ICartDao
             */
            $catalogDao = $this->getDao(DAO_CATALOG);
            $this->item = $catalogDao->getItemById($this->itemId);
        }
    }

    /**
     * Test if the item to be added is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $item = $this->item;
        $itemId = $this->itemId;
        if ($item === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.itemNotFound', (int)$itemId));
            return FALSE;
        }
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
        $viewName = self::VIEW_NAME_AFTER_POST;
        $model = $this->buildModel();
        if ($model == NULL) {
            $model = Array();
        }

        $lang = $this->getLanguage();
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.addToCart.done'));
        $urlTransit = $this->getCurrentCart()->getUrlView();
        /*
        if (isset($_SESSION[SESSION_LAST_ACCESS_URL])) {
            $urlTransit = $_SESSION[SESSION_LAST_ACCESS_URL];
        } else {
            $urlTransit = $_SERVER['SCRIPT_NAME'];
        }
        */
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
         * @var Vushop_Bo_Cart_BoCart
         */
        $cart = $this->getCurrentCart();
        /**
         * @var Vushop_Bo_Cart_ICartDao
         */
        $cartDao = $this->getDao(DAO_CART);
        if ($cart->existInCart($item)) {
            $cartItem = $cart->getItem($item);
            $currentQuantity = $cartItem->getQuantity();
            $currentQuantity += $quantity;
            if ($currentQuantity > 0) {
                $cartItem->setQuantity($currentQuantity);
                $cartDao->updateCartItem($cartItem);
            } else {
                $cartDao->deleteCartItem($cartItem);
            }
        } else if ($quantity > 0) {
            $cartDao->createCartItem($cart, $item->getId(), $quantity, $item->getPrice());
        }
        return TRUE;
    }
}
