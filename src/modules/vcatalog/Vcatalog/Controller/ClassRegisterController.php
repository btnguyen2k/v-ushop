<?php
class Vcatalog_Controller_RegisterController extends Vcatalog_Controller_BaseFlowController {
    const VIEW_NAME = 'register';
    const VIEW_NAME_AFTER_POST = 'info';

    const FORM_FIELD_TITLE = 'title';
    const FORM_FIELD_FULLNAME = 'fullname';
    const FORM_FIELD_LOCATION = 'location';
    const FORM_FIELD_EMAIL = 'email';
    const FORM_FIELD_PASSWORD = 'password';
    const FORM_FIELD_CONFIRMED_PASSWORD = 'confirmedPassword';

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
        $model[MODEL_INFO_MESSAGES] = Array(
                $lang->getMessage('msg.register.done', htmlspecialchars($_POST[self::FORM_FIELD_EMAIL])));
        /*
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
        */

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmRegister');
        $this->populateForm($form, Array(self::FORM_FIELD_TITLE,
                self::FORM_FIELD_FULLNAME,
                self::FORM_FIELD_LOCATION,
                self::FORM_FIELD_EMAIL));
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
        $title = isset($_POST[self::FORM_FIELD_TITLE]) ? trim($_POST[self::FORM_FIELD_TITLE]) : '';
        $fullname = isset($_POST[self::FORM_FIELD_FULLNAME]) ? trim($_POST[self::FORM_FIELD_FULLNAME]) : '';
        $location = isset($_POST[self::FORM_FIELD_LOCATION]) ? trim($_POST[self::FORM_FIELD_LOCATION]) : '';

        $email = isset($_POST[self::FORM_FIELD_EMAIL]) ? trim($_POST[self::FORM_FIELD_EMAIL]) : '';
        $password = isset($_POST[self::FORM_FIELD_PASSWORD]) ? trim($_POST[self::FORM_FIELD_PASSWORD]) : '';
        $confirmedPassword = isset($_POST[self::FORM_FIELD_CONFIRMED_PASSWORD]) ? trim($_POST[self::FORM_FIELD_CONFIRMED_PASSWORD]) : '';

        if ($email === '') {
            $this->addErrorMessage($lang->getMessage('error.invalidEmail', $email));
        } else {
            $user = $userDao->getUserByEmail($email);
            if ($user !== NULL) {
                $this->addErrorMessage($lang->getMessage('error.emailExists', htmlspecialchars($email)));
            }
        }
        if ($password === '') {
            $this->addErrorMessage($lang->getMessage('error.emptyPassword'));
        } else if ($password !== $confirmedPassword) {
            $this->addErrorMessage($lang->getMessage('error.passwordsMismatch'));
        }

        if ($this->hasError()) {
            return FALSE;
        }

        $userDao->createUser($email, md5($password), USER_GROUP_MEMBER, $title, $fullname, $location);
        return TRUE;
    }
}
