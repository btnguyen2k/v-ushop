<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * MVC View for Smarty-based template.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSmartyView.php 63 2011-05-29 01:52:33Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * MVC View for Smarty-based template.
 *
 * @package     Dzit
 * @subpackage  View
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_View_SmartyView extends Dzit_View_AbstractView {
    /**
     * @var Smarty
     */
    private $smarty;

    /**
     * @var string
     */
    private $templateFile;

    public function __construct($smarty, $templateFile) {
        $this->smarty = $smarty;
        $this->templateFile = $templateFile;
    }

    /**
     * Gets the associated Smarty instance.
     *
     * @return Smarty
     */
    protected function getSmarty() {
        return $this->smarty;
    }

    /**
     * Gets the associated template file.
     *
     * @return string
     */
    protected function getTemplateFile() {
        return $this->templateFile;
    }

    /**
     * @see Dzit_IView::render();
     */
    public function render($model, $module, $action) {
        $this->smarty->assign('MODEL', $model);
        $this->smarty->display($this->getTemplateFile());
    }
}
?>
