<?php
class Vcatalog_Controller_LoginController extends Vcatalog_Controller_BaseController {
    const VIEW_NAME = 'login';
    const VIEW_NAME_AFTER_POST = 'loginDone';

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
     * @see Vcatalog_Controller_BaseController::buildModel_AfterPost()
     */
    protected function buildModel_AfterPost() {
        $model = parent::buildModel_AfterPost();

        $lang = $this->getLanguage();
        $model['infoMessage'] = $lang->getMessage('msg.login.done');
        if (isset($_SESSION[SESSION_LAST_ACCESS_URL])) {
            $urlTransit = $_SESSION[SESSION_LAST_ACCESS_URL];
        } else {
            $urlTransit = $_SERVER['SCRIPT_NAME'];
        }
        $model['urlTransit'] = $urlTransit;
        $model['transitMessage'] = $lang->getMessage('msg.transit', $urlTransit);
        return $model;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::buildModel_Form()
     */
    protected function buildModel_Form() {
        $form = Array('action' => $_SERVER['REQUEST_URI'], 'name' => 'frmLogin');
        if ($this->hasError()) {
            $lang = $this->getLanguage();
            $form['errorMessage'] = $lang->getMessage('error.loginFailed');
        }
        return $form;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::validatePostData()
     */
    protected function validatePostData() {
        $userDao = $this->getDao(DAO_USER);
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $email = trim(strtolower($email));
        $password = trim($password);

        if ($email === '' || $password === '') {
            return FALSE;
        }

        $user = $userDao->getUserByEmail($email);
        if ($user === NULL) {
            return FALSE;
        }
        if (strtolower(md5($password)) !== strtolower($user['password'])) {
            return FALSE;
        }
        return TRUE;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::doFormSubmission()
     */
    protected function doFormSubmission() {
        $_SESSION[SESSION_USER_ID] = strtolower(trim($_POST['email']));
        return TRUE;
    }
}
