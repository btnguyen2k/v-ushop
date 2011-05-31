<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * A view that redirects to a URL.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassRedirectView.php 54 2011-01-07 06:31:51Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * A view that redirects to a URL.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_View_RedirectView extends Dzit_View_AbstractView {

    private $url = NULL;

    /**
     * Constructs a new Dzit_View_RedirectView object.
     */
    public function __construct($url) {
        $this->url = $url;
    }

    /**
     * Gets the redirect url.
     *
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Sets the redirect url.
     *
     * @param string $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * @see Dzit_IView::render();
     */
    public function render($model, $module, $action) {
        header('Location: '.$this->url);
    }
}
?>
