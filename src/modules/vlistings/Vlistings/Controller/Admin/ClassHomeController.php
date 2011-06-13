<?php
class Vlistings_Controller_Admin_HomeController extends Vlistings_Controller_Admin_BaseController {

    const VIEW_NAME = 'admin_home';

    /* (non-PHPdoc)
     * @see Vlistings_Controller_BaseController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }
}