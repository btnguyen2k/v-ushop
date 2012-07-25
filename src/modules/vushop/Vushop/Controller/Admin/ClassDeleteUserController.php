<?php
class Vushop_Controller_Admin_DeleteUserController extends Vushop_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_delete_user';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';

    /**
     * @var Vushop_Bo_User_BoUser
     */
    private $user = NULL;
    private $userId;

    /**
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * Populates pageId and page instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->userId = $requestParser->getPathInfoParam(1);
        /**
         * @var Vushop_Bo_User_IUserDao
         */
        $userDao = $this->getDao(DAO_USER);
        $this->user = $userDao->getUserById($this->userId);
    }

    /**
     * Test if the user to be deleted is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $user = $this->user;
        $userId = $this->userId;
        $lang = $this->getLanguage();
        if ($user === NULL) {
            //the user must exist
            $this->addErrorMessage($lang->getMessage('error.userNotFound', htmlspecialchars($userId)));
            return FALSE;
        }
        return TRUE;
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
                $lang->getMessage('msg.deleteUser.done', htmlspecialchars($this->userId)));
        $urlTransit = $this->getUrlUserManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        if ($this->user === NULL) {
            return NULL;
        }
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $this->getUrlUserManagement(),
                'name' => 'frmDeleteUser');
        $lang = $this->getLanguage();
        $user = $this->user;
        $infoMsg = $lang->getMessage('msg.deleteUser.confirmation', htmlspecialchars($user->getUsername()));
        $form['infoMessages'] = Array($infoMsg);
        if ($this->hasError()) {
            $form['errorMessages'] = $this->getErrorMessages();
        }
        return $form;
    }

    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        /**
         * @var Vushop_Bo_Page_IPageDao
         */
        $userDao = $this->getDao(DAO_USER);
        $userDao->deleteUser($this->user);
        return TRUE;
    }
}
