<?php
class Vcatalog_Controller_Admin_SiteSettingsController extends Vcatalog_Controller_Admin_BaseController {
    const VIEW_NAME = 'admin_siteSettings';
    const VIEW_NAME_AFTER_POST = 'admin_siteSettings';

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::getViewName_AfterPost()
     */
    protected function getViewName_AfterPost() {
        return self::VIEW_NAME_AFTER_POST;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmLogin');
        $dao = $this->getDao(DAO_CONFIG);
        $form['siteName'] = $dao->loadConfig('site_name');
        $form['siteTitle'] = $dao->loadConfig('site_title');
        $form['siteKeywords'] = $dao->loadConfig('site_keywords');
        $form['siteDescription'] = $dao->loadConfig('site_description');
        $form['siteSlogan'] = $dao->loadConfig('site_slogan');
        $form['siteCopyright'] = $dao->loadConfig('site_copyright');
        if (isset($_POST)) {
            $lang = $this->getLanguage();
            $form['infoMessage'] = $lang->getMessage('msg.siteSettings.done');
        }
        return $form;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::doFormSubmission()
     */
    protected function doFormSubmission() {
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
