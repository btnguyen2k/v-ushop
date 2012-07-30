<?php
class Vushop_Controller_ProfileCp_ChangePasswordController extends Vushop_Controller_BaseFlowController {

    const VIEW_NAME = 'profile_profile';
    const VIEW_NAME_AFTER_POST = 'profile_profile';

    const FORM_FIELD_FULLNAME = 'fullname';
    const FORM_FIELD_EMAIL = 'email';
    const FORM_FIELD_USERNAME = 'username';
    const FORM_FIELD_SHOP_TITLE = 'shopTitle';
    const FORM_FIELD_IMAGE = 'shopImage';
    const FORM_FIELD_IMAGE_ID = 'shopImageId';
    const FORM_FIELD_URL_SHOP_IMAGE = 'urlShopImage';
    const FORM_FIELD_CURRENT_PASSWORD = 'currentPassword';
    const FORM_FIELD_NEW_PASSWORD = 'newPassword';
    const FORM_FIELD_CONFIRMED_NEW_PASSWORD = 'confirmedNewPassword';

    private $sessionKey;

    public function __construct() {
        parent::__construct();
        $this->sessionKey = __CLASS__ . '_fileId';
    }

    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    protected function populateParams() {
        $shopDao = $this->getDao(DAO_SHOP);
        $shop = $shopDao->getShopById($this->getCurrentUser()->getId());
        if ($shop !== NULL) {
            $r = md5($shop->getImageId());
            $this->sessionKey .= $r;
            $_SESSION[$this->sessionKey] = $shop->getImageId();
        }
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
        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $user = $this->getCurrentUser();
        $shopDao = $this->getDao(DAO_SHOP);
        $shop = $shopDao->getShopById($user->getId());

        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'name' => 'frmChangePassword');

        $form[self::FORM_FIELD_FULLNAME] = $user->getFullname();
        $form[self::FORM_FIELD_EMAIL] = $user->getEmail();
        $form[self::FORM_FIELD_USERNAME] = $user->getUsername();

        $form[self::FORM_FIELD_SHOP_TITLE] = $shop->getTitle();
        $form[self::FORM_FIELD_IMAGE_ID] = $shop->getImageId();

        $this->populateForm($form, Array(self::FORM_FIELD_FULLNAME,
                self::FORM_FIELD_EMAIL,
                self::FORM_FIELD_SHOP_TITLE,
                self::FORM_FIELD_URL_SHOP_IMAGE,
                self::FORM_FIELD_USERNAME,
                self::FORM_FIELD_IMAGE_ID));

        $paperclipId = isset($_SESSION[$this->sessionKey]) ? $_SESSION[$this->sessionKey] : NULL;
        if ($paperclipId !== NULL) {
            $form[self::FORM_FIELD_URL_SHOP_IMAGE] = Paperclip_Utils::createUrlThumbnail($paperclipId);
        }
        if ($this->hasError()) {
            $form[FORM_ERROR_MESSAGES] = $this->getErrorMessages();
        } else if ($this->isPostRequest()) {
            $lang = $this->getLanguage();
            $form[FORM_INFO_MESSAGES] = Array($lang->getMessage('msg.updatePassword.done'));
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
        $currentUser->setPassword(md5($newPassword));
        $userDao->updateUser($currentUser);

        return FALSE;
    }
}
