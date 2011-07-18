<?php
class Vcatalog_Controller_Admin_SiteSettingsController extends Vcatalog_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'admin_siteSettings';
    const VIEW_NAME_AFTER_POST = 'admin_siteSettings';

    const FORM_FIELD_SITE_NAME = 'siteName';
    const FORM_FIELD_SITE_TITLE = 'siteTitle';
    const FORM_FIELD_SITE_KEYWORDS = 'siteKeywords';
    const FORM_FIELD_SITE_DESCRIPTION = 'siteDescription';
    const FORM_FIELD_SITE_COPYRIGHT = 'siteCopyright';
    const FORM_FIELD_SITE_SLOGAN = 'siteSlogan';

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
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
        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmSiteSettings');
        $dao = $this->getDao(DAO_CONFIG);
        $form[self::FORM_FIELD_SITE_NAME] = $dao->loadConfig(CONFIG_SITE_NAME);
        $form[self::FORM_FIELD_SITE_TITLE] = $dao->loadConfig(CONFIG_SITE_TITLE);
        $form[self::FORM_FIELD_SITE_KEYWORDS] = $dao->loadConfig(CONFIG_SITE_KEYWORDS);
        $form[self::FORM_FIELD_SITE_DESCRIPTION] = $dao->loadConfig(CONFIG_SITE_DESCRIPTION);
        $form[self::FORM_FIELD_SITE_SLOGAN] = $dao->loadConfig(CONFIG_SITE_SLOGAN);
        $form[self::FORM_FIELD_SITE_COPYRIGHT] = $dao->loadConfig(CONFIG_SITE_COPYRIGHT);
        if ($this->isPostRequest()) {
            $lang = $this->getLanguage();
            $form[FORM_INFO_MESSAGES] = Array($lang->getMessage('msg.siteSettings.done'));
        }
        return $form;
    }

    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $dao = $this->getDao(DAO_CONFIG);
        $siteName = isset($_POST['siteName']) ? $_POST['siteName'] : '';
        $siteTitle = isset($_POST['siteTitle']) ? $_POST['siteTitle'] : '';
        $siteKeywords = isset($_POST['siteKeywords']) ? $_POST['siteKeywords'] : '';
        $siteDescription = isset($_POST['siteDescription']) ? $_POST['siteDescription'] : '';
        $siteCopyright = isset($_POST['siteCopyright']) ? $_POST['siteCopyright'] : '';
        //$siteSlogan = isset($_POST['siteName']) ? $_POST['siteName'] : '';
        $dao->saveConfig('site_name', $siteName);
        $dao->saveConfig('site_title', $siteTitle);
        $dao->saveConfig('site_keywords', $siteKeywords);
        $dao->saveConfig('site_description', $siteDescription);
        $dao->saveConfig('site_copyright', $siteCopyright);
        //$dao->saveConfig('siteSlogan', $siteSlogan);
        return FALSE;
    }
}
