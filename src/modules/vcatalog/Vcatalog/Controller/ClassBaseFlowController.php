<?php
class Vcatalog_Controller_BaseFlowController extends Dzit_Controller_FlowController {

    private $errorMessages = Array();
    private $saveUrl = TRUE;
    private $requireAuthentication = FALSE;
    private $allowedUserGroups = NULL;
    private $executionTimestamp;

    private $viewName = NULL;

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Constructs a new Vcatalog_Controller_BaseFlowController object.
     */
    public function __construct() {
        $this->executionTimestamp = microtime(TRUE);
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     * Gets the "baseHref".
     *
     * @return string
     */
    protected function getBaseHref() {
        $baseHref = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"];
        $baseHref = preg_replace('/\\/[^\\/]*$/', '/', $baseHref);
        $baseHref .= SKIN_DIR;
        $baseHref = preg_replace('/\\/+$/', '/', $baseHref);
        return $baseHref;
    }

    /**
     * Gets the currently logged in user.
     *
     * @return mixed
     */
    protected function getCurrentUser() {
        //because we store the user email in session, NOT the user ID
        $userEmail = isset($_SESSION[SESSION_USER_ID]) ? $_SESSION[SESSION_USER_ID] : 0;
        return $this->getDao(DAO_USER)->getUserByEmail($userEmail);
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
        $this->errorMessages = Array(
                $errorMessage);
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
     * @param Array
     */
    public function getAllowedUserGroups() {
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
     * @return Ddth_dao_IDao
     */
    protected function getDao($name) {
        return Ddth_Dao_BaseDaoFactory::getInstance()->getDao($name);
    }

    /**
     * Gets names of all language packs.
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
        $dao = $this->getDao(DAO_CONFIG);
        $siteName = $dao->loadConfig(CONFIG_SITE_NAME);
        $siteTitle = $dao->loadConfig(CONFIG_SITE_TITLE);
        return "$siteName | $siteTitle";
    }

    protected function getPageKeywords() {
        $dao = $this->getDao(DAO_CONFIG);
        $siteKeywords = $dao->loadConfig(CONFIG_SITE_KEYWORDS);
        return $siteKeywords;
    }

    protected function getPageDescription() {
        $dao = $this->getDao(DAO_CONFIG);
        $siteDesc = $dao->loadConfig(CONFIG_SITE_DESCRIPTION);
        return $siteDesc;
    }

    protected function getPageCopyright() {
        $dao = $this->getDao(DAO_CONFIG);
        $siteCopyright = $dao->loadConfig(CONFIG_SITE_COPYRIGHT);
        return $siteCopyright;
    }

    protected function getPageSlogan() {
        $dao = $this->getDao(DAO_CONFIG);
        $siteSlogan = $dao->loadConfig(CONFIG_SITE_SLOGAN);
        return $siteSlogan;
    }

    /**
     * Get the url to access AdminCP.
     *
     * @return string
     */
    protected function getUrlAdmin() {
        return $_SERVER['SCRIPT_NAME'] . '/admin';
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
     * Get the url for member registration action.
     *
     * @return string
     */
    protected function getUrlRegister() {
        return $_SERVER['SCRIPT_NAME'] . '/register';
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
     * @see Dzit_Controller_FlowController::getModelAndView()
     */
    protected function getModelAndView() {
        $viewName = $this->getViewName();
        if ($viewName == NULL || $viewName == '') {
            return NULL;
        }
        $model = $this->buildModel();
        return new Dzit_ModelAndView(
                $viewName, $model);
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
            //merge common model to the root
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
            //merge custom model to the root
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
        $model = Array();
        $model['basehref'] = $this->getBaseHref();
        $model['page'] = $this->buildModel_Page();
        $model['language'] = $this->getLanguage();
        $model['urlHome'] = $_SERVER['SCRIPT_NAME'];
        if (isset($_SESSION[SESSION_USER_ID])) {
            $model['urlLogout'] = $this->getUrlLogout();
            $user = $this->getCurrentUser();
            if ($user !== NULL && $user['groupId'] === USER_GROUP_ADMIN) {
                $model['urlAdmin'] = $this->getUrlAdmin();
            }
        } else {
            $model['urlLogin'] = $this->getUrlLogin();
            $model['urlRegister'] = $this->getUrlRegister();
        }
        return $model;
    }

    /**
     * Builds custom model. Sub-class overrides this function to build its own custom model.
     *
     * @return Array
     */
    protected function buildModel_Custom() {
        return NULL;
    }

    /**
     * Builds the "form" model.
     *
     * This function returns NULL. Sub-class overrides this function to build its
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
        $pageTitle = $this->getPageTitle();
        $pageKeywords = $this->getPageKeywords();
        $pageDescription = $this->getPageDescription();
        $pageCopyright = $this->getPageCopyright();
        $pageSlogan = $this->getPageSlogan();

        $modelPage = Array(
                'title' => $pageTitle,
                'keywords' => $pageKeywords,
                'description' => $pageDescription,
                'copyright' => $pageCopyright,
                'slogan' => $pageSlogan);

        return $modelPage;
    }

    /**
     * Populates form with data from $_POST
     *
     * @param Array $form
     * @param Array $fieldNames
     */
    protected function populateForm(&$form, $fieldNames = Array()) {
        if (!$this->isPostRequest() || !is_array($fieldNames)) {
            return;
        }
        foreach ($fieldNames as $fieldName) {
            if (isset($_POST[$fieldName])) {
                $form[$fieldName] = $_POST[$fieldName];
            }
        }
    }

    /**
     * @see Dzit_Controller_FlowController::validateAuthentication()
     *
     */
    protected function validateAuthentication() {
        return !$this->requireAuthentication || $this->isLoggedIn();
    }

    /**
     * @see Dzit_Controller_FlowController::validateAuthorization()
     */
    protected function validateAuthorization() {
        $allowedGroups = $this->allowedUserGroups;
        if ($allowedGroups == NULL || (is_array($allowedGroups) && count($allowedGroups) == 0)) {
            //no allowed groups defined!
            return TRUE;
        }
        return TRUE;
    }
}
