<?php
class Vcatalog_Bo_Cart_BoCart extends Commons_Bo_BaseBo {

    const COL_SESSION_ID = 'csession_id';
    const COL_STATUS = 'cstatus';
    const COL_UPDATE_TIMESTAMP = 'cupdate_timestamp';
    const COL_USER_ID = 'cuser_id';

    private $sessionId, $status, $updateTimestamp, $userId;
    private $cartItems = Array();

    private $urlView = NULL;

    /**
     * @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_SESSION_ID => Array('sessionId'),
                self::COL_STATUS => Array('status', self::TYPE_INT),
                self::COL_UPDATE_TIMESTAMP => Array('updateTimestamp', self::TYPE_INT),
                self::COL_USER_ID => Array('userId', self::TYPE_INT));
    }

    /**
     * Gets the URL to view the cart.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
            $this->urlView = $_SERVER['SCRIPT_NAME'] . '/cart';
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
     * Getter for $status.
     *
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Setter for $status.
     *
     * @param int $status
     */
    public function setStatus($status) {
        $this->status = $status;
    }

    /**
     * Getter for $updateTimestamp.
     *
     * @return int
     */
    public function getUpdateTimestamp() {
        return $this->updateTimestamp;
    }

    /**
     * Setter for $updateTimestamp.
     *
     * @param int $updateTimestamp
     */
    public function setUpdateTimestamp($updateTimestamp) {
        $this->updateTimestamp = $updateTimestamp;
    }

    /**
     * Getter for $userId.
     *
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * Setter for $userId.
     *
     * @param int $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * Gets all items currently in the cart.
     *
     * @return Array()
     */
    public function getItems() {
        return $this->cartItems;
    }

    /**
     * Gets an item in the cart
     *
     * @param mixed $item
     * @return Vcatalog_Bo_Cart_BoCartItem
     */
    public function getItem($item) {
        if ($item instanceof Vcatalog_Bo_Catalog_BoItem) {
            $id = $item->getId();
            return isset($this->cartItems[$id]) ? $this->cartItems[$id] : NULL;
        }
        if ($item instanceof Vcatalog_Bo_Cart_BoCartItem) {
            $id = $item->getItemId();
            return isset($this->cartItems[$id]) ? $this->cartItems[$id] : NULL;
        }
        return isset($this->cartItems[$item]) ? $this->cartItems[$item] : NULL;
    }

    /**
     * Adds an item to cart.
     *
     * @param Vcatalog_Bo_Catalog_BoItem $item
     * @param double $quantity
     */
    public function addItem($item, $quantity = 1) {
        if ($item instanceof Vcatalog_Bo_Cart_BoCartItem) {
            $this->cartItems[$item->getItemId()] = $item;
        } else {
            //assuming $item is of type Vcatalog_Bo_Catalog_BoItem
            $itemId = $item->getId();
            if (!isset($this->cartItems[$itemId])) {
                $this->cartItems[$itemId] = new Vcatalog_Bo_Cart_BoCartItem();
                $this->cartItems[$itemId]->setPrice($item->getPrice());
            }
            $this->cartItems[$itemId]->addQuantity($quantity);
        }
    }

    /**
     * Checks if an item exists in cart.
     *
     * @param mixed $item
     */
    public function existInCart($item) {
        if ($item instanceof Vcatalog_Bo_Catalog_BoItem) {
            return isset($this->cartItems[$item->getId()]);
        }
        if ($item instanceof Vcatalog_Bo_Cart_BoCartItem) {
            return isset($this->cartItems[$item->getItemId()]);
        }
        return isset($this->cartItems[$item]);
    }
}
