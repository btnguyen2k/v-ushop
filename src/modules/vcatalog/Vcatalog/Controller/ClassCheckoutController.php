<?php
class Vcatalog_Controller_CheckoutController extends Vcatalog_Controller_BaseFlowController {
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
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
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
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
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

        $configDao = $this->getDao(DAO_CONFIG);
        require_once 'class.phpmailer.php';
        $mailer = new PHPMailer(TRUE);
        $mailer->SetFrom($configDao->loadConfig(CONFIG_EMAIL_OUTGOING));
        $mailer->AddAddress($configDao->loadConfig(CONFIG_EMAIL_ORDER_NOTIFICATION));
        $mailer->ContentType = 'text/html';
        $mailer->Encoding = 'UTF-8';
        $subject = $configDao->loadConfig(CONFIG_EMAIL_ON_SUBJECT);
        $body = $configDao->loadConfig(CONFIG_EMAIL_ON_BODY);
        $replacements = Array('SITE_NAME' => $configDao->loadConfig(CONFIG_SITE_NAME),
                'SITE_TITLE' => $configDao->loadConfig(CONFIG_SITE_TITLE),
                'SITE_SLOGAN' => $configDao->loadConfig(CONFIG_SITE_SLOGAN),
                'SITE_COPYRIGHT' => $configDao->loadConfig(CONFIG_SITE_COPYRIGHT),
                'ORDER_NAME' => $orderName,
                'ORDER_EMAIL' => $orderEmail,
                'ORDER_PHONE' => $orderPhone,
                'ORDER_OTHER_INFO' => $orderOtherInfo,
                'PAYMENT_METHOD' => $orderPaymentMethod ? $lang->getMessage('msg.order.paymentMethod.cash') : $lang->getMessage('msg.order.paymentMethod.transfer'));
        $mailer->Subject = $this->renderEmail($subject, $replacements);
        $mailer->MsgHTML($this->renderEmail($body, $replacements));

        if ($configDao->loadConfig(CONFIG_USE_SMTP) != 0) {
            $mailer->IsSMTP();
            $smtpHost = $configDao->loadConfig(CONFIG_SMTP_HOST);
            $smtpPort = $configDao->loadConfig(CONFIG_SMTP_PORT);
            $mailer->Host = $smtpHost;
            if ($smtpPort) {
                $mailer->Port = $smtpPort;
            }
            $smtpUsername = $configDao->loadConfig(CONFIG_SMTP_USERNAME);
            $smtpPassword = $configDao->loadConfig(CONFIG_SMTP_PASSWORD);
            if ($smtpUsername != '') {
                $mailer->SMTPAuth = TRUE;
                $mailer->Username = $smtpUsername;
                $mailer->Password = $smtpPassword;
            }
            if ($configDao->loadConfig(CONFIG_SMTP_SSL) != 0) {
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

        return FALSE;
    }

    private function renderEmail($content, $params = Array()) {
        foreach ($params as $key => $value) {
            $content = str_replace('{' . $key . '}', $value, $content);
        }
        return $content;
    }
}
