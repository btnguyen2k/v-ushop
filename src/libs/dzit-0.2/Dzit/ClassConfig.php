<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * OO-style of in-memory {key:value} storage.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassConfig.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * OO-style of in-memory {key:value} storage.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_Config {

    /**
     * Constant that holds the dispatcher instance (type {@link Dzit_IDispatcher}).
     *
     * Dispatcher is responsible for:
     * <ul>
     *     <li>Routing the request {module:action} to the corresponding controller.</li>
     *     <li>Rendering the view.</li>
     * </ul>
     *
     * @var string
     */
    const CONF_DISPATCHER = 'Dzit_Dispatcher';

    /**
     * Constant that holds name of router configuration.
     *
     * Router information is {key:value} based, as the following:
     * <code>
     * {
     *     'module1' => ControllerInstance1,
     *     'module2' => 'ControllerClassName2',
     *     'module3' =>
     *     {
     *         'action1' => ControllerInstance3,
     *         'action2' => 'ControllerClassName4'
     *     }
     * }
     * </code>
     *
     * @var string
     */
    const CONF_ROUTER = 'Dzit_Router';

    /**
     * Constant that holds the action handler mapping instance (type {@link Dzit_IActionHandlerMapping}).
     *
     * Action handler mapping is responsible for obtaining a controller instance
     * (type {@link Dzit_IController}) for a request {module:action}.
     *
     * @var string
     */
    const CONF_ACTION_HANDLER_MAPPING = 'Dzit_ActionHandlerMapping';

    /**
     * Constant that holds the view resolver instance (type {@link Dzit_IViewResolver}).
     *
     * View resolver is responsible for resolving a {@link Dzit_IView} from name (string).
     *
     * @var string
     */
    const CONF_VIEW_RESOLVER = 'Dzit_ViewResolver';

    /**
     * Constant that holds name of the default template pack.
     *
     * @var string
     */
    const CONF_DEFAULT_TEMPLATE_NAME = 'Dzit_DefaultTemplateName';

    /**
     * Constant that holds name of the default language pack.
     *
     * @var string
     */
    const CONF_DEFAULT_LANGUAGE_NAME = 'Dzit_DefaultLanguageName';

    private static $config = Array();

    /**
     * Constructs a new Dzit_Config object.
     */
    private function __construct() {
        //singleton
    }

    /**
     * Gets a configuration setting.
     *
     * @param string $name
     * @return mixed
     */
    public static function get($name) {
        if ( isset(self::$config[$name]) ) {
            return self::$config[$name];
        }
        return NULL;
    }

    /**
     * Sets a configuration setting.
     *
     * @param string $name
     * @param mixed $value
     */
    public static function set($name, $value) {
        self::$config[$name] = $value;
    }
}
?>
