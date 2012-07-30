<?php
class Vushop_Controller_Profile_ChangePasswordController extends Vushop_Controller_Profile_BaseProfileController {

    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = parent::buildModel_Form();
        if (!$this->hasError()) {
            $lang = $this->getLanguage();
            $form[FORM_INFO_MESSAGES] = Array($lang->getMessage('msg.changePassword.done'));
        }
        return $form;
    }

    /**
     *
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $userDao = $this->getDao(DAO_USER);
        $lang = $this->getLanguage();
        $currentUser = $this->getCurrentUser();

        $currentPassword = isset($_POST[self::FORM_FIELD_CURRENT_PASSWORD]) ? trim($_POST[self::FORM_FIELD_CURRENT_PASSWORD]) : '';
        $newPassword = isset($_POST[self::FORM_FIELD_NEW_PASSWORD]) ? trim($_POST[self::FORM_FIELD_NEW_PASSWORD]) : '';
        $confirmedNewPassword = isset($_POST[self::FORM_FIELD_CONFIRMED_NEW_PASSWORD]) ? trim($_POST[self::FORM_FIELD_CONFIRMED_NEW_PASSWORD]) : '';
        if ($currentPassword !== '' && !$this->hasError()) {
            if (strtolower(md5($currentPassword)) !== strtolower($currentUser->getPassword())) {
                $this->addErrorMessage($lang->getMessage('error.currentPasswordMismatches'));
            } else if ($newPassword === '') {
                $this->addErrorMessage($lang->getMessage('error.emptyNewPassword'));
            } else if ($newPassword !== $confirmedNewPassword) {
                $this->addErrorMessage($lang->getMessage('error.passwordsMismatch'));
            }
        }
        if ($this->hasError()) {
            return FALSE;
        }
        $currentUser->setPassword(md5($newPassword));
        $userDao->updateUser($currentUser);

        return FALSE;
    }
}
