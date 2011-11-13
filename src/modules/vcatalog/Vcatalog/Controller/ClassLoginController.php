<?php
class Vcatalog_Controller_LoginController extends Vcatalog_Controller_BaseFlowController {
    const VIEW_NAME = 'login';
    const VIEW_NAME_AFTER_POST = 'info';

    const FORM_FIELD_EMAIL = 'email';
    const FORM_FIELD_PASSWORD = 'password';

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
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
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmLogin');
        $this->populateForm($form, Array(self::FORM_FIELD_EMAIL));
        if ($this->hasError()) {
            $form['errorMessages'] = $this->getErrorMessages();
        }
        return $form;
    }

    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $lang = $this->getLanguage();
        $userDao = $this->getDao(DAO_USER);
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $email = trim(strtolower($email));
        $password = trim($password);

        if ($email === '' || $password === '') {
            $this->addErrorMessage($lang->getMessage('error.loginFailed'));
            return FALSE;
        }

        $user = $userDao->getUserByEmail($email);
        if ($user === NULL) {
            $this->addErrorMessage($lang->getMessage('error.loginFailed'));
            return FALSE;
        }
        if (strtolower(md5($password)) !== strtolower($user->getPassword())) {
            $this->addErrorMessage($lang->getMessage('error.loginFailed'));
            return FALSE;
        }
        $_SESSION[SESSION_USER_ID] = strtolower(trim($_POST['email']));
        return TRUE;
    }
}
