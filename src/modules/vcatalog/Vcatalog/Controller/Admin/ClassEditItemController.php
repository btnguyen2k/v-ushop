<?php
class Vcatalog_Controller_Admin_EditItemController extends Vcatalog_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'admin_editItem';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';

    const FORM_FIELD_CATEGORY_ID = 'categoryId';
    const FORM_FIELD_TITLE = 'itemTitle';
    const FORM_FIELD_DESCRIPTION = 'itemDescription';
    const FORM_FIELD_VENDOR = 'itemVendor';
    const FORM_FIELD_PRICE = 'itemPrice';

    /**
     * @var Vcatalog_Bo_Catalog_BoItem
     */
    private $item = NULL;
    private $itemId;

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
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
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->itemId = $requestParser->getPathInfoParam(2);
        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $this->item = $catalogDao->getItemById($this->itemId);
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
        $urlTransit = $this->getUrlItemManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        if ($this->item === NULL) {
            return NULL;
        }
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $this->getUrlItemManagement(),
                'name' => 'frmEditItem');

        $form[self::FORM_FIELD_CATEGORY_ID] = $this->item->getCategoryId();
        $form[self::FORM_FIELD_DESCRIPTION] = $this->item->getDescription();
        $form[self::FORM_FIELD_PRICE] = $this->item->getPrice();
        $form[self::FORM_FIELD_TITLE] = $this->item->getTitle();
        $form[self::FORM_FIELD_VENDOR] = $this->item->getVendor();

        $this->populateForm($form, Array(self::FORM_FIELD_CATEGORY_ID,
                self::FORM_FIELD_DESCRIPTION,
                self::FORM_FIELD_PRICE,
                self::FORM_FIELD_TITLE,
                self::FORM_FIELD_VENDOR));
        if ($this->hasError()) {
            $form['errorMessages'] = $this->getErrorMessages();
        }
        return $form;
    }

    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        /**
         * @var Ddth_Mls_ILanguage
         */
        $lang = $this->getLanguage();

        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);

        $categoryId = isset($_POST[self::FORM_FIELD_CATEGORY_ID]) ? (int)$_POST[self::FORM_FIELD_CATEGORY_ID] : 0;
        $title = isset($_POST[self::FORM_FIELD_TITLE]) ? trim($_POST[self::FORM_FIELD_TITLE]) : '';
        $description = isset($_POST[self::FORM_FIELD_DESCRIPTION]) ? trim($_POST[self::FORM_FIELD_DESCRIPTION]) : '';
        $vendor = isset($_POST[self::FORM_FIELD_VENDOR]) ? trim($_POST[self::FORM_FIELD_VENDOR]) : '';
        $price = isset($_POST[self::FORM_FIELD_PRICE]) ? (double)$_POST[self::FORM_FIELD_PRICE] : 0.0;

        if ($categoryId < 1) {
            $categoryId = NULL;
        } else {
            $cat = $catalogDao->getCategoryById($categoryId);
            if ($cat == NULL) {
                $this->addErrorMessage($lang->getMessage('error.categoryNotFound', $categoryId));
            }
        }

        if ($title == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyItemTitle'));
        }

        if ($this->hasError()) {
            return FALSE;
        }

        $this->item->setCategoryId($categoryId);
        $this->item->setTitle($title);
        $this->item->setDescription($description);
        $this->item->setVendor($vendor);
        $this->item->setPrice($price);

        $catalogDao->updateItem($this->item);

        return TRUE;
    }
}
