<?php
class Vcatalog_Controller_Admin_EditCategoryController extends Vcatalog_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_edit_category';
    const VIEW_NAME_AFTER_POST = 'info';
    const VIEW_NAME_ERROR = 'error';

    const FORM_FIELD_PARENT_ID = 'parentId';
    const FORM_FIELD_CATEGORY_TITLE = 'categoryTitle';
    const FORM_FIELD_CATEGORY_DESCRIPTION = 'categoryDescription';
    const FORM_FIELD_CATEGORY_IMAGE = 'categoryImage';
    const FORM_FIELD_CATEGORY_IMAGE_ID = 'categoryImageId';
    const FORM_FIELD_URL_CATEGORY_IMAGE = 'urlCategoryImage';
    const FORM_FIELD_REMOVE_IMAGE = 'removeImage';

    /**
     *
     * @var Vcatalog_Bo_Catalog_BoCategory
     */
    private $category = NULL;
    private $categoryId;

    private $sessionKey;

    public function __construct() {
        parent::__construct();
        $this->sessionKey = __CLASS__ . '_fileId';
    }

    /**
     *
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * Populates categoryId and category instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         *
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $this->categoryId = (int)$requestParser->getPathInfoParam(1);
        /**
         *
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $this->category = $catalogDao->getCategoryById($this->categoryId);
        if ($this->category != NULL) {
            $children = $catalogDao->getCategoryChildren($this->category);
            $this->category->setChildren($children);
            $_SESSION[$this->sessionKey] = $this->category->getImageId();
        }
    }

    /**
     * Test if the category to be edited is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $cat = $this->category;
        $catId = $this->categoryId;
        if ($cat === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.categoryNotFound', $catId));
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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.editCategory.done'));
        $urlTransit = $this->getUrlCategoryManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     *
     * @see Vcatalog_Controller_Admin_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model == NULL) {
            $model = Array();
        }
        if ($this->category != NULL && count($this->category->getChildren()) == 0) {
            /**
             *
             * @var Vcatalog_Bo_Catalog_ICatalogDao
             */
            $catalogDao = $this->getDao(DAO_CATALOG);
            $catTree = $catalogDao->getCategoryTree();
            $catList = Array();
            foreach ($catTree as $cat) {
                if ($cat->getId() !== $this->category->getId()) {
                    $catList[] = $cat;
                }
            }
            $model[MODEL_CATEGORY_TREE] = $catList;
        }
        return $model;
    }

    /**
     *
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        if ($this->category === NULL) {
            return NULL;
        }
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $this->getUrlCategoryManagement(),
                'name' => 'frmEditCategory');

        $form[self::FORM_FIELD_PARENT_ID] = $this->category->getParentId();
        $form[self::FORM_FIELD_CATEGORY_TITLE] = $this->category->getTitle();
        $form[self::FORM_FIELD_CATEGORY_DESCRIPTION] = $this->category->getDescription();
        $form[self::FORM_FIELD_CATEGORY_IMAGE_ID] = $this->category->getImageId();

        $this->populateForm($form, Array(self::FORM_FIELD_CATEGORY_DESCRIPTION,
                self::FORM_FIELD_CATEGORY_TITLE,
                self::FORM_FIELD_PARENT_ID,
                self::FORM_FIELD_CATEGORY_IMAGE_ID));
        $paperclipId = isset($_SESSION[$this->sessionKey]) ? $_SESSION[$this->sessionKey] : NULL;
        if ($paperclipId !== NULL) {
            $form[self::FORM_FIELD_URL_CATEGORY_IMAGE] = Paperclip_Utils::createUrlThumbnail($paperclipId);
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
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);

        $parentId = isset($_POST[self::FORM_FIELD_PARENT_ID]) ? (int)$_POST[self::FORM_FIELD_PARENT_ID] : 0;
        if ($parentId > 0) {
            /**
             *
             * @var Vcatalog_Bo_Catalog_ICatalogDao
             */
            $parentCat = $catalogDao->getCategoryById($parentId);
            if ($parentCat == NULL || ($parentCat->getParentId() != NULL && $parentCat->getParentId() != 0) || $parentId == $this->categoryId) {
                // currently we limit category hierarchy at 2 levels
                $this->addErrorMessage($lang->getMessage('error.invalidParentCategory'));
            }
        }

        $title = isset($_POST[self::FORM_FIELD_CATEGORY_TITLE]) ? trim($_POST[self::FORM_FIELD_CATEGORY_TITLE]) : '';
        if ($title == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyCategoryTitle'));
        }

        // take care of the uploaded file
        $removeImage = isset($_POST[self::FORM_FIELD_REMOVE_IMAGE]) ? TRUE : FALSE;
        $paperclipId = isset($_SESSION[$this->sessionKey]) ? $_SESSION[$this->sessionKey] : NULL;
        $paperclipItem = $this->processUploadFile(self::FORM_FIELD_CATEGORY_IMAGE, MAX_UPLOAD_FILESIZE, ALLOWED_UPLOAD_FILE_TYPES, $paperclipId);
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
        // if ($paperclipItem !== NULL) {
        // $_SESSION[$this->sessionKey] = $paperclipItem->getId();
        // } else {
        // $paperclipItem = $paperclipId !== NULL ?
        // $this->getDao(DAO_PAPERCLIP)->getAttachment($paperclipId) : NULL;
        // }

        if ($this->hasError()) {
            return FALSE;
        }

        if ($parentId < 1) {
            $parentId = NULL;
        }
        $this->category->setParentId($parentId);
        $this->category->setTitle($title);
        $desc = isset($_POST[self::FORM_FIELD_CATEGORY_DESCRIPTION]) ? $_POST[self::FORM_FIELD_CATEGORY_DESCRIPTION] : '';
        $this->category->setDescription($desc);
        if ($paperclipItem !== NULL) {
            $this->category->setImageId($paperclipItem->getId());
        }
        $catalogDao->updateCategory($this->category);

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
