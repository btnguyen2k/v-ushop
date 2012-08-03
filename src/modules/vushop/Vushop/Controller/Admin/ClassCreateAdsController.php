<?php
class Vushop_Controller_Admin_CreateAdsController extends Vushop_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_create_ads';
    const VIEW_NAME_AFTER_POST = 'info';
    
    const FORM_FIELD_ADS_TITLE = 'adsTitle';
    const FORM_FIELD_ADS_URL = 'adsUrl';
    const FORM_FIELD_IMAGE_ID = 'adsImageId';
    const FORM_FIELD_URL_IMAGE = 'urlAdsImage';
    const FORM_FIELD_REMOVE_IMAGE = 'removeImage';
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
    
    private $sessionKey;
    
    public function __construct() {
        parent::__construct();
        $this->sessionKey = __CLASS__ . '_fileId';
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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.createAds.done'));
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
        $form = Array('action' => $_SERVER['REQUEST_URI'], 
                'actionCancel' => $this->getUrlAdsManagement(), 
                'name' => 'frmCreateAds');
        $this->populateForm($form, Array(self::FORM_FIELD_ADS_TITLE, 
                self::FORM_FIELD_ADS_URL, 
                self::FORM_FIELD_IMAGE_ID));
        if ($this->hasError()) {
            $form['errorMessages'] = $this->getErrorMessages();
        }
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
        $paperclipItem = $this->processUploadFile(self::FORM_FIELD_IMAGE_ID, MAX_UPLOAD_FILESIZE, ALLOWED_UPLOAD_FILE_TYPES, $paperclipId);
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
         $data = Array(Vushop_Bo_TextAds_BoAds::COL_TITLE=>$title,
                        Vushop_Bo_TextAds_BoAds::COL_URL=>$url,
                         Vushop_Bo_TextAds_BoAds::COL_CLICKS=>0,
                        Vushop_Bo_TextAds_BoAds::COL_IMAGE_ID=>$paperclipItem !== NULL ? $paperclipItem->getId() : NULL);        
        
        
        $ads = new Vushop_Bo_TextAds_BoAds();
        $ads->populate($data);
        $adsDao->createAds($ads);
        
        return TRUE;
    }
}
