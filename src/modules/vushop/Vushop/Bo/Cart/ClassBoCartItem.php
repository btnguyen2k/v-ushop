<?php
class Vushop_Bo_Cart_BoCartItem extends Vushop_Bo_Catalog_BoItem {

    /* Database table columns */
    const COL_SESSION_ID = 'session_id';
    const COL_ITEM_ID = 'item_id';
    const COL_QUANTITY = 'item_quantity';
    const COL_PRICE = 'item_price';

    private $sessionId, $itemId, $quantity;

    private $urlView = NULL;
    private $shop=NULL;

    /**
     * @see Quack_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        $parentPieldMap = parent::getFieldMap();
        $myFieldMap = Array(self::COL_ITEM_ID => Array('itemId', self::TYPE_INT),
                self::COL_PRICE => Array('price', self::TYPE_DOUBLE),
                self::COL_QUANTITY => Array('quantity', self::TYPE_DOUBLE),
                self::COL_SESSION_ID => Array('sessionId'));
        return array_merge($parentPieldMap, $myFieldMap);
    }

    /**
     * Gets the URL to view the cart item.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
            $this->urlView = $_SERVER['SCRIPT_NAME'] . '/cartItem/' . $this->id;
        }
        return $this->urlView;
    }

    /**
     * Getter for $sessionId.
     *
     * @return string
     */
    public function getSessionId() {
        return $this->sessionId;
    }

    /**
     * Setter for $sessionId.
     *
     * @param string $sessionId
     */
    public function setSessionId($sessionId) {
        $this->sessionId = $sessionId;
    }

    /**
     * Getter for $itemId.
     *
     * @return int
     */
    public function getItemId() {
        return $this->itemId;
    }

    /**
     * Setter for $itemId.
     *
     * @param int $itemId
     */
    public function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    /**
     * Adds a number of items to the cart.
     *
     * @param double $quantity
     */
    public function addQuantity($quantity = 1) {
        $this->quantity += $quantity;

    }

    /**
     * Gets the quantity value for displaying purpose.
     *
     * @return double
     */
    public function getQuantityForDisplay() {
        return Vushop_Utils::formatQuantity($this->getQuantity());
    }

    /**
     * Getter for $quantity.
     *
     * @return double
     */
    public function getQuantity() {
        return $this->quantity;
    }

    /**
     * Setter for $quantity.
     *
     * @param double $quantity
     */
    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    /**
     * @see Vushop_Bo_Catalog_BoItem::getPriceForDisplay()
     */
    public function getPriceForDisplay() {
        return parent::getPriceForDisplay();
    }

    /**
     * Getter for $price.
     *
     * @return double
     */
    public function getPrice() {
        return parent::getPrice();
    }

    /**
     * Setter for $price.
     *
     * @param double $price
     */
    public function setPrice($price) {
        parent::setPrice($price);
    }

    /**
     * Gets total value (= price * quantity)
     *
     * @return double
     */
    public function getTotal() {
        return $this->getPrice() * $this->getQuantity();
    }

    /**
     * Gets total value (= price * quantity) for displaying purpose.
     *
     * @return double
     */
    public function getTotalForDisplay() {
        return Vushop_Utils::formatPrice($this->getTotal());
    }
	/**
	 * @return the $shop
	 */
	public function getShop() {
		return parent::getShop();
	}

	/**
	 * @param field_type $shop
	 */
	public function setShop($shop) {
		 parent::setShop($shop);
	}

    
    
}