<?php
class Vushop_Controller_ProfileCp_ProfileController extends Vushop_Controller_BaseFlowController {
    
    const VIEW_NAME = 'profilecp_profile';
    const VIEW_NAME_AFTER_POST = 'profilecp_profile';
    
    const FORM_FIELD_FULLNAME = 'fullname';
    const FORM_FIELD_EMAIL = 'email';
    const FORM_FIELD_SHOP_TITLE = 'shopTitle';
    const FORM_FIELD_IMAGE = 'shopImage';
    const FORM_FIELD_IMAGE_ID = 'shopImageId';
    const FORM_FIELD_URL_SHOP_IMAGE = 'urlShopImage';
    const FORM_FIELD_REMOVE_IMAGE = 'removeImage';
    
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
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmProfile');
        $user = $this->getCurrentUser();
        $shopDao = $this->getDao(DAO_SHOP);
        $shop = $shopDao->getShopById($user->getId());
        
        $form[self::FORM_FIELD_FULLNAME] = $user->getFullname();
        $form[self::FORM_FIELD_EMAIL] = $user->getEmail();
        $form[self::FORM_FIELD_SHOP_TITLE] = $shop->getTitle();
        $form[self::FORM_FIELD_IMAGE_ID] = $shop->getImageId();
        if ($shop->getImageId() > 0) {
            $form[self::FORM_FIELD_URL_SHOP_IMAGE] = Paperclip_Utils::createUrlThumbnail($shop->getImageId());
        }
        $this->populateForm($form, Array(self::FORM_FIELD_FULLNAME, 
                self::FORM_FIELD_EMAIL, 
                self::FORM_FIELD_SHOP_TITLE, 
                self::FORM_FIELD_URL_SHOP_IMAGE, 
                self::FORM_FIELD_IMAGE_ID));
        
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
        $shopName = isset($_POST[self::FORM_FIELD_SHOP_TITLE]) ? strtolower(trim($_POST[self::FORM_FIELD_SHOP_TITLE])) : '';
        
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
        
        $shop->setTitle($shopName);
        $shop->setImageId($paperclipItem->getId());
        
        $shopDao->updateShop($shop);
        
        return FALSE;
    }
}
