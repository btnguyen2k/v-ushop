<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * MVC View for PHP-based single-template.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassPhpView.php 63 2011-05-29 01:52:33Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * MVC View for PHP-based single-template.
 *
 * Usage:
 * <code>
 * $filename = 'template/home.php';
 * $view = new Dzit_View_PhpView($filename);
 * $view->render($model, $module, $action);
 * </code>
 *
 * Upon the {@link Dzit_View_PhpView::render() render()} method is called, a global variable
 * $MODEL is created and the specified {@link Dzit_View_PhpView::__construct() php file}
 * is included.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_View_PhpView extends Dzit_View_AbstractView {
    /**
     * @var string
     */
    private $phpFile;

    /**
     * Constructs a new Dzit_View_PhpView object.
     *
     * @param string $phpFile specify the PHP view file to be included
     */
    public function __construct($phpFile) {
        $this->phpFile = $phpFile;
    }

    /**
     * This method creates a global variable $MODEL and includes the specified
     * {@link Dzit_View_PhpView::__construct() php file}
     *
     * @see Dzit_IView::render();
     */
    public function render($_model, $module, $action) {
        global $MODEL;
        $MODEL = $_model;
        include $this->phpFile;
    }
}
?>
