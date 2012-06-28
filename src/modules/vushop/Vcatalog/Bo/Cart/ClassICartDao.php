<?php
interface Vcatalog_Bo_Cart_ICartDao extends Ddth_Dao_IDao {

    /**
     * Creates cart if not exists
     *
     * @param string $sessionId
     * @param int $userId
     * @return Vcatalog_Bo_Cart_BoCart the newly created cart
     */
    public function createCart($sessionId, $userId = 0);

    /**
     * Gets a cart information.
     *
     * @param Vcatalog_Bo_Cart_BoCart $sessionId
     */
    public function getCart($sessionId);

    /**
     * Gets all items in the cart as a list.
     *
     * @param Vcatalog_Bo_Cart_BoCart $cart
     * @return Aray()
     */
    public function getItemsInCart($cart);

    /**
     * Creates a new cart item (a.k.a put a new item into the cart).
     *
     * @param Vcatalog_Cart_BoCart $cart
     * @param int $itemId
     * @param double $quantity
     * @param double $price
     */
    public function createCartItem($cart, $itemId, $quantity, $price);

    /**
     * Deletes an existing cart items (a.k.a. remove an item from the cartA).
     *
     * @param Vcatalog_Cart_BoCartItem $cartItem
     */
    public function deleteCartItem($cartItem);

    /**
     * Updates an existing cart item.
     *
     * @param Vcatalog_Cart_BoCartItem $cartItem
     */
    public function updateCartItem($cartItem);
}
