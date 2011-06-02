<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Default implementation of {@link Dzit_IActionHandlerMapping}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassDefaultActionHandlerMapping.php 73 2011-06-02 07:52:49Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * Default implementation of {@link Dzit_IActionHandlerMapping}.
 *
 * This implementation locates controllers from a router configurations as the following:
 * <code>
 * {
 * 'module1' => ControllerInstance1,
 * 'module2' => 'ControllerClassName2',
 * 'module3' =>
 * {
 * 'action1' => ControllerInstance3,
 * 'action2' => 'ControllerClassName4'
 * }
 * }
 * </code>
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.2
 */
class Dzit_DefaultActionHandlerMapping implements Dzit_IActionHandlerMapping {

    const WILDCARD = '*';

    /**
     * @var mixed
     */
    private $router;

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Constructs a new Dzit_DefaultActionHandlerMapping object.
     *
     * @param Array $router router configurations
     */
    public function __construct($router = NULL) {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        $this->router = $router;
        if ($this->router == NULL || !is_array($this->router)) {
            $this->router = Dzit_Config::get(Dzit_Config::CONF_ROUTER);
        }
        if ($this->router == NULL || !is_array($this->router)) {
            $this->router = Array();
        }
    }

    /**
     * Controllers are located from a router configurations as the following:
     * <code>
     * {
     * 'module1' => ControllerInstance1,
     * 'module2' => 'ControllerClassName2',
     * 'module3' =>
     * {
     * 'action1' => ControllerInstance3,
     * 'action2' => 'ControllerClassName4'
     * }
     * }
     * </code>
     *
     * @see Dzit_IActionHandlerMapping::getController()
     */
    public function getController($module, $action) {
        $this->LOGGER->debug('Locating controller for {' . $module . ':' . $action . '}');
        $controller = NULL;
        if (isset($this->router[$module]) && is_array($this->router[$module])) {
            if (isset($this->router[$module][$action])) {
                $controller = $this->router[$module][$action];
            } elseif (isset($this->router[$module][self::WILDCARD])) {
                $controller = $this->router[$module][self::WILDCARD];
            }
        } elseif (isset($this->router[$module])) {
            $controller = $this->router[$module];
        } elseif (isset($this->router[self::WILDCARD])) {
            $controller = is_array($this->router[self::WILDCARD]) ? NULL : $this->router[self::WILDCARD];
        }
        if ($controller != NULL) {
            if (is_string($controller)) {
                //class name
                $controller = $this->getControllerByString($controller);
            }
            if ($controller instanceof Dzit_IController) {
                $this->LOGGER->debug('Found controller {' . get_class($controller) . '}');
                return $controller;
            } else {
                $msg = 'Controller [' . get_class($controller) . '] is not of type Dzit_IController!';
                $this->LOGGER->error($msg);
            }
        }
        $this->LOGGER->warn('Can not find controller for {' . $module . ':' . $action . '}');
        return NULL;
    }

    /**
     * Obtains a controller from a string.
     *
     * This function assume the string parameter is class name of the controller.
     *
     * @param string $className
     * @return Dzit_IController
     */
    protected function getControllerByString($className) {
        return new $className();
    }
}
?>
