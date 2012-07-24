<?php
abstract class Vushop_Bo_Cart_BaseCartDao extends Quack_Bo_BaseDao implements
        Vushop_Bo_Cart_ICartDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_BaseDao::getCacheName()
     */
    public function getCacheName() {
        return 'ICartDao';
    }

    protected function createCacheKeyCart($sessionId) {
        return 'CART_' . $sessionId;
    }

    /**
     * Invalidates the cache due to change.
     *
     * @param string $sessionId
     */
    protected function invalidateCache($sessionId) {
        $cacheKey = $this->createCacheKeyCart($sessionId);
        $this->deleteFromCache($cacheKey);
    }

    /**
     * @see Vushop_Bo_Cart_ICartDao::createCart()
     */
    public function createCart($sessionId, $userId = 0) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Cart_BoCart::COL_SESSION_ID => $sessionId,
                Vushop_Bo_Cart_BoCart::COL_USER_ID => (int)$userId);
        $this->execNonSelect($sqlStm, $params);
        $result = $this->getCart($sessionId);
        return $result;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_Cart_ICartDao::cleanup()
     */
    public function cleanup() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = $this->execNonSelect($sqlStm);
        $this->invalidateCache();
        return $result;
    }

    /**
     * @see Vushop_Bo_Cart_ICartDao::getCart()
     */
    public function getCart($sessionId) {
        $cacheKey = $this->createCacheKeyCart($sessionId);
        $cart = $this->getFromCache($cacheKey);
        if ($cart === NULL) {
            //pre-open a connection so that subsequence operations will reuse it
            $conn = $this->getConnection();
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_Cart_BoCart::COL_SESSION_ID => $sessionId);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $cart = new Vushop_Bo_Cart_BoCart();
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
            $this->closeConnection();
        }

        return $cart;
    }

    /**
     * @see Vushop_Bo_Cart_ICartDao::getItemsInCart()
     */
    public function getItemsInCart($cart) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $result = Array();
        $params = Array(Vushop_Bo_Cart_BoCart::COL_SESSION_ID => $cart->getSessionId());
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $cartItem = new Vushop_Bo_Cart_BoCartItem();
                $cartItem->populate($row);
                $result[] = $cartItem;
            }
        }
        return $result;
    }

    /**
     * @see Vushop_Bo_Cart_ICartDao::createCartItem()
     */
    public function createCartItem($cart, $itemId, $quantity, $price) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Cart_BoCartItem::COL_SESSION_ID => $cart->getSessionId(),
                Vushop_Bo_Cart_BoCartItem::COL_ITEM_ID => $itemId,
                Vushop_Bo_Cart_BoCartItem::COL_QUANTITY => $quantity,
                Vushop_Bo_Cart_BoCartItem::COL_PRICE => $price);
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($cart->getSessionId());
        return $result;
    }

    /**
     * @see Vushop_Bo_Cart_ICartDao::deleteCartItem()
     */
    public function deleteCartItem($cartItem) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Cart_BoCartItem::COL_SESSION_ID => $cartItem->getSessionId(),
                Vushop_Bo_Cart_BoCartItem::COL_ITEM_ID => $cartItem->getItemId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($cartItem->getSessionId());
        return $result;
    }

    /**
     * @see Vushop_Bo_Cart_ICartDao::updateCartItem()
     */
    public function updateCartItem($cartItem) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Cart_BoCartItem::COL_SESSION_ID => $cartItem->getSessionId(),
                Vushop_Bo_Cart_BoCartItem::COL_ITEM_ID => $cartItem->getItemId(),
                Vushop_Bo_Cart_BoCartItem::COL_QUANTITY => $cartItem->getQuantity(),
                Vushop_Bo_Cart_BoCartItem::COL_PRICE => $cartItem->getPrice());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($cartItem->getSessionId());
        return $result;
    }
}
