<?php
class Vushop_Controller_RegisterController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'register';
    const VIEW_NAME_AFTER_POST = 'info';
    
    const FORM_FIELD_TITLE = 'title';
    const FORM_FIELD_FULLNAME = 'fullname';
    const FORM_FIELD_LOCATION = 'location';
    const FORM_FIELD_USERNAME = 'username';
    const FORM_FIELD_EMAIL = 'email';
    const FORM_FIELD_PASSWORD = 'password';
    const FORM_FIELD_ADDRESS = 'address';
    const FORM_FIELD_PHONE = 'phone';
    const FORM_FIELD_CONFIRMED_PASSWORD = 'confirmedPassword';
    
    /**
     * @see Vushop_Controller_BaseFlowController::getViewName()
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
        
        $model[MODEL_URL_TRANSIT] = $_SERVER['SCRIPT_NAME'];
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $_SERVER['SCRIPT_NAME']);
        
        return new Dzit_ModelAndView($viewName, $model);
    }
    
    /**
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmRegister');
        $this->populateForm($form, Array(self::FORM_FIELD_TITLE, 
                self::FORM_FIELD_FULLNAME, 
                self::FORM_FIELD_USERNAME, 
                self::FORM_FIELD_LOCATION, 
                self::FORM_FIELD_ADDRESS, 
                self::FORM_FIELD_PHONE, 
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
        
        $username = isset($_POST[self::FORM_FIELD_USERNAME]) ? trim($_POST[self::FORM_FIELD_USERNAME]) : '';
        $email = isset($_POST[self::FORM_FIELD_EMAIL]) ? trim($_POST[self::FORM_FIELD_EMAIL]) : '';
        $address = isset($_POST[self::FORM_FIELD_ADDRESS]) ? trim($_POST[self::FORM_FIELD_ADDRESS]) : '';
        $phone = isset($_POST[self::FORM_FIELD_PHONE]) ? trim($_POST[self::FORM_FIELD_PHONE]) : '';
        $password = isset($_POST[self::FORM_FIELD_PASSWORD]) ? trim($_POST[self::FORM_FIELD_PASSWORD]) : '';
        $confirmedPassword = isset($_POST[self::FORM_FIELD_CONFIRMED_PASSWORD]) ? trim($_POST[self::FORM_FIELD_CONFIRMED_PASSWORD]) : '';
        
        if ($email === '') {
            $this->addErrorMessage($lang->getMessage('error.invalidEmail', $email));
        } else {
            if ($this->isValidEmail($email)) {
                $user = $userDao->getUserByEmail($email);
                if ($user !== NULL) {
                    $this->addErrorMessage($lang->getMessage('error.emailExists', htmlspecialchars($email)));
                }
            
            } else {
                $this->addErrorMessage($lang->getMessage('error.invalidEmail', $email));
            }
        }
        if ($username === '') {
            $this->addErrorMessage($lang->getMessage('error.invalidUsername', $username));
        } else {
            $user = $userDao->getUserByUsername($username);
            if ($user !== NULL) {
                $this->addErrorMessage($lang->getMessage('error.usernameExists', htmlspecialchars($username)));
            }
        }
        if ($password === '') {
            $this->addErrorMessage($lang->getMessage('error.emptyPassword'));
        } else if ($password !== $confirmedPassword) {
            $this->addErrorMessage($lang->getMessage('error.passwordsMismatch'));
        }
        if ($address === '') {
            $this->addErrorMessage($lang->getMessage('error.emptyAddress'));
        }
        if ($phone === '') {
            $this->addErrorMessage($lang->getMessage('error.emptyPhone'));
        }
        
        if ($this->hasError()) {
            return FALSE;
        }
        
        $user = new Vushop_Bo_User_BoUser();
        $user->setEmail($email);
        $user->setFullname($fullname);
        $user->setGroupId(USER_GROUP_MEMBER);
        $user->setLocation($location);
        $user->setPassword(md5($password));
        $user->setTitle($title);
        $user->setUsername($username);
        $user->setAddress($address);
        $user->setPhone($phone);
        $userDao->createUser($user);
        return TRUE;
    }
}
