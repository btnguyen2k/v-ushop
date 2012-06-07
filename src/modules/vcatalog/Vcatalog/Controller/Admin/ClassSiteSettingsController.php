<?php
class Vcatalog_Controller_Admin_SiteSettingsController extends Vcatalog_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'inline_site_settings';
    const VIEW_NAME_AFTER_POST = 'inline_site_settings';

    const FORM_FIELD_SITE_NAME = 'siteName';
    const FORM_FIELD_SITE_TITLE = 'siteTitle';
    const FORM_FIELD_SITE_KEYWORDS = 'siteKeywords';
    const FORM_FIELD_SITE_DESCRIPTION = 'siteDescription';
    const FORM_FIELD_SITE_COPYRIGHT = 'siteCopyright';
    const FORM_FIELD_SITE_SLOGAN = 'siteSlogan';

    const FORM_FIELD_SITE_SKIN = 'siteSkin';

    /**
     *
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
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

        $site = $this->getGpvSite();
        if ($site->getRefSite() !== NULL) {
            $site = $site->getRefSite();
        }

        $siteDomain = $site->getSiteDomain() . '-';
        $siteSkins = Array();
        if (FALSE !== ($dirHandle = opendir(SITE_SKINS_ROOT_DIR))) {
            while (FALSE !== ($entry = readdir($dirHandle))) {
                if ($entry[0] !== '.') {
                    if ($entry === 'default' || strpos($entry, $siteDomain) === 0) {
                        $siteSkins[] = $entry;
                    }
                }
            }
        }
        sort($siteSkins);
        $model['siteSkins'] = $siteSkins;

        return $model;
    }

    /**
     *
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
        $form[self::FORM_FIELD_SITE_SKIN] = $dao->loadConfig(CONFIG_SITE_SKIN);
        if ($this->isPostRequest()) {
            $lang = $this->getLanguage();
            $form[FORM_INFO_MESSAGES] = Array($lang->getMessage('msg.siteSettings.done'));
        }
        return $form;
    }

    /**
     *
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $dao = $this->getDao(DAO_CONFIG);
        $siteName = isset($_POST[self::FORM_FIELD_SITE_NAME]) ? $_POST[self::FORM_FIELD_SITE_NAME] : '';
        $siteTitle = isset($_POST[self::FORM_FIELD_SITE_TITLE]) ? $_POST[self::FORM_FIELD_SITE_TITLE] : '';
        $siteKeywords = isset($_POST[self::FORM_FIELD_SITE_KEYWORDS]) ? $_POST[self::FORM_FIELD_SITE_KEYWORDS] : '';
        $siteDescription = isset($_POST[self::FORM_FIELD_SITE_DESCRIPTION]) ? $_POST[self::FORM_FIELD_SITE_DESCRIPTION] : '';
        $siteCopyright = isset($_POST[self::FORM_FIELD_SITE_COPYRIGHT]) ? $_POST[self::FORM_FIELD_SITE_COPYRIGHT] : '';
        $siteSkin = isset($_POST[self::FORM_FIELD_SITE_SKIN]) ? $_POST[self::FORM_FIELD_SITE_SKIN] : '';

        $dao->saveConfig(CONFIG_SITE_NAME, $siteName);
        $dao->saveConfig(CONFIG_SITE_TITLE, $siteTitle);
        $dao->saveConfig(CONFIG_SITE_KEYWORDS, $siteKeywords);
        $dao->saveConfig(CONFIG_SITE_KEYWORDS, $siteDescription);
        $dao->saveConfig(CONFIG_SITE_COPYRIGHT, $siteCopyright);
        $dao->saveConfig(CONFIG_SITE_SKIN, $siteSkin);
        return FALSE;
    }
}
