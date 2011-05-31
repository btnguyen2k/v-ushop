<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Default implementation of {@link Dzit_IViewResolver}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassDefaultViewResolver.php 62 2011-05-26 08:34:31Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * Default implementation of {@link Dzit_IViewResolver}.
 *
 *
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2
 */
class Dzit_DefaultViewResolver implements Dzit_IViewResolver {

    /**
     * Constructs a new Dzit_DefaultActionHandlerMapping object.
     */
    public function __construct() {
    }

    /**
     * Gets name of the current template pack.
     *
     * @return string
     */
    protected function getTemplateName() {
        $templateName = Dzit_Helper_SessionHelper::getSessionAttribute(Dzit_Constants::SESSION_TEMPLATE_PACK);
        return $templateName != NULL ? $templateName : Dzit_Config::get(Dzit_Config::CONF_DEFAULT_TEMPLATE_NAME);
    }

    /**
     * Gets the template pack.
     *
     * @return Ddth_Template_ITemplate
     */
    protected function getTemplate() {
        /**
         * @var Ddth_Template_ITemplateFactory
         */
        $templateFactory = Ddth_Template_BaseTemplateFactory::getInstance();
        return $templateFactory != NULL?$templateFactory->getTemplate($this->getTemplateName()):NULL;
    }

    /**
     * @see Dzit_IViewResolver::resolveViewName()
     */
    public function resolveViewName($viewName) {
        /**
         * @var Ddth_Template_ITemplate
         */
        $template = $this->getTemplate();
        if ( $template != NULL ) {
            if ( $template instanceof Ddth_Template_Php_PhpTemplate ) {
                return $this->loadPhpView($viewName, $template);
            } else if ( $template instanceof Ddth_Template_Smarty_SmartyTemplate ) {
                return $this->loadSmartyView($viewName, $template);
            } else {
                //TODO: template type not supported!
            }
        }
        return NULL;
    }

    /**
     * Loads the view for PHP-based template.
     *
     * @param string $viewName
     * @param Ddth_Template_Php_PhpTemplate $template
     * @return Dzit_IView
     */
    protected function loadPhpView($viewName, $template) {

    }

    /**
     * Loads the view for Smarty-based template.
     *
     * @param string $viewName
     * @param Ddth_Template_Smarty_SmartyTemplate $template
     * @return Dzit_IView
     */
    protected function loadSmartyView($viewName, $template) {

    }
}
?>
