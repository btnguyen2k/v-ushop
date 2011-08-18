<?php
class Vcatalog_Controller_LogoutController extends Vcatalog_Controller_BaseFlowController {

    /**
     * @see Dzit_Controller_FlowController::execute()
     */
    public function execute($module, $action) {
        unset($_SESSION[SESSION_USER_ID]);
        if (isset($_SESSION[SESSION_LAST_ACCESS_URL])) {
            $url = $_SESSION[SESSION_LAST_ACCESS_URL];
        } else {
            $url = $_SERVER['SCRIPT_NAME'];
        }

        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 1 Jan 2011 00:00:00 GMT"); // Date in the past
        header("Pragma: no-cache");

        if (strpos('?', $url) >= 0) {
            $url .= '&' . rand();
        } else {
            $url .= '?' . rand();
        }

        $view = new Dzit_View_RedirectView($url);
        return new Dzit_ModelAndView($view, NULL);
    }
}
