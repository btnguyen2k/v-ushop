<?php
class Vcatalog_Bo_Cart_BoCartItem extends Vcatalog_Bo_Catalog_BoItem {

    const COL_SESSION_ID = 'csession_id';
    const COL_ITEM_ID = 'citem_id';
    const COL_QUANTITY = 'cquantity';
    const COL_PRICE = 'cprice';

    private $sessionId, $itemId, $quantity, $price;

    private $urlView = NULL;

    /**
     * @see Commons_Bo_BaseBo::getFieldMap()
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
     * Getter for $price.
     *
     * @return double
     */
    public function getPrice() {
        return $this->price;
    }

    /**
     * Setter for $price.
     *
     * @param double $price
     */
    public function setPrice($price) {
        $this->price = $price;
    }
}