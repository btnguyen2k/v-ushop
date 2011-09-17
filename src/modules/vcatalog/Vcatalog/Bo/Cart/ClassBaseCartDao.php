<?php
abstract class Vcatalog_Bo_Cart_BaseCartDao extends Quack_Bo_BaseDao implements
        Vcatalog_Bo_Cart_ICartDao {

    /* Virtual columns */
    const COL_ITEM_ID = 'itemId';
    const COL_SESSION_ID = 'sessionId';
    const COL_USER_ID = 'userId';
    const COL_QUANTITY = 'quantity';
    const COL_PRICE = 'price';

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    const CACHE_KEY_PREFIX = 'CART_';

    /**
     * Invalidates the cache due to change.
     *
     * @param string $sessionId
     */
    protected function invalidateCache($sessionId) {
        $cacheKey = self::CACHE_KEY_PREFIX . $sessionId;
        $this->deleteFromCache($cacheKey);
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::createCart()
     */
    public function createCart($sessionId, $userId = 0) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $sessionId, self::COL_USER_ID => (int)$userId);
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::getCart()
     */
    public function getCart($sessionId) {
        $cacheKey = self::CACHE_KEY_PREFIX . $sessionId;
        $cart = $this->getFromCache($cacheKey);
        //pre-open a connection so that subsequence operations will reuse it
        $conn = $this->getConnection();
        if ($cart === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(self::COL_SESSION_ID => $sessionId);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $cart = new Vcatalog_Bo_Cart_BoCart();
                $cart->populate($rows[0]);
            } else {
                $cart = NULL;
            }
            if ($cart !== NULL) {
                $items = $this->getItemsInCart($cart);
                foreach ($items as $item) {
                    $cart->addItem($item);
                }
                $this->putToCache($cacheKey, $cart);
            }
        }
        $this->closeConnection();
        return $cart;
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::getItemsInCart()
     */
    public function getItemsInCart($cart) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        $params = Array(self::COL_SESSION_ID => $cart->getSessionId());
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $cartItem = new Vcatalog_Bo_Cart_BoCartItem();
                $cartItem->populate($row);
                $result[] = $cartItem;
            }
        }
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::createCartItem()
     */
    public function createCartItem($cart, $itemId, $quantity, $price) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $cart->getSessionId(),
                self::COL_ITEM_ID => $itemId,
                self::COL_QUANTITY => $quantity,
                self::COL_PRICE => $price);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($cart->getSessionId());
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::deleteCartItem()
     */
    public function deleteCartItem($cartItem) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $cartItem->getSessionId(),
                self::COL_ITEM_ID => $cartItem->getItemId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($cartItem->getSessionId());
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::updateCartItem()
     */
    public function updateCartItem($cartItem) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_SESSION_ID => $cartItem->getSessionId(),
                self::COL_ITEM_ID => $cartItem->getItemId(),
                self::COL_QUANTITY => $cartItem->getQuantity(),
                self::COL_PRICE => $cartItem->getPrice());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($cartItem->getSessionId());
        return $result;
    }
}
