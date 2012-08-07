<?php
class Vushop_Bo_Order_BoOrder extends Quack_Bo_BaseBo {
    
    /* Database table columns */
    const COL_ID = 'order_id';
    const COL_TIMESTAMP = 'order_timestamp';
    const COL_FULL_NAME = 'order_full_name';
    const COL_EMAIL = 'order_email';
    const COL_PHONE = 'order_phone';
    const COL_PAYMENT_METHOD = 'order_payment_method';
    const COL_ADDRESS = 'order_address';
    
    private $id, $timestamp, $fullName, $email, $phone, $paymentMethod, $address;
    private $orderDetail = Array();
    private $ordersDetailForOrder = Array();
    private $urlView = NULL;
    
    /**
     * @see Quack_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ID => Array('id'), 
                self::COL_TIMESTAMP => Array('timestamp', self::TYPE_INT), 
                self::COL_FULL_NAME => Array('fullName'), 
                self::COL_EMAIL => Array('email'), 
                self::COL_PHONE => Array('phone'), 
                self::COL_PAYMENT_METHOD => Array('paymentMethod', self::TYPE_BOOLEAN), 
                self::COL_ADDRESS => Array('address'));
    }
    
    /**
     * Gets the URL to view the category.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
            $this->urlView = $_SERVER['SCRIPT_NAME'] . '/order/' . $this->id . '/';
        }
        return $this->urlView;
    }
    
    /**
     * @return the $id
     * @return string
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @return the $timestamp
     * @return DateTime
     */
    public function getTimestamp() {
        return $this->timestamp;
    }
    
    /**
     * @return the $fullName
     * @return string
     */
    public function getFullName() {
        return $this->fullName;
    }
    
    /**
     * @return the $email
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }
    
    /**
     * @return the $phone
     * @return string
     */
    public function getPhone() {
        return $this->phone;
    }
    
    /**
     * @return the $paymentMethod
     * @return boolean (true:cash, false:transfer)
     */
    public function getPaymentMethod() {
        return $this->paymentMethod;
    }
    
    /**
     * @return the $address
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }
    
    /**
     * @return the $orderDetail
     * @return Object Vushop_Bo_Cart_BoOrderDetail
     */
    public function getOrderDetail() {
        return $this->orderDetail;
    }
    
    /**
     * @return the $ordersDetailForOrder
     * @return Array Vushop_Bo_Cart_BoOrderDetail
     */
    public function getOrdersDetailForOrder() {
        return $this->ordersDetailForOrder;
    }
    
    /**
     * @param field_type $id type string
     */
    public function setId($id) {
        $this->id = $id;
    }
    
    /**
     * @param field_type $timestamp type datetime
     */
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
    
    /**
     * @param field_type $fullName type string
     */
    public function setFullName($fullName) {
        $this->fullName = $fullName;
    }
    
    /**
     * @param field_type $email type string
     */
    public function setEmail($email) {
        $this->email = $email;
    }
    
    /**
     * @param field_type $phone type string
     */
    public function setPhone($phone) {
        $this->phone = $phone;
    }
    
    /**
     * @param field_type $paymentMethod type boolean
     */
    public function setPaymentMethod($paymentMethod) {
        $this->paymentMethod = $paymentMethod;
    }
    
    /**
     * @param field_type $address type string
     */
    public function setAddress($address) {
        $this->address = $address;
    }
    
    /**
     * @param field_type $orderDetail type Object Vushop_Bo_Cart_BoOrderDetail
     * 
     */
    public function setOrderDetail($orderDetail) {
        $this->orderDetail = $orderDetail;
    }
    
    /**
     * @param field_type $ordersDetailForOrder type Array Vushop_Bo_Cart_BoOrderDetail
     */
    public function setOrdersDetailForOrder($ordersDetailForOrder) {
        $this->ordersDetailForOrder = $ordersDetailForOrder;
        if (!is_array($this->ordersDetailForOrder)) {
            $this->ordersDetailForOrder = Array();
        }
    }
    
    public function getDisplayForTimeStamp() {
        return date('d-m-Y', $this->timestamp);
    }
    
   

}