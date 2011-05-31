<?php
abstract class Vlistings_Controller_BaseController implements Dzit_IController {

    private $module, $action;

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
     * Gets view name.
     * @return string
     */
    protected abstract function getViewName();

    /**
     * Convenient function to execute the business. Sub-class overrides this function.
     * @return Dzit_ModelAndView
     */
    protected abstract function executeAction();

    /**
     * Build page's model.
     * @return Array
     */
    protected function buildModel() {
        $model = Array();
        $model['page'] = $this->buildModel_Page();
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

    /* (non-PHPdoc)
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $this->module = $module;
        $this->action = $action;
        $modelAndView = $this->executeAction();
        if ($modelAndView !== NULL) {
            return $modelAndView;
        }
        $viewName = $this->getViewName();
        if ($viewName !== NULL && $viewName !== '') {
            $model = $this->buildModel();
            return new Dzit_ModelAndView($viewName, $model);
        }
        return NULL;
    }
}