<?php
class Vushop_Bo_Cart_BoCart extends Quack_Bo_BaseBo {

    /* Database table columns */
    const COL_SESSION_ID = 'sessionId';
    const COL_STATUS = 'cartStatus';
    const COL_UPDATE_TIMESTAMP = 'updateTimestamp';
    const COL_USER_ID = 'userId';

    private $sessionId, $status, $updateTimestamp, $userId;
    private $cartItems = Array();

    private $urlView = NULL;
    private $urlCheckout = NULL;

    /**
     * @see Quack_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_SESSION_ID => Array('sessionId'),
                self::COL_STATUS => Array('status', self::TYPE_INT),
                self::COL_UPDATE_TIMESTAMP => Array('updateTimestamp', self::TYPE_INT),
                self::COL_USER_ID => Array('userId', self::TYPE_INT));
    }

    /**
     * Gets the URL to checkout the cart.
     *
     * @return string
     */
    public function getUrlCheckout() {
        if ($this->urlCheckout === NULL) {
            $this->urlCheckout = $_SERVER['SCRIPT_NAME'] . '/checkout';
        }
        return $this->urlCheckout;
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
     * Gets number of items currently in the cart.
     *
     * @return int
     */
    public function getNumItems() {
        return count($this->cartItems);
    }

    /**
     * Gets total number of items currently in the cart.
     *
     * @return int
     */
    public function getTotalItems() {
        $result = 0;
        foreach ($this->cartItems as $item) {
            $result += $item->getQuantity();
        }
        return $result;
    }

    /**
     * Gets total price of items currently in the cart.
     *
     * @return int
     */
    public function getTotalPrice() {
        $result = 0;
        foreach ($this->cartItems as $item) {
            $result += $item->getTotal();
        }
        return $result;
    }

    /**
     * Gets total price of items currently in the cart (for displaying purpose).
     *
     * @return string
     */
    public function getTotalPriceForDisplay() {
        return Vushop_Utils::formatPrice($this->getTotalPrice());
    }

    /**
     * Gets an item in the cart
     *
     * @param mixed $item
     * @return Vushop_Bo_Cart_BoCartItem
     */
    public function getItem($item) {
        if ($item instanceof Vushop_Bo_Catalog_BoItem) {
            $id = $item->getId();
            return isset($this->cartItems[$id]) ? $this->cartItems[$id] : NULL;
        }
        if ($item instanceof Vushop_Bo_Cart_BoCartItem) {
            $id = $item->getItemId();
            return isset($this->cartItems[$id]) ? $this->cartItems[$id] : NULL;
        }
        return isset($this->cartItems[$item]) ? $this->cartItems[$item] : NULL;
    }

    /**
     * Adds an item to cart.
     *
     * @param Vushop_Bo_Catalog_BoItem $item
     * @param double $quantity
     */
    public function addItem($item, $quantity = 1) {
        if ($item instanceof Vushop_Bo_Cart_BoCartItem) {
            $this->cartItems[$item->getItemId()] = $item;
        } else {
            //assuming $item is of type Vushop_Bo_Catalog_BoItem
            $itemId = $item->getId();
            if (!isset($this->cartItems[$itemId])) {
                $this->cartItems[$itemId] = new Vushop_Bo_Cart_BoCartItem();
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
        if ($item instanceof Vushop_Bo_Catalog_BoItem) {
            return isset($this->cartItems[$item->getId()]);
        }
        if ($item instanceof Vushop_Bo_Cart_BoCartItem) {
            return isset($this->cartItems[$item->getItemId()]);
        }
        return isset($this->cartItems[$item]);
    }

    /**
     * Checks if the cart is empty.
     *
     * @return boolean
     */
    public function isEmpty() {
        return count($this->cartItems) == 0;
    }

    /**
     * Gets the grand total value of the cart (=sum of all items' price * quantity)
     *
     * @return double
     */
    public function getGrandTotal() {
        $result = 0;
        foreach ($this->cartItems as $item) {
            $result += $item->getTotal();
        }
        return $result;
    }

    /**
     * Gets the grand total value of the cart (=sum of all items' price * quantity) for displaying purpose.
     *
     * @return double
     */
    public function getGrandTotalForDisplay() {
        return Vushop_Utils::formatPrice($this->getGrandTotal());
    }
}
