<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Default implementation of {@link Dzit_IDispatcher}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassDefaultDispatcher.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * Default implementation of {@link Dzit_IDispatcher}.
 *
 * Workflow defined by this class:
 * <ul>
 *     <li>Obtains the {@link Dzit_RequestParser} and uses it to retrieve the request module/action.</li>
 *     <li>Obtains the {@link Dzit_IActionHandlerMapping} from {@link Dzit_Config::CONF_ACTION_HANDLER_MAPPING}
 *     to retrieve a {@link Dzit_IController} to handle the request module/action (fallbacks to {@link Dzit_DefaultActionHandlerMapping}
 *     if there is no action handler mapping is found), and checks the returned value:
 *         <ul>
 *             <li>If the returned value is an instance of {@link Dzit_ModelAndView}, renders it:
 *                 <ul>
 *                     <li>Obtains the model and the view from the returned {@link Dzit_ModelAndView} object.
 *                         <ul>
 *                             <li>If the returned view is a string (means view name), obtains a {@link Dzit_IViewResolver}
 *                             from {@link Dzit_Config::CONF_VIEW_RESOLVER} and uses it to resolve the view name to a
 *                             {@link Dzit_IView} instance. Fallbacks to {@link Dzit_DefaultViewResolver}
 *                             if no view resolver is found.</li>
 *                             <li>If the returned view is an instance of {@link Dzit_IView}, calls its {@link Dzit_IView::render()}
 *                             function.</li>
 *                         </ul>
 *                     </li>
 *                 </ul>
 *             </li>
 *         </ul>
 *     </li>
 * </ul>
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2
 */
class Dzit_DefaultDispatcher implements Dzit_IDispatcher {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Constructs a new Dzit_DefaultDispatcher object.
     */
    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     * Workflow defined by this function:
     * <ul>
     *     <li>Obtains the {@link Dzit_RequestParser} and uses it to retrieve the request module/action.</li>
     *     <li>Obtains the {@link Dzit_IController} to handle the request module/action, and checks the returned value:
     *         <ul>
     *             <li>If the returned value is an instance of {@link Dzit_ModelAndView}, renders it.</li>
     *         </ul>
     *     </li>
     * </ul>
     *
     * @see Dzit_IDispatcher::dispatch()
     * @see Dzit_RequestParser
     * @see Dzit_IActionHandler
     */
    public function dispatch() {
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = $this->getRequestParser();
        $module = $requestParser->getModule();
        $action = $requestParser->getAction();
        /**
         * @var Dzit_IController
         */
        $actionHandler = $this->getActionHandler($module, $action);
        if ( $actionHandler != NULL ) {
            if ( $this->LOGGER->isDebugEnabled() ) {
                $this->LOGGER->debug("Action handler for {"."$module:$action"."}: [".get_class($actionHandler)."]");
            }
            /**
             * @var Dzit_ModelAndView
             */
            $mav = $actionHandler->execute($module, $action);
            if ( $mav != NULL ) {
                $this->renderModelAndView($mav, $module, $action);
            } else {
                if ( $this->LOGGER->isDebugEnabled() ) {
                    $this->LOGGER->debug("Action handler returns a NULL model and view.");
                }
            }
        } else {
            throw new Dzit_Exception('There is no action handler for {'.$module.':'.$action.'}');
        }
    }

    /**
     * Gets the {@link Dzit_RequestParser} object.
     *
     * @return Dzit_RequestParser
     */
    protected function getRequestParser() {
        return Dzit_RequestParser::getInstance();
    }

    /**
     * Renders the given model and view.
     *
     * Workflow defined by this function:
     * <ul>
     *     <li>Obtains the model and the view from the supplied {@link Dzit_ModelAndView} object.
     *         <ul>
     *             <li>If the returned view is a string (means view name), obtains a {@link Dzit_IViewResolver}
     *             from {@link Dzit_Config::CONF_VIEW_RESOLVER} and uses it to resolve the view name to a
     *             {@link Dzit_IView} instance. This function fallbacks to {@link Dzit_DefaultViewResolver}
     *             if no view resolver is found.</li>
     *             <li>If the returned view is an instance of {@link Dzit_IView}, calls its {@link Dzit_IView::render()}
     *             function and returns.</li>
     *         </ul>
     *     </li>
     * </ul>
     *
     * @param Dzit_ModelAndView $mav
     * @param string $module
     * @param string $action
     */
    protected function renderModelAndView($mav, $module, $action) {
        $view = $mav->getView();
        $model = $mav->getModel();
        if ( is_string($view) ) {
            /**
             * @var Dzit_IViewResolver
             */
            $viewResolver = Dzit_Config::get(Dzit_Config::CONF_VIEW_RESOLVER);
            if ( is_string($viewResolver) ) {
                $viewResolver = new $viewResolver();
            }
            if ( !($viewResolver instanceof Dzit_IViewResolver) ) {
                $viewResolver = new Dzit_DefaultViewResolver();
            }
            if ( $this->LOGGER->isDebugEnabled() ) {
                $this->LOGGER->debug("View [$view] of type string. Use view resolver [".get_class($viewResolver)."] to resolve.");
            }
            $view = $viewResolver->resolveViewName($view);

        }
        if ( $view instanceof Dzit_IView ) {
            if ( $this->LOGGER->isDebugEnabled() ) {
                $this->LOGGER->debug("Rendering view [".get_class($view)."]");
            }
            $view->render($model, $module, $action);
            return;
        } else {
            //TODO: no view?
            if ( $this->LOGGER->isDebugEnabled() ) {
                $this->LOGGER->debug("No view!");
            }
        }
    }


    /**
     * Gets the action handler for the supplied module/action.
     *
     * This function uses a {@link Dzit_IActionHandlerMapping} instance (configured by
     * {@link Dzit_Config::CONF_ACTION_HANDLER_MAPPING}) to obtain the controller for the
     * request module/action. If there is no action handler mapping is found, this function
     * fallbacks to {@link Dzit_DefaultActionHandlerMapping}.
     *
     * @param string $module
     * @param string $action
     * @return Dzit_IController
     */
    protected function getActionHandler($module, $action) {
        /**
         * @var Dzit_IActionHandlerMapping
         */
        $actionHandlerMapping = Dzit_Config::get(Dzit_Config::CONF_ACTION_HANDLER_MAPPING);
        if ( is_string($actionHandlerMapping) ) {
            $actionHandlerMapping = new $actionHandlerMapping();
        }
        if ( $actionHandlerMapping == NULL || !($actionHandlerMapping instanceof Dzit_IActionHandlerMapping) ) {
            $actionHandlerMapping = new Dzit_DefaultActionHandlerMapping();
        }
        return $actionHandlerMapping->getController($module, $action);
    }
}
?>
