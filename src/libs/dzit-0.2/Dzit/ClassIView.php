<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * MVC View for a web application.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIView.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * MVC View for a web application. Implementations are responsible for rendering the actual content.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2
 */
interface Dzit_IView {
    
    /**
     * Returns the content type of the view, if predetermined.
     * 
     * @return string
     */
    public function getContentType();
    
    /**
     * Renders the view with the given model.
     *
     * @param mixed $model
     * @param string $module
     * @param string $action
     */
    public function render($model, $module, $action);
}
?>
