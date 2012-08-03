<?php
class Vushop_Controller_Admin_ChangePasswordController extends Vushop_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_change_password';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';
    
    const FORM_FIELD_NEW_PASSWORD = 'newPassword';
    const FORM_FIELD_CONFIRMED_NEW_PASSWORD = 'confirmedNewPassword';
    
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
         * @var Vushop_Bo_User_BaseUserDao
         */
        $userDao = $this->getDao(DAO_USER);
        $this->user = $userDao->getUserById($this->userId);
    }
    
    /**
     * Test if the user to be edited is valid.
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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.changePassword.done'));
        $urlTransit = $this->getUrlUserManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);
        
        return new Dzit_ModelAndView($viewName, $model);
    }
    
    /**
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        $form = Array('action' => $_SERVER['REQUEST_URI'], 
                'actionCancel' => $this->getUrlUserManagement(), 
                'name' => 'frmEditUser');
        if ($model === NULL) {
            $model = Array();
        }
        $model[MODEL_USER] = $this->user;
        $model[FORM_ACTION] = $_SERVER['REQUEST_URI'];
        $model[FORM_ACTION_CANCEL] = $this->getUrlUserManagement();
        $model[FORM_NAME] = 'frmChangePassword';
        return $model;
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
        $newPasssword = isset($_POST[self::FORM_FIELD_NEW_PASSWORD]) ? trim($_POST[self::FORM_FIELD_NEW_PASSWORD]) : '';
        $confirmedNewPassword = isset($_POST[self::FORM_FIELD_CONFIRMED_NEW_PASSWORD]) ? trim($_POST[self::FORM_FIELD_CONFIRMED_NEW_PASSWORD]) : '';
        
        $lang = $this->getLanguage();
        if ($newPasssword === '') {
            $this->addErrorMessage($lang->getMessage('error.emptyPassword'));
        } else if ($newPasssword !== $confirmedNewPassword) {
            $this->addErrorMessage($lang->getMessage('error.passwordsMismatch'));
        }
        if ($this->hasError()) {
            return FALSE;
        }
        $this->user->setPassword(md5($newPasssword));
        $userDao->updateUser($this->user);
        return TRUE;
    }
}
