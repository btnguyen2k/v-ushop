<?php
interface Vushop_Bo_Shop_IShopDao extends Ddth_Dao_IDao {

    /**
     * Gets all shops.
     *
     * @return Array
     */
    public function getShops();
    
    /**
     * Gets a shop by id.
     *
     * @param int $ownerId
     * @return Vushop_Bo_Shop_BoShop
     */
    public function getShopById($ownerId);

    /**
     * Creates a new shop.
     *
     * @param Vushop_Bo_Shop_BoShop $shop
     */
    public function createShop($shop);

    /**
     * Updates an existing shop.
     *
     * @param Vushop_Bo_Shop_BoShop $shop
     */
    public function updateShop($shop);
}
