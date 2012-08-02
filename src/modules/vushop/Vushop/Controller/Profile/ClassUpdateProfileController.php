<?php
class Vushop_Controller_Profile_UpdateProfileController extends Vushop_Controller_Profile_BaseProfileController {

    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = parent::buildModel_Form();
        if (!$this->hasError() && $this->isPostRequest()) {
            $lang = $this->getLanguage();
            $form[FORM_INFO_MESSAGES] = Array($lang->getMessage('msg.updateProfile.done'));
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

        $email = isset($_POST[self::FORM_FIELD_EMAIL]) ? strtolower(trim($_POST[self::FORM_FIELD_EMAIL])) : '';
        if ($email === '') {
            $this->addErrorMessage($lang->getMessage('error.invalidEmail', $email));
        } else {
            $user = $userDao->getUserByEmail($email);
            if ($user !== NULL && $user->getEmail() !== $currentUser->getEmail()) {
                $this->addErrorMessage($lang->getMessage('error.emailExists', htmlspecialchars($email)));
            }
        }

        // take care of the uploaded file
        $removeImage = isset($_POST[self::FORM_FIELD_REMOVE_IMAGE]) ? TRUE : FALSE;
        $paperclipId = isset($_SESSION[$this->sessionKey]) ? $_SESSION[$this->sessionKey] : NULL;
        $paperclipItem = $this->processUploadFile(self::FORM_FIELD_IMAGE, MAX_UPLOAD_FILESIZE, ALLOWED_UPLOAD_FILE_TYPES, $paperclipId);
        if ($paperclipItem !== NULL) {
            $_SESSION[$this->sessionKey] = $paperclipItem->getId();
        } else {
            $paperclipItem = $paperclipId !== NULL ? $this->getDao(DAO_PAPERCLIP)->getAttachment($paperclipId) : NULL;
            if ($removeImage && $paperclipItem !== NULL) {
                $paperclipDao = $this->getDao(DAO_PAPERCLIP);
                $paperclipDao->deleteAttachment($paperclipItem);
                unset($_SESSION[$this->sessionKey]);
            }
        }

        if ($this->hasError()) {
            return FALSE;
        }

        $fullname = isset($_POST[self::FORM_FIELD_FULLNAME]) ? trim($_POST[self::FORM_FIELD_FULLNAME]) : '';

        $currentUser->setEmail($email);
        $currentUser->setFullname($fullname);
        $userDao->updateUser($currentUser);

        $shopDao = $this->getDao(DAO_SHOP);
        $shopTitle = isset($_POST[self::FORM_FIELD_SHOP_TITLE]) ? trim($_POST[self::FORM_FIELD_SHOP_TITLE]) : '';
        $shopLocation = isset($_POST[self::FORM_FIELD_SHOP_LOCATION]) ? trim($_POST[self::FORM_FIELD_SHOP_LOCATION]) : '';
        $this->shop->setTitle($shopTitle);
        $this->shop->setLocation($shopLocation);
        $this->shop->setImageId($paperclipItem !== NULL ? $paperclipItem->getId() : NULL);
        $shopDao->updateShop($this->shop);

        // clean-up
        // unset($_SESSION[$this->sessionKey]);
        if ($paperclipItem !== NULL) {
            $paperclipItem->setIsDraft(FALSE);
            $paperclipDao = $this->getDao(DAO_PAPERCLIP);
            $paperclipDao->updateAttachment($paperclipItem);
        }

        return FALSE;
    }
}
