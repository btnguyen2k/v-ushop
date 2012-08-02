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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.checkout.done'));
        $urlTransit = $_SERVER['SCRIPT_NAME'];
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

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

        require_once 'class.phpmailer.php';
        $mailer = new PHPMailer(TRUE);
        $mailer->SetFrom($this->getAppConfig(CONFIG_EMAIL_OUTGOING));
        $mailer->AddAddress($this->getAppConfig(CONFIG_EMAIL_ORDER_NOTIFICATION));
        //$mailer->ContentType = 'text/html';
        $mailer->CharSet = 'UTF-8';
        $subject = $this->getAppConfig(CONFIG_EMAIL_ON_SUBJECT);
        $body = $this->getAppConfig(CONFIG_EMAIL_ON_BODY);
        $cart = $this->getCurrentCart();
        $orderItems = '<table border="1"><thread><tr><th style="text-align: center;">';
        $orderItems .= $lang->getMessage('msg.item') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="64px">';
        $orderItems .= $lang->getMessage('msg.item.vendor') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="64px">';
        $orderItems .= $lang->getMessage('msg.price') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="64px">';
        $orderItems .= $lang->getMessage('msg.quantity') . '</th>';
        $orderItems .= '<th style="text-align: center;" width="100px">';
        $orderItems .= $lang->getMessage('msg.total') . '</th>';
        $orderItems .= '</tr></thead>';
        $orderItems .= '<tbody>';
        foreach ($cart->getItems() as $item) {
            $orderItems .= '<tr>';
            $orderItems .= '<td>' . htmlspecialchars($item->getTitle()) . '</td>';
            $orderItems .= '<td>' . htmlspecialchars($item->getVendor()) . '</td>';
            $orderItems .= '<td align="right">' . $item->getPriceForDisplay() . '</td>';
            $orderItems .= '<td align="right">' . $item->getQuantityForDisplay() . '</td>';
            $orderItems .= '<td align="right">' . $item->getTotalForDisplay() . '</td>';
            $orderItems .= '</tr>';
        }
        $orderItems .= '</tbody>';
        $orderItems .= '<tfoot><tr>';
        $orderItems .= '<th style="text-align: center;" colspan="4">' . $lang->getMessage('msg.grandTotal') . '</th>';
        $orderItems .= '<th style="text-align: right;">' . $cart->getGrandTotalForDisplay() . '</th>';
        $orderItems .= '</tr></tfoot>';
        $orderItems .= '</table>';

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
                'PAYMENT_METHOD' => $orderPaymentMethod==0 ? $lang->getMessage('msg.order.paymentMethod.cash') : $lang->getMessage('msg.order.paymentMethod.transfer'));
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
}
