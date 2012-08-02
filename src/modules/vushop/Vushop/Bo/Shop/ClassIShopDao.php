<?php
interface Vushop_Bo_Shop_IShopDao extends Ddth_Dao_IDao {

    /**
     * Gets all shops.
     *
     * @return Array
     */
    public function getShops($pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE);
    
    
     /**
     * Gets count all shops.
     *
     * @return Array
     */
     public function getCountNumShops();
    
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
