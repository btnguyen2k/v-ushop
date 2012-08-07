<?php
abstract class Vushop_Bo_Order_BaseOrderDao extends Quack_Bo_BaseDao implements 
        Vushop_Bo_Order_IOrderDao {
    
    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;
    
    const PARAM_SORTING_FIELD = 'sortingField';
    const PARAM_SORTING = 'sorting';
    const PARAM_ORDER_ID = 'order_id';
    const PARAM_SHOP_ID = 'shop_id';
    const PARAM_START_OFFSET = 'startOffset';
    const PARAM_PAGE_SIZE = 'pageSize';
    
    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see Quack_Bo_BaseDao::getCacheName()
     */
    public function getCacheName() {
        return 'IOrderDao';
    }
    
    /**
     *
     * @see Vushop_Bo_Order_IOrderDao::countNumOrders()
     */
    public function createOrder($order) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Order_BoOrder::COL_ID => $order->getId(), 
                Vushop_Bo_Order_BoOrder::COL_TIMESTAMP => $order->getTimeStamp(), 
                Vushop_Bo_Order_BoOrder::COL_FULL_NAME => $order->getFullName(), 
                Vushop_Bo_Order_BoOrder::COL_EMAIL => $order->getEmail(), 
                Vushop_Bo_Order_BoOrder::COL_PHONE => $order->getPhone(), 
                Vushop_Bo_Order_BoOrder::COL_PAYMENT_METHOD => $order->getPaymentMethod(), 
                Vushop_Bo_Order_BoOrder::COL_ADDRESS => $order->getAddress());
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Order_IOrderDao::updateOrder()
     */
    public function updateOrder($order) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Order_BoOrder::COL_ID => $order->getId(), 
                Vushop_Bo_Order_BoOrder::COL_TIMESTAMP => $order->getTimeStamp(), 
                Vushop_Bo_Order_BoOrder::COL_FULL_NAME => $order->getFullName(), 
                Vushop_Bo_Order_BoOrder::COL_EMAIL => $order->getEmail(), 
                Vushop_Bo_Order_BoOrder::COL_PHONE => $order->getPhone(), 
                Vushop_Bo_Order_BoOrder::COL_PAYMENT_METHOD => $order->getPaymentMethod(), 
                Vushop_Bo_Order_BoOrder::COL_ADDRESS => $order->getAddress());
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    }
    
    /**
     *
     * @see Vushop_Bo_Order_IOrderDao::getOrderById()
     */
    public function getOrderById($id) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Order_BoOrder::COL_ID => $id);
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            $result = new Vushop_Bo_Order_BoOrder();
            $result->populate($rows[0]);
        }
        return $result;
    }
    
    /**
     * @see Vushop_Bo_Order_IOrderDao::createOrderDetail()
     */
    public function createOrderDetail($orderDetail) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Order_BoOrderDetail::COL_ORDER_ID => $orderDetail->getOrderId(), 
                Vushop_Bo_Order_BoOrderDetail::COL_TIMESTAMP => $orderDetail->getTimeStamp(), 
                Vushop_Bo_Order_BoOrderDetail::COL_ITEM_ID => $orderDetail->getItemId(), 
                Vushop_Bo_Order_BoOrderDetail::COL_PRICE => $orderDetail->getPrice(), 
                Vushop_Bo_Order_BoOrderDetail::COL_QUANTITY => $orderDetail->getQuantity(), 
                Vushop_Bo_Order_BoOrderDetail::COL_STATUS => $orderDetail->getStatus());
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    
    }
    
    /**
     * @see Vushop_Bo_Order_IOrderDao::updateOrderDetail()
     */
    public function updateOrderDetail($orderDetail) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Order_BoOrderDetail::COL_ORDER_ID => $orderDetail->getOrderId(), 
                Vushop_Bo_Order_BoOrderDetail::COL_TIMESTAMP => $orderDetail->getTimeStamp(), 
                Vushop_Bo_Order_BoOrderDetail::COL_ITEM_ID => $orderDetail->getItemId(), 
                Vushop_Bo_Order_BoOrderDetail::COL_PRICE => $orderDetail->getPrice(), 
                Vushop_Bo_Order_BoOrderDetail::COL_QUANTITY => $orderDetail->getQuantity(), 
                Vushop_Bo_Order_BoOrderDetail::COL_STATUS => $orderDetail->getStatus());
        $result = $this->execNonSelect($sqlStm, $params);
        return $result;
    
    }
    
        /**
     * @see Vushop_Bo_Order_IOrderDao::getOrderDetailById()
     */
    public function getOrderDetailByOrderIdAndItemId($orderId, $itemId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_Order_BoOrderDetail::COL_ORDER_ID => $orderId, 
                Vushop_Bo_Order_BoOrderDetail::COL_ITEM_ID => $itemId);
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            $result = new Vushop_Bo_Order_BoOrderDetail();
            $result->populate($rows[0]);
        }
        if ($result !== NULL) {
            $itemDao = $this->getDaoFactory()->getDao(DAO_CATALOG);
            $item = $itemDao->getItemById($result->getItemId());
            $result->setItem($item);
        
        }
        return $result;
    
    }
    
    
         /**
     * @see Vushop_Bo_Order_IOrderDao::getAllOrdersForShop()
     */
    public function getAllOrdersForShop($shop, $pageNum = 1, $pageSize = DEFAULT_PAGE_SIZE, $orderSorting = DEFAULT_ORDER_SORTING, $featuredOrders = FEATURED_ORDER_ALL) {
        if ($shop === NULL) {
            return Array();
        }
        switch ($featuredOrders) {
            case FEATURED_ORDER_COMPLETED:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredCompleted');
                break;
            case FEATURED_ORDER_NOT_COMPLETE:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredNotComplete');
                break;
            default:
                $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        }
        $params = Array(self::PARAM_START_OFFSET => ($pageNum - 1) * $pageSize, 
                self::PARAM_PAGE_SIZE => $pageSize, 
                self::PARAM_SHOP_ID => $shop->getOwnerId());
        switch ($orderSorting) {
            case ORDER_SORTING_TIMEASC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs('otimestamp');
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('ASC');
                break;
            case ORDER_SORTING_TIMEDESC:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs('otimestamp');
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
                break;
            default:
                $params[self::PARAM_SORTING_FIELD] = new Ddth_Dao_ParamAsIs('otimestamp');
                $params[self::PARAM_SORTING] = new Ddth_Dao_ParamAsIs('DESC');
        }
        $result = Array();
        
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $orderId = $row[Vushop_Bo_Order_BoOrder::COL_ID];
                $order = $this->getOrderById($orderId);
                $result[] = $order;
            }
        }
        return $result;
    
    }
    
    /**
     *
     * @see Vushop_Bo_Order_IOrderDao::getOrderDetailForOrder()
     */
    public function getOrderDetailForOrderShop($order, $shop) {
        $result = Array();
        if ($order !== NULL) {
            $orderId = $order->getId();
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $result = Array();
            $params = Array(self::PARAM_ORDER_ID => $order->getId(), 
                    self::PARAM_SHOP_ID => $shop->getOwnerId());
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                foreach ($rows as $row) {
                    $orderId = $row[Vushop_Bo_Order_BoOrderDetail::COL_ORDER_ID];
                    $itemId = $row[Vushop_Bo_Order_BoOrderDetail::COL_ITEM_ID];
                    $orderDetail = $this->getOrderDetailByOrderIdAndItemId($orderId, $itemId);
                    $result[] = $orderDetail;
                }
            }
        }
        return $result;
    }
    
    
    
    /** 
     * @see Vushop_Bo_Order_IOrderDao::countNumOrdersForShop()
     */
    public function countNumOrdersForShop($shop, $featuredOrders = FEATURED_ORDER_ALL) {
        $result = 0;
        if ($shop != null) {
            $params = Array(self::PARAM_SHOP_ID => $shop->getOwnerId());
            switch ($featuredOrders) {
                case FEATURED_ORDER_COMPLETED:
                    $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredCompleted');
                    break;
                case FEATURED_ORDER_NOT_COMPLETE:
                    $sqlStm = $this->getStatement('sql.' . __FUNCTION__ . '.featuredNotComplete');
                    break;
                default:
                    $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            }
            $result = $this->execCount($sqlStm, $params);
        }
        return $result;
    
    }
    
   

}
