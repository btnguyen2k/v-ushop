<?php
class Vushop_Controller_Admin_EditAdsController extends Vushop_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_edit_ads';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';
    
    const FORM_FIELD_ADS_TITLE = 'adsTitle';
    const FORM_FIELD_ADS_URL = 'adsUrl';
    const FORM_FIELD_IMAGE = 'adsImage';
    const FORM_FIELD_IMAGE_ID = 'adsImageId';
    const FORM_FIELD_URL_IMAGE = 'urlAdsImage';
    const FORM_FIELD_REMOVE_IMAGE = 'removeImage';
    
    /**
     *
     * @var Vushop_Bo_TextAds_BoAds
     */
    private $ads = NULL;
    private $adsId;
    
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
    
    /**
     * Populates adsId and ads instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         *
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->adsId = $requestParser->getPathInfoParam(1);
        /**
         *
         * @var Vushop_Bo_TextAds_IAdsDao
         */
        $adsDao = $this->getDao(DAO_TEXTADS);
        $this->ads = $adsDao->getAdsById($this->adsId);
        if ($this->ads !== NULL) {
            $r = md5($this->ads->getImageId());
            $this->sessionKey .= $r;
            $_SESSION[$this->sessionKey] = $this->ads->getImageId();
        }
    }
    
    /**
     * Test if the ads to be edited is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $ads = $this->ads;
        $adsId = $this->adsId;
        if ($ads === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.adsNotFound', htmlspecialchars($adsId)));
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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.editAds.done'));
        $urlTransit = $this->getUrlAdsManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);
        
        return new Dzit_ModelAndView($viewName, $model);
    }
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        if ($this->ads === NULL) {
            return NULL;
        }
        $form = Array('action' => $_SERVER['REQUEST_URI'], 
                'actionCancel' => $this->getUrlAdsManagement(), 
                'name' => 'frmEditAds');
        
        $form[self::FORM_FIELD_ADS_TITLE] = $this->ads->getTitle();
        $form[self::FORM_FIELD_ADS_URL] = $this->ads->getUrl();
        $form[self::FORM_FIELD_IMAGE_ID] = md5($this->ads->getImageId());
        
        $this->populateForm($form, Array(self::FORM_FIELD_ADS_TITLE, 
                self::FORM_FIELD_IMAGE_ID, 
                self::FORM_FIELD_ADS_URL));
        
        $paperclipId = isset($_SESSION[$this->sessionKey]) ? $_SESSION[$this->sessionKey] : NULL;
        if ($paperclipId !== NULL) {
            $form[self::FORM_FIELD_URL_IMAGE] = Paperclip_Utils::createUrlThumbnail($paperclipId);
        }
        
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
         * @var Vushop_Bo_TextAds_IAdsDao
         */
        $adsDao = $this->getDao(DAO_TEXTADS);
        
        $title = isset($_POST[self::FORM_FIELD_ADS_TITLE]) ? trim($_POST[self::FORM_FIELD_ADS_TITLE]) : '';
        if ($title == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyAdsTitle'));
        }
        
        $url = isset($_POST[self::FORM_FIELD_ADS_URL]) ? trim($_POST[self::FORM_FIELD_ADS_URL]) : '';
        if ($url == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyAdsUrl'));
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
        
        $this->ads->setTitle($title);
        $this->ads->setUrl($url);
        if ($paperclipItem !== NULL) {
            $this->ads->setImageId($paperclipItem->getId());
        }
        $adsDao->updateAds($this->ads);
        
     // clean-up
        unset($_SESSION[$this->sessionKey]);
        if ($paperclipItem !== NULL) {
            $paperclipItem->setIsDraft(FALSE);
            $paperclipDao = $this->getDao(DAO_PAPERCLIP);
            $paperclipDao->updateAttachment($paperclipItem);
        }
        
        return TRUE;
    }
}
