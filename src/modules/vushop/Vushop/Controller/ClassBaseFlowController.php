<?php
class Vushop_Controller_BaseFlowController extends Dzit_Controller_FlowController {
    private $errorMessages = Array();
    private $saveUrl = TRUE;
    private $requireAuthentication = FALSE;
    private $allowedUserGroups = NULL;
    private $executionTimestamp;
    private $viewName = NULL;

    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Constructs a new Vushop_Controller_BaseFlowController object.
     */
    public function __construct() {
        $this->executionTimestamp = microtime(TRUE);
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     *
     * @see Dzit_Controller_FlowController::execute()
     */
    public function execute($module, $action) {
        if ($this->saveUrl) {
            $_SESSION[SESSION_LAST_ACCESS_URL] = $_SERVER['REQUEST_URI'];
        }
        if ($this->requireAuthentication && $this->getCurrentUser() === NULL) {
            $url = $this->getUrlLogin();
            $modelAndView = new Dzit_ModelAndView();
            $modelAndView->setView(new Dzit_View_RedirectView($url));
        } else {
            $modelAndView = parent::execute($module, $action);
        }
        return $modelAndView;
    }

    private $baseHref = NULL;
    /**
     * Gets the "baseHref".
     *
     * @return string
     */
    protected function getBaseHref() {
        if ($this->baseHref === NULL) {
            $baseHref = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"];
            $baseHref = preg_replace('/\\/[^\\/]*$/', '/', $baseHref);
            if (defined('SKIN_DIR_BACKEND')) {
                $baseHref .= SKIN_DIR_BACKEND;
            } else {
                $baseHref .= SKIN_DIR_EX;
            }
            $this->baseHref = preg_replace('/\\/+$/', '/', $baseHref);
        }
        return $this->baseHref;
    }

    private $currentCart;
    /**
     * Gets the current cart.
     *
     * @return Vushop_Bo_Cart_BoCart
     */
    protected function getCurrentCart() {
        if ($this->currentCart === NULL) {
            /**
             *
             * @var Vushop_Bo_Cart_ICartDao
             */
            $cartDao = $this->getDao(DAO_CART);
            $sessionId = session_id();
            $cart = $cartDao->getCart($sessionId);
            if ($cart === NULL) {
                $user = $this->getCurrentUser();
                $userId = $user !== NULL ? $user->getId() : 0;
                $cart = $cartDao->createCart($sessionId, $userId);
            }
            $this->currentCart = $cart;
        }
        return $this->currentCart;
    }

    private $currentUser = NULL;
    /**
     * Gets the currently logged in user.
     *
     * @return mixed
     */
    protected function getCurrentUser() {
        if ($this->currentUser === NULL) {
            $userId = isset($_SESSION[SESSION_USER_ID]) ? $_SESSION[SESSION_USER_ID] : NULL;
            $this->currentUser = $this->getDao(DAO_USER)->getUserById($userId);
        }
        return $this->currentUser;
    }

    private $currentUserGroup = NULL;
    protected function getCurrentUserGroup() {
        if ($this->currentUserGroup === NULL) {
            $user = $this->getCurrentUser();
            $this->currentUserGroup = $user !== NULL ? $user->getGroupId() : USER_GROUP_GUEST;
        }
        return $this->currentUserGroup;
    }

    /**
     * Gets the execution timestamp.
     *
     * @return float
     */
    protected function getExecutionTimestamp() {
        return $this->executionTimestamp;
    }

    /**
     * Gets error messages.
     *
     * @return Array
     */
    protected function getErrorMessages() {
        return $this->errorMessages;
    }

    /**
     * Sets the error message.
     *
     * @param string $errorMessage
     */
    protected function setErrorMessage($errorMessage) {
        $this->errorMessages = Array($errorMessage);
    }

    /**
     * Adds an error message.
     *
     * @param string $errorMessage
     */
    protected function addErrorMessage($errorMessage) {
        $this->errorMessages[] = $errorMessage;
    }

    /**
     * Checks if the error message is not empty.
     *
     * @return boolean
     */
    protected function hasError() {
        return count($this->errorMessages) > 0;
    }

    /**
     * Getter for $saveUrl.
     *
     * @return boolean
     */
    protected function getSaveUrl() {
        return $this->saveUrl;
    }

    /**
     * Setter for $saveUrl.
     *
     * @param boolean $value
     */
    public function setSaveUrl($value) {
        $this->saveUrl = $value;
    }

    /**
     * Getter for $requireAuthentication.
     *
     * @return boolean
     */
    protected function getRequireAuthentication() {
        return $this->requireAuthentication;
    }

    /**
     * Setter for $requireAuthentication.
     *
     * @param boolean $value
     */
    public function setRequireAuthentication($value = FALSE) {
        $this->requireAuthentication = $value;
    }

    /**
     * Getter for $allowedUserGroups.
     *
     * @param
     *            Array
     */
    protected function getAllowedUserGroups() {
        return $this->allowedUserGroups;
    }

    /**
     * Setter for $allowedUserGroups.
     *
     * @param Array $value
     */
    public function setAllowedUserGroups($value = Array()) {
        $this->allowedUserGroups = $value;
    }

    /**
     * Gets a DAO object.
     *
     * @param string $name
     * @return Ddth_Dao_IDao
     */
    protected function getDao($name, $config = NULL) {
        return Ddth_Dao_BaseDaoFactory::getInstance($config)->getDao($name);
    }

    /**
     * Gets an application configuration setting.
     *
     * @param mixed $name
     */
    protected function getAppConfig($name) {
        $configDao = $this->getDao(DAO_CONFIG);
        $config = $configDao->loadConfig($name);
        return $config != NULL ? $config->getValue() : NULL;
    }

    /**
     * Gets the {@link Quack_Bo_Site_ISiteDao} instance.
     *
     * @return Quack_Bo_Site_ISiteDao
     */
    protected function getSiteDao() {
        global $DPHP_DAO_CONFIG_SITE;
        return Ddth_Dao_BaseDaoFactory::getInstance($DPHP_DAO_CONFIG_SITE)->getDao(DAO_SITE);
    }

    private $gpvSite = NULL;
    /**
     * Gets the current site.
     *
     * @return Quack_Bo_Site_BoSite.
     */
    protected function getGpvSite() {
        if ($this->gpvSite === NULL) {
            $siteDao = $this->getSiteDao();
            $tokens = explode(":", $_SERVER["HTTP_HOST"]);
            $host = trim($tokens[0]);
            $this->gpvSite = $siteDao->getSiteByDomain($host);
        }
        return $this->gpvSite;
    }

    private $gpvProduct = NULL;
    /**
     * Gets the current product.
     *
     * @return Quack_Bo_Site_BoSiteProduct
     */
    protected function getGpvProduct() {
        if ($this->gpvProduct === NULL) {
            $site = $this->getGpvSite();
            $this->gpvProduct = $site->getProduct(PRODUCT_CODE);
        }
        return $this->gpvProduct;
    }

    /**
     * Gets names of all language packs.
     *
     * @return Array
     */
    protected function getLanguageNames() {
        $mlsFactory = Ddth_Mls_BaseLanguageFactory::getInstance();
        return $mlsFactory->getLanguageNames();
    }

    /**
     * Gets the current language pack.
     *
     * @return Ddth_Mls_ILanguage
     */
    protected function getLanguage() {
        $defaultLanguageName = Dzit_Config::get(Dzit_Config::CONF_DEFAULT_LANGUAGE_NAME);
        $langName = isset($_SESSION[SESSION_LANGUAGE_NAME]) ? $_SESSION[SESSION_LANGUAGE_NAME] : $defaultLanguageName;
        $mlsFactory = Ddth_Mls_BaseLanguageFactory::getInstance();
        $lang = $mlsFactory->getLanguage($langName);
        if ($lang === NULL) {
            $langName = $defaultLanguageName;
        }
        $_SESSION[SESSION_LANGUAGE_NAME] = $langName;
        $lang = $mlsFactory->getLanguage($langName);
        return $lang;
    }

    /**
     * Checks if there is a logged in user.
     *
     * @return boolean
     */
    protected function isLoggedIn() {
        return isset($_SESSION[SESSION_USER_ID]);
    }
    protected function getPageTitle() {
        $siteName = $this->getAppConfig(CONFIG_SITE_NAME);
        $siteTitle = $this->getAppConfig(CONFIG_SITE_TITLE);
        return "$siteName | $siteTitle";
    }
    protected function getPageKeywords() {
        return $this->getAppConfig(DAO_CONFIG);
    }
    protected function getPageDescription() {
        return $this->getAppConfig(DAO_CONFIG);
    }
    protected function getPageCopyright() {
        return $this->getAppConfig(CONFIG_SITE_COPYRIGHT);
    }
    protected function getEmail() {
        return $this->getAppConfig(CONFIG_EMAIL_OUTGOING);
    }
    protected function getNickYahoo() {
        $nick = $this->getAppConfig(CONFIG_EMAIL_OUTGOING);
        if (isset($nick) && $nick != '') {
            $nick = substr($nick, 0, strrpos($nick, "@"));
        }
        return $nick;
    }
    protected function getPageSlogan() {
        return $this->getAppConfig(DAO_CONFIG);
    }

    /**
     * Get the url to access backend section.
     *
     * @return string
     */
    protected function getUrlBackend() {
        return $_SERVER['SCRIPT_NAME'] . '../backend/';
    }

    /**
     * Get the url for login action.
     *
     * @return string
     */
    protected function getUrlLogin() {
        return $_SERVER['SCRIPT_NAME'] . '/login';
    }

    /**
     * Get the url for logout action.
     *
     * @return string
     */
    protected function getUrlLogout() {
        return $_SERVER['SCRIPT_NAME'] . '/logout';
    }

    /**
     * Get the url to access user's profile section.
     *
     * @return string
     */
    protected function getUrlProfile() {
        return $_SERVER['SCRIPT_NAME'] . '/profile';
    }

    /**
     * Get the url to access user's change password section.
     *
     * @return string
     */
    protected function getUrlChangePassword() {
        return $_SERVER['SCRIPT_NAME'] . '/changePassword';
    }

    /**
     * Get the url for member registration action.
     *
     * @return string
     */
    protected function getUrlRegister() {
        return $_SERVER['SCRIPT_NAME'] . '/register';
    }

    /**
     * Gets the url to handle file uploading.
     *
     * @return string
     */
    protected function getUrlUploadHandler() {
        return $_SERVER['SCRIPT_NAME'] . '/paperclip/uploadHandler';
    }

    /**
     * Gets the name of view for {@link getModelAndView()} function.
     *
     * @return string
     */
    protected function getViewName() {
        return $this->viewName;
    }

    /**
     *
     * @see Dzit_Controller_FlowController::getModelAndView()
     */
    protected function getModelAndView() {
        $viewName = $this->getViewName();
        if ($viewName == NULL || $viewName == '') {
            return NULL;
        }
        $model = $this->buildModel();
        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     *
     * @see Dzit_Controller_FlowController::getModelAndView_Login()
     */
    protected function getModelAndView_Login() {
        $url = $this->getUrlLogin();
        $view = new Dzit_View_RedirectView($url);
        return new Dzit_ModelAndView($view, NULL);
    }

    /**
     * Builds the model.
     *
     * @return Array
     */
    protected function buildModel() {
        $model = Array();
        $commonModel = $this->buildModel_Common();
        if ($commonModel !== NULL) {
            // merge common model to the root
            foreach ($commonModel as $key => $value) {
                $model[$key] = $value;
            }
        }

        $modelForm = $this->buildModel_Form();
        if ($modelForm !== NULL) {
            $model['form'] = $modelForm;
        }

        $customModel = $this->buildModel_Custom();
        if ($customModel !== NULL) {
            // merge custom model to the root
            foreach ($customModel as $key => $value) {
                $model[$key] = $value;
            }
        }

        return $model;
    }

    /**
     * Builds "common" model.
     *
     * @param Array $model
     */
    protected function buildModel_Common() {
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::push(__FUNCTION__);
        }
        $model = Array();
        $model[MODEL_REQUEST_MODULE] = $this->getModule();
        $model[MODEL_REQUEST_ACTION] = $this->getAction();
        $model[MODEL_BASE_HREF] = $this->getBaseHref();
        $model[MODEL_PAGE] = $this->buildModel_Page();
        $model[MODEL_LANGUAGE] = $this->getLanguage();

        $user = $this->getCurrentUser();
        $model[MODEL_USER] = Vushop_Model_UserModel::createModelObj($user);

        $model[MODEL_URL_HOME] = $_SERVER['SCRIPT_NAME'];
        $model[MODEL_URL_LOGOUT] = $this->getUrlLogout();
        $model[MODEL_URL_LOGIN] = $this->getUrlLogin();
        $model[MODEL_URL_REGISTER] = $this->getUrlRegister();
        $model[MODEL_URL_UPLOAD_HANDLER] = $this->getUrlUploadHandler();
        $model[MODEL_URL_PROFILE] = $this->getUrlProfile();
        $model[MODEL_URL_CHANGE_PASSWORD] = $this->getUrlChangePassword();
        if ($user !== NULL) {
            if ($user !== NULL && $user->getGroupId() === USER_GROUP_ADMIN) {
                $model[MODEL_URL_BACKEND] = $this->getUrlBackend();
            }
        }

        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::push('getCategoryTree');
        }
        /**
         *
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $catTree = $catalogDao->getCategoryTree();
        $model[MODEL_CATEGORY_TREE] = $catTree;
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::pop();
        }

        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::push('getPages.onMenu');
        }
        /**
         *
         * @var Vushop_Bo_Page_IPageDao
         */
        $pageDao = $this->getDao(DAO_PAGE);
        $onMenuPages = $pageDao->getPages(1, PHP_INT_MAX, Array(
                Quack_Bo_Page_IPageDao::FILTER_ATTRS => Array(PAGE_ATTR_ONMENU)));
        $model[MODEL_ONMENU_PAGES] = Vushop_Model_PageModel::createModelObj($onMenuPages);
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::pop();
        }

