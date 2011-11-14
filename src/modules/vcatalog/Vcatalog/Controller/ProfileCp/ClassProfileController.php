<?php
class Vcatalog_Controller_ProfileCp_ProfileController extends Vcatalog_Controller_BaseFlowController {

    const VIEW_NAME = 'profilecp_profile';
    const VIEW_NAME_AFTER_POST = 'profilecp_profile';

    const FORM_FIELD_TITLE = 'title';
    const FORM_FIELD_FULLNAME = 'fullname';
    const FORM_FIELD_LOCATION = 'location';
    const FORM_FIELD_EMAIL = 'email';
    const FORM_FIELD_CURRENT_PASSWORD = 'currentPassword';
    const FORM_FIELD_NEW_PASSWORD = 'newPassword';
    const FORM_FIELD_CONFIRMED_NEW_PASSWORD = 'confirmedNewPassword';

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
        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmProfile');
        $user = $this->getCurrentUser();
        $form[self::FORM_FIELD_TITLE] = $user->getTitle();
        $form[self::FORM_FIELD_FULLNAME] = $user->getFullname();
        $form[self::FORM_FIELD_LOCATION] = $user->getLocation();
        $form[self::FORM_FIELD_EMAIL] = $user->getEmail();
        $this->populateForm($form, Array(self::FORM_FIELD_TITLE,
                self::FORM_FIELD_FULLNAME,
                self::FORM_FIELD_LOCATION,
                self::FORM_FIELD_EMAIL));
        if ($this->hasError()) {
            $form[FORM_ERROR_MESSAGES] = $this->getErrorMessages();
        } else if ($this->isPostRequest()) {
            $lang = $this->getLanguage();
            $form[FORM_INFO_MESSAGES] = Array($lang->getMessage('msg.updateProfile.done'));
        }
        return $form;
    }

    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $userDao = $this->getDao(DAO_USER);
        $lang = $this->getLanguage();
        $currentUser = $this->getCurrentUser();

        $email = isset($_POST[self::FORM_FIELD_EMAIL]) ? strtolower(trim($_POST[self::FORM_FIELD_EMAIL])) : '';
        if ($email === '') {
            $this->addErrorMessage($lang->getMessage('error.invalidEmail', $email));
        } else {
            $user = $userDao->getUserByEmail($email);
            if ($user !== NULL && $user->getEmail() !== $currentUser->getEmail()) {
                $this->addErrorMessage($lang->getMessage('error.emailExists', htmlspecialchars($email)));
            }
        }

        $currentPassword = isset($_POST[self::FORM_FIELD_CURRENT_PASSWORD]) ? strtolower(trim($_POST[self::FORM_FIELD_CURRENT_PASSWORD])) : '';
        $newPassword = isset($_POST[self::FORM_FIELD_NEW_PASSWORD]) ? strtolower(trim($_POST[self::FORM_FIELD_NEW_PASSWORD])) : '';
        $confirmedNewPassword = isset($_POST[self::FORM_FIELD_CONFIRMED_NEW_PASSWORD]) ? strtolower(trim($_POST[self::FORM_FIELD_CONFIRMED_NEW_PASSWORD])) : '';
        if ($currentPassword !== '' && !$this->hasError()) {
            if (strtolower(md5($currentPassword)) !== strtolower($currentUser->getPassword())) {
                $this->addErrorMessage($lang->getMessage('error.currentPasswordMismatches'));
            } else if ($newPassword === '') {
                $this->addErrorMessage($lang->getMessage('error.emptyNewPassword'));
            } else if ($newPassword !== $confirmedNewPassword) {
                $this->addErrorMessage($lang->getMessage('error.passwordsMismatch'));
            } else {
                $currentUser->setPassword(strtolower(md5($newPassword)));
            }
        }

        if ($this->hasError()) {
            return FALSE;
        }

        $title = isset($_POST[self::FORM_FIELD_TITLE]) ? trim($_POST[self::FORM_FIELD_TITLE]) : '';
        $fullname = isset($_POST[self::FORM_FIELD_FULLNAME]) ? trim($_POST[self::FORM_FIELD_FULLNAME]) : '';
        $location = isset($_POST[self::FORM_FIELD_LOCATION]) ? trim($_POST[self::FORM_FIELD_LOCATION]) : '';

        $currentUser->setEmail($email);
        $currentUser->setTitle($title);
        $currentUser->setFullname($fullname);
        $currentUser->setLocation($location);
        $_SESSION[SESSION_USER_ID] = $email;
        $userDao->updateUser($currentUser);

        return FALSE;
    }
}
