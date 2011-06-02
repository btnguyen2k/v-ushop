<?php
abstract class Vlistings_Controller_BaseController implements Dzit_IController {

    private $module, $action;

    private $hasError = FALSE;

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog('Vlistings_Controller_BaseController');
    }

    /**
     * Gets the currently requested module.
     * @return string
     */
    protected function getModule() {
        return $this->module;
    }

    /**
     * Gets the currently requested action.
     * @return string
     */
    protected function getAction() {
        return $this->action;
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
        $langName = isset($_SESSION['language']) ? $_SESSION['language'] : $defaultLanguageName;
        $mlsFactory = Ddth_Mls_BaseLanguageFactory::getInstance();
        $lang = $mlsFactory->getLanguage($langName);
        if ($lang === NULL) {
            $langName = $defaultLanguageName;
        }
        $_SESSION['language'] = $langName;
        $lang = $mlsFactory->getLanguage($langName);
        return $lang;
    }

    /**
     * Gets non-POST view name.
     * @return string
     */
    protected abstract function getViewName();

    /**
     * Gets view name for successful POST-request. This function return empty string. Sub-class overrides this method to supply its own view name.
     * @return string
     */
    protected function getViewName_AfterPost() {
        return '';
    }

    /**
     * Convenient function to execute the business (non-POST request). Sub-class overrides this function to perform its own business.
     * @return Dzit_ModelAndView
     */
    protected abstract function executeNonPost();

    /**
     * Turns the error flag on.
     */
    protected function markError() {
        $this->hasError = TRUE;
    }

    /**
     * Gets the error flag.
     * @return boolean
     */
    protected function hasError() {
        return $this->hasError;
    }

    /**
     * Validates POST data. This function returns <code>TRUE</code>. Sub-class overrides this function to perform its own business.
     * @return boolean
     */
    protected function validatePostData() {
        return TRUE;
    }

    /**
     * Gets the ModelAndView for successful POST-request.
     * @return Dzit_ModelAndView
     */
    protected function getModelAndView_AfterPost() {
        $viewName = $this->getViewName_AfterPost();
        if ($viewName !== NULL && $viewName !== '') {
            $model = $this->buildModel_AfterPost();
            return new Dzit_ModelAndView($viewName, $model);
        }
        return NULL;
    }

    /**
     * Gets the ModelAndView for the case when parameter validation fails.
     *
     * This function returns <code>NULL</code>. Sub-class overrides this function
     * to build its own ModelAndView.
     *
     * @return Dzit_ModelAndView
     */
    protected function getModelAndView_ParamsValidationFails() {
        return NULL;
    }

    /**
     * Convenient for sub-class to override. This function is called after
     * POST data validation has passed.
     * @return boolean <code>TRUE</code> if form submission is successful, <code>FALSE</code> otherwise
     */
    protected function doFormSubmission() {
        return TRUE;
    }

    /**
     * Executes POST request.
     * @return Dzit_ModelAndView
     */
    protected function executePost() {
        /*
         * First, we validate POST data.
         */
        if (!$this->validatePostData()) {
            /*
             * If validation fails, turn the error flag on and return.
             */
            $this->markError();
            return NULL;
        }
        if ($this->doFormSubmission()) {
            return $this->getModelAndView_AfterPost();
        }
        return NULL;
    }

    /**
     * Build page's model (after a successful form submission).
     * @return Array
     */
    protected function buildModel_AfterPost() {
        $model = Array();

        $model['basehref'] = $this->buildModel_BaseHref();
        $model['page'] = $this->buildModel_Page();

        $customModel = $this->buildModel();
        if ($customModel !== NULL) {
            //merge custom model to the root
            foreach ($customModel as $key => $value) {
                $model[$key] = $value;
            }
        }

        return $model;
    }

    /**
     * Build page's model (non-POST request).
     * @return Array
     */
    protected function buildModel_NonPost() {
        $model = Array();

        $model['basehref'] = $this->buildModel_BaseHref();
        $model['page'] = $this->buildModel_Page();

        $modelForm = $this->buildModel_Form();
        if ($modelForm !== NULL) {
            $model['form'] = $modelForm;
        }

        $customModel = $this->buildModel();
        if ($customModel !== NULL) {
            //merge custom model to the root
            foreach ($customModel as $key => $value) {
                $model[$key] = $value;
            }
        }

        return $model;
    }

    /**
     * Return model form. This function returns <code>NULL</code>.
     *
     * Sub-class overrides this function to build its own form model if the page has form.
     * @return Array
     */
    protected function buildModel_Form() {
        return NULL;
    }

    protected function buildModel_BaseHref() {
        $baseHref = 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"];
        $baseHref = preg_replace('/\\/[^\\/]*$/', '/', $baseHref);
        $baseHref .= SKIN_DIR;
        $baseHref = preg_replace('/\\/+$/', '/', $baseHref);
        return $baseHref;
    }

    protected function buildModel_Page() {
        $pageTitle = $this->getPageTitle();
        $pageKeywords = $this->getPageKeywords();
        $pageDescription = $this->getPageDescription();
        $pageCopyright = $this->getPageCopyright();

        $page = Array('title' => $pageTitle,
                'keywords' => $pageKeywords,
                'description' => $pageDescription,
                'copyright' => $pageCopyright);

        return $page;
    }

    protected function getPageTitle() {
        return '//TODO: Page Title';
    }

    protected function getPageKeywords() {
        return '//TODO: Page Keywords';
    }

    protected function getPageDescription() {
        return '//TODO: Page Description';
    }

    protected function getPageCopyright() {
        return '//TODO: Page Copyright';
    }

    /**
     * Validate parameters (e.g. parameters passed via URL).
     *
     * This function returns <code>TRUE</code>. Sub-class overrides this function to
     * perform its own business.
     *
     * @return boolean
     */
    protected function validateParams() {
        return TRUE;
    }

    /* (non-PHPdoc)
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $this->module = $module;
        $this->action = $action;

        /*
         * First, we validate parameters (i.e. parameters passed via URL).
         */
        if (!$this->validateParams()) {
            /*
             * If the validation fails, we should present the error view.
             */
            $modelAndView = $this->getModelAndView_ParamsValidationFails();
            if ($modelAndView === NULL) {
                throw new Dzit_Exception('The ModelAndView is NULL!');
            }
            return $modelAndView;
        }

        /*
         * If the validation passes:
         * - If the request is POST, we call function executePost and obtain the returned ModelAndView
         * - Otherwise, we call function executeNonPost, and obtain the returned ModelAndView
         */
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $modelAndView = $this->executePost();
        } else {
            $modelAndView = $this->executeNonPost();
        }

        /*
         * If the returned ModelAndView is not NULL, we return it and stop the execution.
         */
        if ($modelAndView !== NULL) {
            return $modelAndView;
        }

        /*
         * Otherwise, we get the view name. If the view name is not NULL, we build the model.
         */
        $viewName = $this->getViewName();
        if ($viewName !== NULL && $viewName !== '') {
            $model = $this->buildModel_NonPost();
            return new Dzit_ModelAndView($viewName, $model);
        }

        return NULL;
    }
}