        $model[MODEL_CART] = $this->getCurrentCart();

        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::push('getAds');
        }
        // ads
        $adsDao = $this->getDao(DAO_TEXTADS);
        $adsList = $adsDao->getAds();
        $model[MODEL_ADS_LIST] = Vushop_Model_AdsModel::createModelObj($adsList);
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::pop();
        }

        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::push('shop');
        }
        // shop
        $shopDao = $this->getDao(DAO_SHOP);
        $shopOwners = $shopDao->getShops();
        $model[MODEL_SHOP_OWNERS] = Vushop_Model_ShopModel::createModelObj($shopOwners);
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::pop();
        }

        return $model;
    }

    /**
     * Builds custom model.
     * Sub-class overrides this function to build its own custom model.
     *
     * @return Array
     */
    protected function buildModel_Custom() {
        $model = Array();

        $model[MODEL_APP_NAME] = VUSHOP_APP;
        $model[MODEL_APP_VERSION] = VUSHOP_VERSION;

        if (IN_DEV_ENV) {
            $model[MODEL_DEBUG] = new Quack_DebugInfo();
        }

        return $model;
    }

    /**
     * Builds the "form" model.
     *
     * This function returns NULL. Sub-class overrides this function to build
     * its
     * own form model if the page has form.
     *
     * @return Array
     */
    protected function buildModel_Form() {
        return NULL;
    }

    /**
     * Builds the "page" (page title, descrpition, keywords, etc) model.
     *
     * @return Array
     */
    protected function buildModel_Page() {
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::push(__FUNCTION__);
        }
        $pageTitle = $this->getPageTitle();
        $pageKeywords = $this->getPageKeywords();
        $pageDescription = $this->getPageDescription();
        $pageCopyright = $this->getPageCopyright();
        $email = $this->getEmail();
        $nickYahoo = $this->getNickYahoo();
        $pageSlogan = $this->getPageSlogan();

        $modelPage = Array('title' => $pageTitle,
                'keywords' => $pageKeywords,
                'description' => $pageDescription,
                'copyright' => $pageCopyright,
                'email' => $email,
                'nickYahoo' => $nickYahoo,
                'slogan' => $pageSlogan);
        if (defined('PROFILING')) {
            Quack_Util_ProfileUtils::pop();
        }
        return $modelPage;
    }

    /**
     * Populates form with data from $_POST
     *
     * @param Array $form
     * @param Array $fieldNames
     */
    protected function populateForm(&$form, $fieldNames = Array()) {
        if (is_array($fieldNames)) {
            foreach ($fieldNames as $fieldName) {
                if (!isset($form[$fieldName])) {
                    $form[$fieldName] = '';
                }
            }
        }
        if (!$this->isPostRequest() || !is_array($fieldNames)) {
            return;
        }
        foreach ($fieldNames as $fieldName) {
            if (isset($_POST[$fieldName])) {
                $form[$fieldName] = $_POST[$fieldName];
            }
        }
    }
    protected function processUploadFile($formFieldName, $maxFileSize, $allowedFileTypes, $paperclipId = NULL) {
        if (!isset($_FILES[$formFieldName]) || $_FILES[$formFieldName]['error'] === UPLOAD_ERR_NO_FILE) {
            return NULL;
        }
        /**
         *
         * @var Ddth_Mls_ILanguage
         */
        $lang = $this->getLanguage();
        $file = $_FILES[$formFieldName];
        $hasError = FALSE;
        if ($file['error']) {
            $this->addErrorMessage($lang->getMessage('error.uploadError'));
            $hasError = TRUE;
        }
        if ($maxFileSize > 0 && $file['size'] > $maxFileSize) {
            $this->addErrorMessage($lang->getMessage('error.uploadedFileTooLarge', MAX_UPLOAD_FILESIZE . ' b'));
            $hasError = TRUE;
        }
        if (!Commons_Utils_FileUtils::isValidFileExtension($file['name'], $allowedFileTypes)) {
            $this->addErrorMessage($lang->getMessage('error.invalidFileType', $allowedFileTypes));
            $hasError = TRUE;
        }
        if (!$hasError) {
            $thumbnail = Commons_Utils_ImageUtils::createThumbnailJpeg($file['tmp_name'], THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT);
            if ($thumbnail === NULL) {
                $this->addErrorMessage($lang->getMessage('error.invalidImageFile'));
            } else {
                // taking care of the filename
                $pathinfo = pathinfo($file['name']);
                if (!isset($pathinfo['extension'])) {
                    $pathinfo['extension'] = '';
                }
                $filename = str_replace('.', '_', uniqid('', TRUE));
                if (strlen($pathinfo['extension']) > 0 && strlen($pathinfo['extension']) < 5) {
                    $filename = $filename . '.' . $pathinfo['extension'];
                }

                /**
                 *
                 * @var Paperclip_Bo_IPaperclipDao
                 */
                $paperclipDao = $this->getDao(DAO_PAPERCLIP);
                /**
                 *
                 * @var Paperclip_Bo_BoPaperclip
                 */
                $paperclipItem = $paperclipId !== NULL ? $paperclipDao->getAttachment($paperclipId) : NULL;
                if ($paperclipItem === NULL) {
                    $paperclipItem = $paperclipDao->createAttachment($file['tmp_name'], $filename, $file['type'], TRUE, $thumbnail);
                } else {
                    $filecontent = Commons_Utils_FileUtils::getFileContent($file['tmp_name']);
                    $imgSource = Commons_Utils_ImageUtils::createImageSource($file['tmp_name']);
                    $paperclipItem->setTimestamp(time());
                    $paperclipItem->setFilecontent($filecontent);
                    $paperclipItem->setFilename($filename);
                    $paperclipItem->setFilesize($file['size']);
                    $paperclipItem->setImgWidth($imgSource[0]);
                    $paperclipItem->setImgHeight($imgSource[1]);
                    $paperclipItem->setMimetype($file['type']);
                    $paperclipItem->setThumbnail($thumbnail);
                    $paperclipDao->updateAttachment($paperclipItem);
                }
                return $paperclipItem;
            }
        }
        return NULL;
    }

    /**
     *
     * @see Dzit_Controller_FlowController::validateAuthentication()
     *
     */
    protected function validateAuthentication() {
        return !$this->requireAuthentication || $this->isLoggedIn();
    }

    /**
     *
     * @see Dzit_Controller_FlowController::validateAuthorization()
     */
    protected function validateAuthorization() {
        $allowedGroups = $this->allowedUserGroups;
        if ($allowedGroups == NULL || (is_array($allowedGroups) && count($allowedGroups) == 0)) {
            // no allowed groups defined!
            return TRUE;
        }
        return TRUE;
    }
}
