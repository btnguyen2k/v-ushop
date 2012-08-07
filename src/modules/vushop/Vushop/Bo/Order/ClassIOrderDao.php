<?php
interface Vushop_Bo_Order_IOrderDao extends Ddth_Dao_IDao {
    
    /**
     * Creates a new order.
     *
     * @param Vushop_Bo_Order_BoOrder $order
     */
    public function createOrder($order);
    
    /**
     * Updates a order.
     *
     * @param Vushop_Bo_Order_BoOrder $order
     */
    public function updateOrder($order);
    
    /**
     * Gets a order by id.
     *
     * @param int $id
     * @return Vushop_Bo_Order_Boorder
     */
    public function getOrderById($id);
    
    /**
     * Creates a new order detail.
     *
     * @param Vushop_Bo_Order_BoOrderDetail $orderDetail
     */
    public function createOrderDetail($orderDetail);
    
    /**
     * Deletes an existing items.
     *
     * @param Vushop_Bo_Order_BoOrderDetail $orderDetail
     */
    public function updateOrderDetail($orderDetail);
    
    /**
     * Gets an order detail by id.
     *
     * @param int $id
     * @return Vushop_Bo_Order_BoOrderDetail
     */
    public function getOrderDetailByOrderIdAndItemId($orderId, $itemId);
    
    /**
     * Counts number of current order for shop.
     *
     *@param Vushop_Bo_Order_BoShop $shop
     * @param mixed $featuredOrdersOnly
     * @return Array
     */
    public function getAllOrdersForShop($shop, $pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE, $orderSorting = DEFAULT_ORDER_SORTING, $featuredOrders = FEATURED_ORDER_ALL);
    
    /**
     * Counts number of current order for shop.
     *
     *@param Vushop_Bo_Order_BoShop $shop
     * @param mixed $featuredOrdersOnly
     * @return int
     */
    public function countNumOrdersForShop($shop, $featuredOrders = FEATURED_ORDER_ALL);
    
    /**
     * Gets all orders detail within a order as a list.
     *
     * @param Vushop_Bo_Order_BoOrder $order
     * @param Vushop_Bo_Shop_BoShop $shop
     * 
     * @return array
     */
    public function getOrderDetailForOrderShop($order, $shop);

}
