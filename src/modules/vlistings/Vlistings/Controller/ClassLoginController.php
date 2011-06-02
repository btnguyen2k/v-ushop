<?php
class Vlistings_Controller_LoginController extends Vlistings_Controller_BaseController {
    const VIEW_NAME = 'login';

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::executeAction()
     */
    protected function executeAction() {

    }

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::buildModel_Form()
     */
    protected function buildModel_Form() {
        if (isset($_POST)) {
            return NULL;
        }
    }
}
