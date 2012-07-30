<?php
abstract class Vushop_Controller_Profile_BaseProfileController extends Vushop_Controller_BaseFlowController {

    const VIEW_NAME = 'profile_profile';
    const VIEW_NAME_AFTER_POST = 'profile_profile';

    const FORM_FIELD_FULLNAME = 'fullname';
    const FORM_FIELD_EMAIL = 'email';
    const FORM_FIELD_USERNAME = 'username';
    const FORM_FIELD_SHOP_TITLE = 'shopTitle';
    const FORM_FIELD_IMAGE = 'shopImage';
    const FORM_FIELD_IMAGE_ID = 'shopImageId';
    const FORM_FIELD_URL_IMAGE = 'urlShopImage';
    const FORM_FIELD_REMOVE_IMAGE = 'removeImage';
    const FORM_FIELD_CURRENT_PASSWORD = 'currentPassword';
    const FORM_FIELD_NEW_PASSWORD = 'newPassword';
    const FORM_FIELD_CONFIRMED_NEW_PASSWORD = 'confirmedNewPassword';

    /**
     *
     * @var string
     */
    protected $sessionKey;

    /**
     *
     * @var Vushop_Bo_Shop_BoShop
     */
    protected $shop;

    public function __construct() {
        parent::__construct();
        $this->sessionKey = __CLASS__ . '_fileId';
    }

    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        $shopDao = $this->getDao(DAO_SHOP);
        $this->shop = $shopDao->getShopById($this->getCurrentUser()->getId());
        if ($this->shop !== NULL) {
            $r = md5($this->shop->getImageId());
            $this->sessionKey .= $r;
            $_SESSION[$this->sessionKey] = $this->shop->getImageId();
        }
    }

    /**
     * (non-PHPdoc)
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
     * (non-PHPdoc)
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $user = $this->getCurrentUser();

        $form = Array('name' => 'frmProfile');

        $form[self::FORM_FIELD_FULLNAME] = $user->getFullname();
        $form[self::FORM_FIELD_EMAIL] = $user->getEmail();
        $form[self::FORM_FIELD_USERNAME] = $user->getUsername();

        $form[self::FORM_FIELD_SHOP_TITLE] = $this->shop->getTitle();
        $form[self::FORM_FIELD_IMAGE_ID] = md5($this->shop->getImageId());

        $this->populateForm($form, Array(self::FORM_FIELD_FULLNAME,
                self::FORM_FIELD_EMAIL,
                self::FORM_FIELD_USERNAME,
                self::FORM_FIELD_SHOP_TITLE,
                self::FORM_FIELD_IMAGE_ID));
        $paperclipId = isset($_SESSION[$this->sessionKey]) ? $_SESSION[$this->sessionKey] : NULL;
        if ($paperclipId !== NULL) {
            $form[self::FORM_FIELD_URL_IMAGE] = Paperclip_Utils::createUrlThumbnail($paperclipId);
        }
        if ($this->hasError()) {
            $form['errorMessages'] = $this->getErrorMessages();
        }
        return $form;
    }
}
