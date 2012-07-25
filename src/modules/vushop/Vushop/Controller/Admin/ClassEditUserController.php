<?php
class Vushop_Controller_Admin_EditUserController extends Vushop_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_edit_user';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';
    
    const FORM_FIELD_USERNAME = 'username';
    const FORM_FIELD_TITLE = 'title';
    const FORM_FIELD_FULLNAME = 'fullname';
    const FORM_FIELD_LOCATION = 'location';
    const FORM_FIELD_EMAIL = 'email';
    const FORM_FIELD_GROUP_ID = 'groupId';
    
    /**
     *
     * @var Vushop_Bo_User_BoUser
     */
    private $user = NULL;
    private $userId;
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
    
    /**
     * Populates userId and user instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         *
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->userId = $requestParser->getPathInfoParam(1);
        /**
         *
         * @var Vushop_Bo_User_MysqlUserDao
         */
        $userDao = $this->getDao(DAO_USER);
        $this->user = $userDao->getUserById($this->userId);
    }
    
    /**
     * Test if the ads to be edited is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $user = $this->user;
        $userId = $this->userId;
        if ($user === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.userNotFound', htmlspecialchars($userId)));
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     *
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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.editUser.done'));
        $urlTransit = $this->getUrlUserManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);
        
        return new Dzit_ModelAndView($viewName, $model);
    }
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        if ($this->user === NULL) {
            return NULL;
        }
        $form = Array('action' => $_SERVER['REQUEST_URI'], 
                'actionCancel' => $this->getUrlUserManagement(), 
                'name' => 'frmEditUser');
        
        $form[self::FORM_FIELD_USERNAME] = $this->user->getUsername();
        $form[self::FORM_FIELD_FULLNAME] = $this->user->getFullname();
        $form[self::FORM_FIELD_EMAIL] = $this->user->getEmail();
        $form[self::FORM_FIELD_GROUP_ID] = $this->user->getGroupId();
        $form[self::FORM_FIELD_LOCATION] = $this->user->getLocation();
        $form[self::FORM_FIELD_TITLE] = $this->user->getTitle();
        
        $this->populateForm($form, Array(self::FORM_FIELD_USERNAME, 
                self::FORM_FIELD_FULLNAME, 
                self::FORM_FIELD_EMAIL, 
                self::FORM_FIELD_GROUP_ID, 
                self::FORM_FIELD_LOCATION, 
                self::FORM_FIELD_TITLE));
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
        /**
         *
         * @var Ddth_Mls_ILanguage
         */
        $lang = $this->getLanguage();
        
        /**
         *
         * @var Vushop_Bo_User_MysqlUserDao
         */
        $userDao = $this->getDao(DAO_USER);
        $title = isset($_POST[self::FORM_FIELD_TITLE]) ? trim($_POST[self::FORM_FIELD_TITLE]) : '';
        $fullname = isset($_POST[self::FORM_FIELD_FULLNAME]) ? trim($_POST[self::FORM_FIELD_FULLNAME]) : '';
        $location = isset($_POST[self::FORM_FIELD_LOCATION]) ? trim($_POST[self::FORM_FIELD_LOCATION]) : '';
        $groupId = isset($_POST[self::FORM_FIELD_GROUP_ID]) ? trim($_POST[self::FORM_FIELD_GROUP_ID]) : 2;
        $email = isset($_POST[self::FORM_FIELD_EMAIL]) ? trim($_POST[self::FORM_FIELD_EMAIL]) : '';
        $username = isset($_POST[self::FORM_FIELD_USERNAME]) ? trim($_POST[self::FORM_FIELD_USERNAME]) : '';
        
        $lang = $this->getLanguage();
        if ($email === '') {
            $this->addErrorMessage($lang->getMessage('error.invalidEmail', $email));
        
        } else {
            if ($this->user->getEmail() !== $email) {
                $user = $userDao->getUserByEmail($email);
                if ($user !== NULL) {
                    $this->addErrorMessage($lang->getMessage('error.emailExists', htmlspecialchars($email)));
                }
            }
        }
        if ($username === '') {
            $this->addErrorMessage($lang->getMessage('error.invalidUsername', $username));
        } else {
            if ($this->user->getUsername() !== $username) {
                $user = $userDao->getUserByUsername($username);
                if ($user !== NULL) {
                    $this->addErrorMessage($lang->getMessage('error.usernameExists', htmlspecialchars($username)));
                }
            }
        }
        
        if ($this->hasError()) {
            return FALSE;
        }
        
        //Update Object Information       
        $this->user->setEmail($email);
        $this->user->setFullname($fullname);
        $this->user->setGroupId($groupId);
        $this->user->setLocation($location);
        $this->user->setTitle($title);
        $this->user->setUsername($username);
        
        $userDao->updateUser($this->user);
        
        return TRUE;
    }
}
