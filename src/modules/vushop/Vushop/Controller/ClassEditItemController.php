<?php
class Vushop_Controller_EditItemController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'edit_item';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';
    
    const FORM_FIELD_CATEGORY_ID = 'categoryId';
    const FORM_FIELD_TITLE = 'itemTitle';
    const FORM_FIELD_DESCRIPTION = 'itemDescription';
    const FORM_FIELD_VENDOR = 'itemVendor';
    const FORM_FIELD_CODE = 'itemCode';
    const FORM_FIELD_PRICE = 'itemPrice';
    const FORM_FIELD_OLD_PRICE = 'itemOldPrice';
    const FORM_FIELD_IMAGE = 'itemImage';
    const FORM_FIELD_HOT = 'itemHot';
    const FORM_FIELD_NEW = 'itemNew';
    const FORM_FIELD_IMAGE_ID = 'itemImageId';
    const FORM_FIELD_URL_IMAGE = 'urlItemImage';
    const FORM_FIELD_REMOVE_IMAGE = 'removeImage';
    
    /**
     *
     * @var Vushop_Bo_Catalog_BoItem
     */
    private $item = NULL;
    private $itemId;
    
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
     * Populates itemId and item instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         *
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->itemId = $requestParser->getPathInfoParam(1);
        /**
         *
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $this->item = $catalogDao->getItemById($this->itemId);
        if ($this->item !== NULL) {
            $r = md5($this->item->getImageId());
            $this->sessionKey .= $r;
            $_SESSION[$this->sessionKey] = $this->item->getImageId();
        }
    }
    
    /**
     * Test if the item to be edited is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $item = $this->item;
        $itemId = $this->itemId;
        if ($item === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.itemNotFound', (int)$itemId));
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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.editItem.done'));
        $urlTransit = $this->getUrlMyItems();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);
        
        return new Dzit_ModelAndView($viewName, $model);
    }
    
    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        if ($this->item === NULL) {
            return NULL;
        }
        $form = Array('action' => $_SERVER['REQUEST_URI'], 
                'actionCancel' => $this->getUrlMyItems(), 
                'name' => 'frmEditItem');
        
        $form[self::FORM_FIELD_CATEGORY_ID] = $this->item->getCategoryId();
        $form[self::FORM_FIELD_DESCRIPTION] = $this->item->getDescription();
        $form[self::FORM_FIELD_PRICE] = $this->item->getPrice();
        $form[self::FORM_FIELD_OLD_PRICE] = $this->item->getOldPrice();
        $form[self::FORM_FIELD_TITLE] = $this->item->getTitle();
        $form[self::FORM_FIELD_VENDOR] = $this->item->getVendor();
        $form[self::FORM_FIELD_CODE] = $this->item->getCode();
        $form[self::FORM_FIELD_IMAGE_ID] = md5($this->item->getImageId());
        
        $this->populateForm($form, Array(self::FORM_FIELD_CATEGORY_ID, 
                self::FORM_FIELD_DESCRIPTION, 
                self::FORM_FIELD_PRICE, 
                self::FORM_FIELD_OLD_PRICE, 
                self::FORM_FIELD_TITLE, 
                self::FORM_FIELD_VENDOR, 
                self::FORM_FIELD_CODE, 
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
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        
        $categoryId = isset($_POST[self::FORM_FIELD_CATEGORY_ID]) ? (int)$_POST[self::FORM_FIELD_CATEGORY_ID] : 0;
        $title = isset($_POST[self::FORM_FIELD_TITLE]) ? trim($_POST[self::FORM_FIELD_TITLE]) : '';
        $description = isset($_POST[self::FORM_FIELD_DESCRIPTION]) ? trim($_POST[self::FORM_FIELD_DESCRIPTION]) : '';
        $vendor = isset($_POST[self::FORM_FIELD_VENDOR]) ? trim($_POST[self::FORM_FIELD_VENDOR]) : '';
        $code = isset($_POST[self::FORM_FIELD_CODE]) ? trim($_POST[self::FORM_FIELD_CODE]) : '';
        $price = isset($_POST[self::FORM_FIELD_PRICE]) ? (double)$_POST[self::FORM_FIELD_PRICE] : 0.0;
        $oldPrice = isset($_POST[self::FORM_FIELD_OLD_PRICE]) ? (double)$_POST[self::FORM_FIELD_OLD_PRICE] : 0.0;
        
        if ($categoryId < 1) {
            $categoryId = 0;
        } else {
            $cat = $catalogDao->getCategoryById($categoryId);
            if ($cat == NULL) {
                $this->addErrorMessage($lang->getMessage('error.categoryNotFound', $categoryId));
            }
        }
        
        if ($title == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyItemTitle'));
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
        
        $this->item->setCategoryId($categoryId);
        $this->item->setTitle($title);
        $this->item->setDescription($description);
        $this->item->setVendor($vendor);
        $this->item->setCode($code);
        $this->item->setPrice($price);
         $this->item->setOldPrice($oldPrice);
        if ($paperclipItem !== NULL) {
            $this->item->setImageId($paperclipItem->getId());
        }
        $catalogDao->updateItem($this->item);
        
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
