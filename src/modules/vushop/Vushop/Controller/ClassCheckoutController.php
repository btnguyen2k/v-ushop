<?php
class Vushop_Controller_CheckoutController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'checkout';
    const VIEW_NAME_ERROR = 'error';
    const VIEW_NAME_AFTER_POST = 'info';
    
    const FORM_FIELD_ORDER_NAME = 'orderName';
    const FORM_FIELD_ORDER_EMAIL = 'orderEmail';
    const FORM_FIELD_ORDER_PHONE = 'orderPhone';
    const FORM_FIELD_ORDER_PAYMENT_METHOD = 'orderPaymentMethod';
    const FORM_FIELD_ORDER_OTHER_INFO = 'orderOtherInfo';
    
    private $orderId;
    
    /**
     * Test if the cart is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $cart = $this->getCurrentCart();
        if ($cart->isEmpty()) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.emptyCart'));
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
    
    /**
     * @see Dzit_Controller_FlowController::getModelAndView_Error()
     */
    protected function getModelAndView_Error() {
        $viewName = self::VIEW_NAME_ERROR;
        $model = $this->buildModel();
        if ($model == NULL) {
            $model = Array();
        }
        
        $lang = $this->getLanguage();
        $model[MODEL_ERROR_MESSAGES] = $this->getErrorMessages();
        
        return new Dzit_ModelAndView($viewName, $model);
    }
    
    /**
     * @see Dzit_Controller_FlowController::getModelAndView_FormSubmissionSuccessful()
     */
    protected function getModelAndView_FormSubmissionSuccessful() {
        $viewName = self::VIEW_NAME_AFTER_POST;
        $model = $this->buildModel();
        if ($model == NULL) {
            $model = Array();
        }
        $lang = $this->getLanguage();
        $model[MODEL_INFO_MESSAGES] = Array(
                $lang->getMessage('msg.checkout.done', htmlspecialchars($this->orderId)));
        
        return new Dzit_ModelAndView($viewName, $model);
    }
    
    /**
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $cart = $this->getCurrentCart();
        
        $form = Array('action' => $_SERVER['REQUEST_URI'], 
                'actionCancel' => $cart->getUrlView(), 
                'name' => 'frmCheckout');
        if ($this->getCurrentUser() !== NULL) {
            $user = $this->getCurrentUser();
            $form[self::FORM_FIELD_ORDER_NAME] = $user->getFullname();
            $form[self::FORM_FIELD_ORDER_EMAIL] = $user->getEmail();
            $form[self::FORM_FIELD_ORDER_PHONE] = $user->getPhone() != NULL ? $user->getPhone() : '';
            $form[self::FORM_FIELD_ORDER_OTHER_INFO] = $user->getAddress() != NULL ? $user->getAddress() : '';
        
        }
        $this->populateForm($form, Array(self::FORM_FIELD_ORDER_EMAIL, 
                self::FORM_FIELD_ORDER_NAME, 
                self::FORM_FIELD_ORDER_PHONE, 
                self::FORM_FIELD_ORDER_OTHER_INFO, 
                self::FORM_FIELD_ORDER_PAYMENT_METHOD));
        if ($this->hasError()) {
            $form['errorMessages'] = $this->getErrorMessages();
        }
        return $form;
    }
    
    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $orderEmail = isset($_POST[self::FORM_FIELD_ORDER_EMAIL]) ? trim($_POST[self::FORM_FIELD_ORDER_EMAIL]) : '';
        $orderName = isset($_POST[self::FORM_FIELD_ORDER_NAME]) ? trim($_POST[self::FORM_FIELD_ORDER_NAME]) : '';
        $orderPhone = isset($_POST[self::FORM_FIELD_ORDER_PHONE]) ? trim($_POST[self::FORM_FIELD_ORDER_PHONE]) : '';
        $orderOtherInfo = isset($_POST[self::FORM_FIELD_ORDER_OTHER_INFO]) ? trim($_POST[self::FORM_FIELD_ORDER_OTHER_INFO]) : '';
        $orderPaymentMethod = isset($_POST[self::FORM_FIELD_ORDER_PAYMENT_METHOD]) ? (int)$_POST[self::FORM_FIELD_ORDER_PAYMENT_METHOD] : 0;
        
        /**
         * @var Ddth_Mls_ILanguage
         */
        $lang = $this->getLanguage();
        
        if ($orderEmail === '') {
            $this->addErrorMessage($lang->getMessage('error.emptyOrderEmail'));
        } else {
            if (!$this->isValidEmail($orderEmail)) {
                
                $this->addErrorMessage($lang->getMessage('error.invalidEmail', $orderEmail));
            }
        }
        if ($orderName === '') {
            $this->addErrorMessage($lang->getMessage('error.emptyOrderName'));
        }
        if ($orderPhone === '') {
            $this->addErrorMessage($lang->getMessage('error.emptyOrderPhone'));
        }
        
        if ($this->hasError()) {
            return FALSE;
        }
        
        $this->createOrder($this->getCurrentCart(), $orderEmail, $orderPhone, $orderPaymentMethod, $orderOtherInfo, $orderName);
        
        require_once 'class.phpmailer.php';
        $mailer = new PHPMailer(TRUE);
        $mailer->SetFrom($this->getAppConfig(CONFIG_EMAIL_OUTGOING));
        $mailer->AddAddress($this->getAppConfig(CONFIG_EMAIL_ORDER_NOTIFICATION));
        $mailer->AddAddress($orderEmail);
        //$mailer->ContentType = 'text/html';
        $mailer->CharSet = 'UTF-8';
        $subject = $this->getAppConfig(CONFIG_EMAIL_ON_SUBJECT);
        $body = $this->getAppConfig(CONFIG_EMAIL_ON_BODY);
        $cart = $this->getCurrentCart();
      
        $orderItems = '<table border="1"><thread><tr><th style="text-align: center;">';
        $orderItems .= $lang->getMessage('msg.item') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="64px">';
        $orderItems .= $lang->getMessage('msg.item.code') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="64px">';
        $orderItems .= $lang->getMessage('msg.item.vendor') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="64px">';
        $orderItems .= $lang->getMessage('msg.shop') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="64px">';
        $orderItems .= $lang->getMessage('msg.price') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="64px">';
        $orderItems .= $lang->getMessage('msg.quantity') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="100px">';
        $orderItems .= $lang->getMessage('msg.total') . '</th>';
        $orderItems .= '</tr></thead>';
        $orderItems .= '<tbody>';
        foreach ($cart->getItems() as $item) {
            $shopName='';
            $shop=$item->getShop();
            if ($shop!=null){
                $shopName=$shop->getTitle();
            }
            $orderItems .= '<tr>';
            $orderItems .= '<td>' . htmlspecialchars($item->getTitle()) . '</td>';
            $orderItems .= '<td>' . htmlspecialchars($item->getCode()) . '</td>';
            $orderItems .= '<td>' . htmlspecialchars($item->getVendor()) . '</td>';
             $orderItems .= '<td>' . htmlspecialchars($shopName) . '</td>';
            $orderItems .= '<td align="right">' . $item->getPriceForDisplay() . '</td>';
            $orderItems .= '<td align="right">' . $item->getQuantityForDisplay() . '</td>';
            $orderItems .= '<td align="right">' . $item->getTotalForDisplay() . '</td>';
            $orderItems .= '</tr>';
        }
        $orderItems .= '</tbody>';
        $orderItems .= '<tfoot><tr>';
        $orderItems .= '<th style="text-align: right;" colspan="6">' . $lang->getMessage('msg.grandTotal') . '</th>';
        $orderItems .= '<th style="text-align: right;">' . $cart->getGrandTotalForDisplay() . '</th>';
        $orderItems .= '</tr></tfoot>';
        $orderItems .= '</table>';
        
        $arrayMap = array();
        foreach ($cart->getItems() as $item) {            
            $shop = $item->getShop();
            if (isset($shop)) {
                if (!array_key_exists($shop->getTitle(),$arrayMap)) {
                    $arrayMap[$shop->getTitle()] = $shop->getLocation();
                }
            }
        }
        $orderItems .= '<ul>';
         $values=array_values($arrayMap);
        $i=0;
        foreach (array_keys($arrayMap) as $key) {            
             $orderItems .='<li><span style="font-weight:bold;">'.$key.'</span>: '.$values[$i].'</li>';
             $i++;
        }
        $orderItems .= '</ul>';
        
        $replacements = Array(
                'SITE_NAME' => htmlspecialchars($this->getAppConfig(CONFIG_SITE_NAME)), 
                'SITE_TITLE' => htmlspecialchars($this->getAppConfig(CONFIG_SITE_TITLE)), 
                'SITE_SLOGAN' => htmlspecialchars($this->getAppConfig(CONFIG_SITE_SLOGAN)), 
                'SITE_COPYRIGHT' => htmlspecialchars($this->getAppConfig(CONFIG_SITE_COPYRIGHT)), 
                'ORDER_NAME' => htmlspecialchars($orderName), 
                'ORDER_EMAIL' => htmlspecialchars($orderEmail), 
                'ORDER_PHONE' => htmlspecialchars($orderPhone), 
                'ORDER_OTHER_INFO' => htmlspecialchars($orderOtherInfo), 
                'ORDER_ITEMS' => $orderItems, 
                'PAYMENT_METHOD' => $orderPaymentMethod == 0 ? $lang->getMessage('msg.order.paymentMethod.cash') : $lang->getMessage('msg.order.paymentMethod.transfer'));
        //$mailer->IsHTML(TRUE);
        $mailer->Subject = $this->renderEmail($subject, $replacements);
        $mailer->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        $mailer->MsgHTML($this->renderEmail($body, $replacements));
        
        if ($this->getAppConfig(CONFIG_USE_SMTP) != 0) {
            $mailer->IsSMTP();
            $smtpHost = $this->getAppConfig(CONFIG_SMTP_HOST);
            $smtpPort = $this->getAppConfig(CONFIG_SMTP_PORT);
            $mailer->Host = $smtpHost;
            if ($smtpPort) {
                $mailer->Port = $smtpPort;
            }
            $smtpUsername = $this->getAppConfig(CONFIG_SMTP_USERNAME);
            $smtpPassword = $this->getAppConfig(CONFIG_SMTP_PASSWORD);
            if ($smtpUsername != '') {
                $mailer->SMTPAuth = TRUE;
                $mailer->Username = $smtpUsername;
                $mailer->Password = $smtpPassword;
            }
            if ($this->getAppConfig(CONFIG_SMTP_SSL) != 0) {
                $mailer->SMTPSecure = 'ssl';
            }
        }
        
        try {
            $mailer->Send();
        } catch (Exception $e) {
            /**
             * @var Ddth_Commons_Logging_ILog
             */
            $LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
            $msg = "Can not send email: " . $e->getMessage();
            $LOGGER->error($msg, $e);
        }
        
        //clear the cart
        $cartDao = $this->getDao(DAO_CART);
        foreach ($cart->getItems() as $item) {
            $cartDao->deleteCartItem($item);
        }
        
        return TRUE;
    }
    
    private function renderEmail($content, $params = Array()) {
        foreach ($params as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }
        return $content;
    }
    
    private function createOrder($cart, $orderEmail, $orderPhone, $orderPaymentMethod, $orderAddress, $orderName) {
        if ($cart != NULL) {
            $id = Quack_Util_IdUtils::id48hex();
            $order = new Vushop_Bo_Order_BoOrder();
            $order->setId($id);
            $order->setAddress($orderAddress);
            $order->setEmail($orderEmail);
            $order->setFullName($orderName);
            $order->setPaymentMethod($orderPaymentMethod);
            $order->setPhone($orderPhone);
            $order->setTimestamp(time());
            $orderDao = $this->getDao(DAO_ORDER);
            $orderDao->createOrder($order);
            $this->createOrderDetail($cart, $id, $orderDao, $orderPaymentMethod);
            $this->orderId = $id;
        }
    }
    
    private function createOrderDetail($cart, $orderId, $orderDao, $orderPaymentMethod) {
        if ($cart != NULL) {
            $orderDetail = new Vushop_Bo_Order_BoOrderDetail();
            $cartItems = $cart->getItems();
            if (isset($cartItems) && count($cartItems) > 0) {
                foreach ($cartItems as $cartItem) {
                    $orderDetail->setItemId($cartItem->getItemId());
                    $orderDetail->setOrderId($orderId);
                    $price = $orderPaymentMethod == 0 ? $cartItem->getPrice() : $cartItem->getOldPrice();
                    $orderDetail->setPrice($price);
                    $orderDetail->setQuantity($cartItem->getQuantity());
                    $orderDetail->setTimestamp(time());
                    $orderDetail->setStatus(0);
                    $orderDao->createOrderDetail($orderDetail);
                }
            }
        }
    }
}
