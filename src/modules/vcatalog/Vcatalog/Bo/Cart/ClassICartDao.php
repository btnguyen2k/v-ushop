<?php
interface Vcatalog_Bo_Cart_ICartDao extends Ddth_Dao_IDao {
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
}