<?php
class Vcatalog_Controller_Admin_EmailSettingsController extends Vcatalog_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'admin_emailSettings';
    const VIEW_NAME_AFTER_POST = 'admin_emailSettings';

    const FORM_FIELD_USE_SMTP = 'useSmtp';
    const FORM_FIELD_SMTP_HOST = 'smtpHost';
    const FORM_FIELD_SMTP_PORT = 'smtpPort';
    const FORM_FIELD_SMTP_SSL = 'smtpSsl';
    const FORM_FIELD_SMTP_USERNAME = 'smtpUsername';
    const FORM_FIELD_SMTP_PASSWORD = 'smtpPassword';
    const FORM_FIELD_EMAIL_OUTGOING = 'emailOutgoing';
    const FORM_FIELD_EMAIL_ORDER_NOTIFICATION = 'emailOrderNotification';
    const FORM_FIELD_EMAIL_ON_SUBJECT = 'emailOnSubject';
    const FORM_FIELD_EMAIL_ON_BODY = 'emailOnBody';

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
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmEmailSettings');
        $dao = $this->getDao(DAO_CONFIG);
        $form[self::FORM_FIELD_EMAIL_ORDER_NOTIFICATION] = $dao->loadConfig(CONFIG_EMAIL_ORDER_NOTIFICATION);
        $form[self::FORM_FIELD_EMAIL_OUTGOING] = $dao->loadConfig(CONFIG_EMAIL_OUTGOING);
        $form[self::FORM_FIELD_EMAIL_ON_BODY] = $dao->loadConfig(CONFIG_EMAIL_ON_BODY);
        $form[self::FORM_FIELD_EMAIL_ON_SUBJECT] = $dao->loadConfig(CONFIG_EMAIL_ON_SUBJECT);
        $form[self::FORM_FIELD_USE_SMTP] = $dao->loadConfig(CONFIG_USE_SMTP);
        $form[self::FORM_FIELD_SMTP_HOST] = $dao->loadConfig(CONFIG_SMTP_HOST);
        $form[self::FORM_FIELD_SMTP_PASSWORD] = $dao->loadConfig(CONFIG_SMTP_PASSWORD);
        $form[self::FORM_FIELD_SMTP_PORT] = $dao->loadConfig(CONFIG_SMTP_PORT);
        $form[self::FORM_FIELD_SMTP_SSL] = $dao->loadConfig(CONFIG_SMTP_SSL);
        $form[self::FORM_FIELD_SMTP_USERNAME] = $dao->loadConfig(CONFIG_SMTP_USERNAME);
        if (isset($_POST)) {
            $lang = $this->getLanguage();
            $form[FORM_INFO_MESSAGES] = Array($lang->getMessage('msg.emailSettings.done'));
        }
        return $form;
    }

    /**
     * @see Dzit_Controller_FlowController::performFormSubmission()
     */
    protected function performFormSubmission() {
        $dao = $this->getDao(DAO_CONFIG);
        $emailOrderNotification = isset($_POST[self::FORM_FIELD_EMAIL_ORDER_NOTIFICATION]) ? $_POST[self::FORM_FIELD_EMAIL_ORDER_NOTIFICATION] : '';
        $emailOutgoing = isset($_POST[self::FORM_FIELD_EMAIL_OUTGOING]) ? $_POST[self::FORM_FIELD_EMAIL_OUTGOING] : '';
        $emailOnBody = isset($_POST[self::FORM_FIELD_EMAIL_ON_BODY]) ? $_POST[self::FORM_FIELD_EMAIL_ON_BODY] : '';
        $emailOnSubject = isset($_POST[self::FORM_FIELD_EMAIL_ON_SUBJECT]) ? $_POST[self::FORM_FIELD_EMAIL_ON_SUBJECT] : '';
        $useSmtp = isset($_POST[self::FORM_FIELD_USE_SMTP]) ? (int)$_POST[self::FORM_FIELD_USE_SMTP] : 0;
        $smtpHost = isset($_POST[self::FORM_FIELD_SMTP_HOST]) ? $_POST[self::FORM_FIELD_SMTP_HOST] : '';
        $smtpPassword = isset($_POST[self::FORM_FIELD_SMTP_PASSWORD]) ? $_POST[self::FORM_FIELD_SMTP_PASSWORD] : '';
        $smtpPort = isset($_POST[self::FORM_FIELD_SMTP_PORT]) ? (int)$_POST[self::FORM_FIELD_SMTP_PORT] : 0;
        $smtpSsl = isset($_POST[self::FORM_FIELD_SMTP_SSL]) ? (int)$_POST[self::FORM_FIELD_SMTP_SSL] : 0;
        $smtpUsername = isset($_POST[self::FORM_FIELD_SMTP_USERNAME]) ? $_POST[self::FORM_FIELD_SMTP_USERNAME] : '';

        $dao->saveConfig(CONFIG_EMAIL_ORDER_NOTIFICATION, $emailOrderNotification);
        $dao->saveConfig(CONFIG_EMAIL_OUTGOING, $emailOutgoing);
        $dao->saveConfig(CONFIG_EMAIL_ON_BODY, $emailOnBody);
        $dao->saveConfig(CONFIG_EMAIL_ON_SUBJECT, $emailOnSubject);
        $dao->saveConfig(CONFIG_USE_SMTP, $useSmtp);
        $dao->saveConfig(CONFIG_SMTP_HOST, $smtpHost);
        $dao->saveConfig(CONFIG_SMTP_PASSWORD, $smtpPassword);
        $dao->saveConfig(CONFIG_SMTP_PORT, $smtpPort);
        $dao->saveConfig(CONFIG_SMTP_SSL, $smtpSsl);
        $dao->saveConfig(CONFIG_SMTP_USERNAME, $smtpUsername);

        return FALSE;
    }
}
