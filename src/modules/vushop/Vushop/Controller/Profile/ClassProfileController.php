<?php
class Vushop_Controller_Profile_ProfileController extends Vushop_Controller_BaseFlowController {

    const VIEW_NAME = 'profile_profile';
    const VIEW_NAME_AFTER_POST = 'profile_profile';

    const FORM_FIELD_FULLNAME = 'fullname';
    const FORM_FIELD_EMAIL = 'email';
    const FORM_FIELD_USERNAME = 'username';

    const FORM_FIELD_SHOP_TITLE = 'shopTitle';
    const FORM_FIELD_IMAGE = 'shopImage';
    const FORM_FIELD_IMAGE_ID = 'shopImageId';
    const FORM_FIELD_URL_SHOP_IMAGE = 'urlShopImage';

    private $sessionKey;

    public function __construct() {
        parent::__construct();
        $this->sessionKey = __CLASS__ . '_fileId';
    }

    /**
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
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {

        $user = $this->getCurrentUser();
        $shopDao = $this->getDao(DAO_SHOP);
        $shop = $shopDao->getShopById($user->getId());

        $form[self::FORM_FIELD_FULLNAME] = $user->getFullname();
        $form[self::FORM_FIELD_EMAIL] = $user->getEmail();
        $form[self::FORM_FIELD_SHOP_TITLE] = $shop->getTitle();
        $form[self::FORM_FIELD_IMAGE_ID] = $shop->getImageId();
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

        if ($this->hasError()) {
            return FALSE;
        }

        $fullname = isset($_POST[self::FORM_FIELD_FULLNAME]) ? trim($_POST[self::FORM_FIELD_FULLNAME]) : '';

        $currentUser->setEmail($email);
        $currentUser->setFullname($fullname);
        $_SESSION[SESSION_USER_ID] = $currentUser->getId();
        $userDao->updateUser($currentUser);

        $shopDao = $this->getDao(DAO_SHOP);
        $shop = $shopDao->getShopById($currentUser->getId());
        $shopName = isset($_POST[self::FORM_FIELD_SHOP_TITLE]) ? trim($_POST[self::FORM_FIELD_SHOP_TITLE]): '';

        // take care of the uploaded file
        $paperclipId = isset($_SESSION[$this->sessionKey]) ? $_SESSION[$this->sessionKey] : NULL;

        $paperclipItem = $this->processUploadFile(self::FORM_FIELD_IMAGE, MAX_UPLOAD_FILESIZE, ALLOWED_UPLOAD_FILE_TYPES, $paperclipId);
        if ($paperclipItem !== NULL) {
              unset($_SESSION[$this->sessionKey]);
            $_SESSION[$this->sessionKey] = $paperclipItem->getId();
        } else {
            $paperclipItem = $paperclipId !== NULL ? $this->getDao(DAO_PAPERCLIP)->getAttachment($paperclipId) : NULL;

        }

        $shop->setTitle($shopName);
        $shop->setImageId($paperclipItem->getId());

        $shopDao->updateShop($shop);


        return FALSE;
    }
}
