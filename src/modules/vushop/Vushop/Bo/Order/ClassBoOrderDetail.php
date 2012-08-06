<?php
class Vushop_Bo_Order_BoOrderDetail extends Quack_Bo_BaseBo {
    
    /* Database table columns */
    const COL_ORDER_ID = 'order_id';
    const COL_ITEM_ID = 'order_detail_item_id';
    const COL_QUANTITY = 'order_detail_quantity';
    const COL_PRICE = 'order_detail_price';
    const COL_STATUS = 'order_detail_status';
    const COL_TIMESTAMP = 'order_detail_timestamp';
    
    private $orderId, $itemId, $quantity, $price, $status, $timestamp, $item;
    
    /**
     * @see Quack_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ORDER_ID => Array('order_id'), 
                self::COL_TIMESTAMP => Array('timestamp', self::TYPE_INT), 
                self::COL_ITEM_ID => Array('itemId', self::TYPE_INT), 
                self::COL_QUANTITY => Array('quantity',self::TYPE_DOUBLE), 
                self::COL_PRICE => Array('price',self::TYPE_DOUBLE), 
                self::COL_STATUS => Array('status', self::TYPE_BOOLEAN));
    }
	/**
	 * @return the $orderId
	 */
	public function getOrderId() {
		return $this->orderId;
	}

	/**
	 * @return the $itemId
	 */
	public function getItemId() {
		return $this->itemId;
	}

	/**
	 * @return the $quantity
	 */
	public function getQuantity() {
		return $this->quantity;
	}

	/**
	 * @return the $price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * @return the $status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return the $timestamp
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}

	/**
	 * @return the $item
	 */
	public function getItem() {
		return $this->item;
	}

	/**
	 * @param field_type $orderId
	 */
	public function setOrderId($orderId) {
		$this->orderId = $orderId;
	}

	/**
	 * @param field_type $itemId
	 */
	public function setItemId($itemId) {
		$this->itemId = $itemId;
	}

	/**
	 * @param field_type $quantity
	 */
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}

	/**
	 * @param field_type $price
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * @param field_type $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @param field_type $timestamp
	 */
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
	}

	/**
	 * @param field_type $item
	 */
	public function setItem($item) {
		$this->item = $item;
	}

    
   
}