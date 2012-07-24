<?php
class Vushop_Controller_Admin_CreateCategoryController extends Vushop_Controller_Admin_BaseFlowController {
    const VIEW_NAME = 'inline_create_category';
    const VIEW_NAME_AFTER_POST = 'info';

    const FORM_FIELD_PARENT_ID = 'parentId';
    const FORM_FIELD_TITLE = 'categoryTitle';
    const FORM_FIELD_DESCRIPTION = 'categoryDescription';
    const FORM_FIELD_IMAGE = 'categoryImage';
    const FORM_FIELD_IMAGE_ID = 'categoryImageId';
    const FORM_FIELD_URL_CATEGORY_IMAGE = 'urlCategoryImage';
    const FORM_FIELD_REMOVE_IMAGE = 'removeImage';

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
        $model[MODEL_INFO_MESSAGES] = Array($lang->getMessage('msg.createCategory.done'));
        $urlTransit = $this->getUrlCategoryManagement();
        $model[MODEL_URL_TRANSIT] = $urlTransit;
        $model[MODEL_TRANSIT_MESSAGE] = $lang->getMessage('msg.transit', $urlTransit);

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     *
     * @see Vushop_Controller_Admin_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model == NULL) {
            $model = Array();
        }
        /**
         *
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $catTree = $catalogDao->getCategoryTree();
        $model[MODEL_CATEGORY_TREE] = $catTree;
        // $model[MODEL_CATEGORY_TREE] = Array();
        // foreach ($catTree as $cat) {
        // $model[MODEL_CATEGORY_TREE][] = $cat;
        // }
        return $model;
    }

    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'],
                'actionCancel' => $this->getUrlCategoryManagement(),
                'name' => 'frmCreateCategory');
        $this->populateForm($form, Array(self::FORM_FIELD_DESCRIPTION,
                self::FORM_FIELD_TITLE,
                self::FORM_FIELD_PARENT_ID,
                self::FORM_FIELD_IMAGE_ID));
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
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);

        $parentId = isset($_POST[self::FORM_FIELD_PARENT_ID]) ? (int)$_POST[self::FORM_FIELD_PARENT_ID] : 0;
        if ($parentId > 0) {
            /**
             *
             * @var Vushop_Bo_Catalog_ICatalogDao
             */
            $catalogDao = $this->getDao(DAO_CATALOG);
            $cat = $catalogDao->getCategoryById($parentId);
            if ($cat === NULL || ($cat->getParentId() !== NULL && $cat->getParentId() !== 0)) {
                $this->addErrorMessage($lang->getMessage('error.invalidParentCategory'));
            }
        }

        $title = isset($_POST[self::FORM_FIELD_TITLE]) ? trim($_POST[self::FORM_FIELD_TITLE]) : '';
        if ($title == '') {
            $this->addErrorMessage($lang->getMessage('error.emptyCategoryTitle'));
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

        $position = time();
        if ($parentId < 1) {
            $parentId = NULL;
        }
        $desc = isset($_POST[self::FORM_FIELD_DESCRIPTION]) ? trim($_POST[self::FORM_FIELD_DESCRIPTION]) : '';
        $category = new Vushop_Bo_Catalog_BoCategory();
        $category->setPosition($position);
        $category->setParentId($parentId);
        $category->setTitle($title);
        $category->setDescription($desc);
        $category->setImageId($paperclipItem !== NULL ? $paperclipItem->getId() : NULL);
        $catalogDao->createCategory($category);

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
