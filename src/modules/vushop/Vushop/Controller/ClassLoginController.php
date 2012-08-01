<?php
class Vushop_Controller_LoginController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'login';
    const VIEW_NAME_AFTER_POST = 'info';

    const FORM_FIELD_USERNAME = 'username';
    const FORM_FIELD_PASSWORD = 'password';

    /**
     *
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     *
     * @see Dzit_Controller_FlowController::getModelAndView_FormSubmissionSuccessful()
     */
    protected function getModelAndView_FormSubmissionSuccessful() {
        $viewName = self::VIEW_NAME_AFTER_POST;
        $model = $this->buildModel();
        if ($model == NULL) {
            $model = Array();
        }

        $lang = $this->getLanguage();
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.login.done'));

        if (isset($_SESSION[SESSION_LAST_ACCESS_URL])) {
            $urlTransit = $_SESSION[SESSION_LAST_ACCESS_URL];
        } else {
            $urlTransit = $_SERVER['SCRIPT_NAME'];
        }
        if (strpos($urlTransit, '?') === FALSE) {
            $urlTransit .= '?' . rand();
        } else {
            $urlTransit .= '&' . rand();
        }
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 1 Jan 2011 00:00:00 GMT"); // Date in the past
        header("Pragma: no-cache");

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     *
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmLogin');
        $this->populateForm($form, Array(self::FORM_FIELD_USERNAME));
        if ($this->hasError()) {
            $form['errorMessages'] = $this->getErrorMessages();
        }
        return $form;
    }

    /**
     *
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $lang = $this->getLanguage();
        $userDao = $this->getDao(DAO_USER);
        $username = isset($_POST[self::FORM_FIELD_USERNAME]) ? trim($_POST[self::FORM_FIELD_USERNAME]) : '';
        $password = isset($_POST[self::FORM_FIELD_PASSWORD]) ?  trim($_POST[self::FORM_FIELD_PASSWORD]) : '';

        // $username = trim(strtolower($username));
        $password = trim($password);

        if ($username === '' || $password === '') {
            $this->addErrorMessage($lang->getMessage('error.loginFailed'));
            return FALSE;
        }

        // $user = $userDao->getUserByEmail($username);
        $user = $userDao->getUserByUsername($username);
        if ($user === NULL) {
            $this->addErrorMessage($lang->getMessage('error.loginFailed'));
            return FALSE;
        }
        if (strtolower(md5($password)) !== strtolower($user->getPassword())) {
            $this->addErrorMessage($lang->getMessage('error.loginFailed'));
            return FALSE;
        }
        // $_SESSION[SESSION_USER_ID] = strtolower(trim($_POST['email']));
        $_SESSION[SESSION_USER_ID] = $user->getId();
        if ($user->getGroupId() == USER_GROUP_SHOP_OWNER) {
            $shopDao = $this->getDao(DAO_SHOP);
            if ($shopDao->getShopById($user->getId()) === NULL) {
                $shop = new Vushop_Bo_Shop_BoShop();
                $shop->setOwnerId($user->getId());
                $shop->setTitle($user->getUsername());
                $shop->setPosition(time());
                $shop->setDescription($user->getUsername() . ' shop');
                $shopDao->createShop($shop);
            }
        }
        return TRUE;
    }
}
