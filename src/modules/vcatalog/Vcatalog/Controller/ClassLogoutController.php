<?php
class Vlistings_Controller_LogoutController extends Vlistings_Controller_BaseController {
    const VIEW_NAME = 'logout';

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::execute()
     */
    public function execute($module, $action) {
        unset($_SESSION[SESSION_USER_ID]);
        if (isset($_SESSION[SESSION_LAST_ACCESS_URL])) {
            $url = $_SESSION[SESSION_LAST_ACCESS_URL];
        } else {
            $url = $_SERVER['SCRIPT_NAME'];
        }
        $view = new Dzit_View_RedirectView($url);
        return new Dzit_ModelAndView($view, NULL);
    }
}
