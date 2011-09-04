<?php
abstract class Vcatalog_Bo_Cart_BaseCartDao extends Commons_Bo_BaseDao implements
        Vcatalog_Bo_Cart_ICartDao {

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
        $sqlConn = $this->getConnection();

        $params = Array('sessionId' => $sessionId, 'userId' => (int)$userId);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $this->closeConnection();

        return $this->getCart($sessionId);
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::getCart()
     */
    public function getCart($sessionId) {
        $cacheKey = self::CACHE_KEY_PREFIX . $sessionId;
        $cart = $this->getFromCache($cacheKey);
        if ($cart === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $params = Array('sessionId' => $sessionId);
            $rs = $sqlStm->execute($sqlConn->getConn(), $params);
            $row = $this->fetchResultAssoc($rs);
            if ($row !== NULL && $row !== FALSE) {
                $cart = new Vcatalog_Bo_Cart_BoCart();
                $cart->populate($row);
            } else {
                $cart = NULL;
            }

            $this->closeConnection();
            if ($cart !== NULL) {
                $items = $this->getItemsInCart($cart);
                foreach ($items as $item) {
                    $cart->addItem($item);
                }
                $this->putToCache($cacheKey, $cart);
            }
        }
        return $cart;
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::getItemsInCart()
     */
    public function getItemsInCart($cart) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $result = Array();
        $params = Array('sessionId' => $cart->getSessionId());
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $cartItem = new Vcatalog_Bo_Cart_BoCartItem();
            $cartItem->populate($row);
            $result[] = $cartItem;
            $row = $this->fetchResultAssoc($rs);
        }

        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::createCartItem()
     */
    public function createCartItem($cart, $itemId, $quantity, $price) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('sessionId' => $cart->getSessionId(),
                'itemId' => $itemId,
                'quantity' => $quantity,
                'price' => $price);
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
        $this->invalidateCache($cart->getSessionId());
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::deleteCartItem()
     */
    public function deleteCartItem($cartItem) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('sessionId' => $cartItem->getSessionId(),
                'itemId' => $cartItem->getItemId());
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
        $this->invalidateCache($cartItem->getSessionId());
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::updateCartItem()
     */
    public function updateCartItem($cartItem) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('sessionId' => $cartItem->getSessionId(),
                'itemId' => $cartItem->getItemId(),
                'quantity' => $cartItem->getQuantity(),
                'price' => $cartItem->getPrice());
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
        $this->invalidateCache($cartItem->getSessionId());
    }
}
