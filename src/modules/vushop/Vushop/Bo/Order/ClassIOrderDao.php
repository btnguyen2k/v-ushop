<?php
interface Vushop_Bo_Order_IOrderDao extends Ddth_Dao_IDao {

    /**
     * Creates a new order.
     *
     * @param Vushop_Bo_Catalog_BoOrder $order
     */
    public function createOrder($order);

    /**
     * Gets a order by id.
     *
     * @param int $id
     * @return Vushop_Bo_Catalog_Boorder
     */
    public function getOrderById($id);
    

    /**
     * Updates a order.
     *
     * @param Vushop_Bo_Catalog_BoOrder $order
     */
    public function updateOrder($order);

    /**
     * Counts number of current order for shop.
     *
     * @param mixed $featuredIOrdersOnly
     * @return int
     */
    public function countNumOrders($featuredOrders = FEATURED_ORDER_ALL);
    
    /**
     * Counts number of current order for shop.
     *
     *@param Vushop_Bo_Catalog_BoShop $shop
     * @param mixed $featuredOrdersOnly
     * @return int
     */
    public function countNumOrdersForShop($shop, $featuredOrders = FEATURED_ORDER_ALL);
    
  
    /**
     * Counts number of current order for shop.
     *
     * @param mixed $featuredOrdersOnly
     * @return Array
     */
    public function getAllOrders($pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE, $orderSorting = DEFAULT_ORDER_SORTING,$featuredOrders = FEATURED_ORDER_ALL);
    
    
     /**
     * Counts number of current order for shop.
     *
     *@param Vushop_Bo_Catalog_BoShop $shop
     * @param mixed $featuredOrdersOnly
     * @return Array
     */
    public function getAllOrdersForShop($shop, $pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE, $orderSorting = DEFAULT_ORDER_SORTING, $featuredOrders = FEATURED_ORDER_ALL);

    /**
     * Creates a new order detail.
     *
     * @param Vushop_Bo_Catalog_BoOrderDetail $orderDetail
     */
    public function createOrderDetail($orderDetail);

    /**
     * Deletes an existing items.
     *
     * @param Vushop_Bo_Catalog_BoOrderDetail $orderDetail
     */
    public function updateOrderDetail($orderDetail);

    
    /**
     * Gets an order detail by id.
     *
     * @param int $id
     * @return Vushop_Bo_Catalog_BoOrderDetail
     */
    public function getOrderDetailByOrderIdAndItemId($orderId,$itemId);

    /**
     * Gets all orders detail within a order as a list.
     *
     * @param Vushop_Bo_Catalog_BoOrder $order
     * 
     * @return array
     */
    public function getOrderDetailForOrder($order);
    
    
    
}
