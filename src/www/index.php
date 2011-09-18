<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's bootstrap script.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: index.php 126 2011-09-18 09:33:47Z btnguyen2k $
 * @since       File available since v0.1
 */

spl_autoload_register('dzitAutoload');

/**
 * Dzit's class auto loader.
 */
function dzitAutoload($className) {
    global $DZIT_IGNORE_AUTOLOAD;
    if (isset($DZIT_IGNORE_AUTOLOAD) && is_array($DZIT_IGNORE_AUTOLOAD)) {
        foreach ($DZIT_IGNORE_AUTOLOAD as $pattern) {
            if (preg_match($pattern, $className)) {
                return FALSE;
            }
        }
    }
    $translator = Ddth_Commons_DefaultClassNameTranslator::getInstance();
    if (!Ddth_Commons_Loader::loadClass($className, $translator)) {
        return FALSE;
    }
    return TRUE;
}

/*
 * Define a token as the include-allow key.
 * Usage: put the following code at the top of your php script.
 * <code>
 * <?php defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
 *
 * ...
 * </code>
 */
define('DZIT_INCLUDE_KEY', 'DZIT_INCLUDE_OK');

$BASE_DIR = __DIR__ . DIRECTORY_SEPARATOR;

/*
 * This is the directory where configuration files are stored.
 * For security reason, it should not be reachable from the web.
 * Note: change the value if your config folder is located at another location!
 */
define('CONFIG_DIR', $BASE_DIR . '../config');
if (!is_dir(CONFIG_DIR)) {
    exit('Invalid CONFIG_DIR setting!');
}

/*
 * This is the directory where 3rd party libraries are located.
 * All 1st level sub-directories of this directory will be included
 * in the include_path.
 * Note: change the value if your config folder is located at another location!
 */
define('LIBS_DIR', $BASE_DIR . '../libs');
if (!is_dir(LIBS_DIR)) {
    exit('Invalid LIBS_DIR setting!');
}

/* set up include path */
$includePath = ini_get('include_path') . PATH_SEPARATOR . '.' . PATH_SEPARATOR . CONFIG_DIR . PATH_SEPARATOR;
if (($dh = @opendir(LIBS_DIR)) !== FALSE) {
    while (($file = readdir($dh)) !== FALSE) {
        if (is_dir(LIBS_DIR . "/$file") && $file != "." && $file != "..") {
            $includePath .= PATH_SEPARATOR . LIBS_DIR . "/$file";
        }
    }
} else {
    exit('Can not open LIBS_DIR!');
}
ini_set('include_path', $includePath);

/*
 * This is the directory where application's modules are located.
 * All 1st level sub-directories of this directory will be included
 * in the include_path.
 * Note: change the value if your module folder is located at another location!
 * Note: if the application does not use module directory.
 */
define('MODULES_DIR', $BASE_DIR . '../modules');

if (defined('MODULES_DIR')) {
    /* set up include path */
    $includePath = ini_get('include_path');
    if (($dh = @opendir(MODULES_DIR)) !== FALSE) {
        while (($file = readdir($dh)) !== FALSE) {
            if (is_dir(MODULES_DIR . "/$file") && $file != "." && $file != "..") {
                $includePath .= PATH_SEPARATOR . MODULES_DIR . "/$file";
            }
        }
    } else {
        exit('Can not open MODULES_DIR!');
    }
    ini_set('include_path', $includePath);
}

set_error_handler("dzitErrorHandler");

function dzitErrorHandler($errno, $errstr, $errfile='', $errline=0, $env=Array(), $stacktrace='') {
    if ( !defined('REPORT_ERROR') ) {
        return FALSE;
    }
?>
<style>
.ui-widget { font-family: Verdana,Arial,sans-serif; font-size: 13px; }
.ui-corner-all { -moz-border-radius-topleft: 4px; -webkit-border-top-left-radius: 4px; -khtml-border-top-left-radius: 4px; border-top-left-radius: 4px; }
.ui-corner-all { -moz-border-radius-topright: 4px; -webkit-border-top-right-radius: 4px; -khtml-border-top-right-radius: 4px; border-top-right-radius: 4px; }
.ui-corner-all { -moz-border-radius-bottomleft: 4px; -webkit-border-bottom-left-radius: 4px; -khtml-border-bottom-left-radius: 4px; border-bottom-left-radius: 4px; }
.ui-corner-all { -moz-border-radius-bottomright: 4px; -webkit-border-bottom-right-radius: 4px; -khtml-border-bottom-right-radius: 4px; border-bottom-right-radius: 4px; }
.ui-state-error {border: 1px solid #cd0a0a; background-color: #fef1ec; color: #cd0a0a; }
</style>
<?php
    //if (!(error_reporting() & $errno)) {
    //    // This error code is not included in error_reporting
    //    return;
    //}
    $halt = FALSE;
    switch ($errno) {
        case E_USER_ERROR:
            $errType = 'ERROR';
            $errMsg = "[$errno] $errstr / PHP " . PHP_VERSION . " (" . PHP_OS . ")";
            $errContent = "Fatal error on line <strong>$errline</strong> in file <strong>$errfile</strong>";
            $halt = TRUE;
            break;

        case E_USER_WARNING:
            $errType = 'WARNING';
            $errMsg = "[$errno] $errstr / PHP " . PHP_VERSION . " (" . PHP_OS . ")";
            $errContent = "Warning on line <strong>$errline</strong> in file <strong>$errfile</strong>";
            break;

        case E_USER_NOTICE:
            $errType = 'NOTICE';
            $errMsg = "[$errno] $errstr / PHP " . PHP_VERSION . " (" . PHP_OS . ")";
            break;

        default:
            $errType = 'UNKNOWN ERROR';
            $errMsg = "[$errno] $errstr / PHP " . PHP_VERSION . " (" . PHP_OS . ")";
            $errContent = "Unknown error on line <strong>$errline</strong> in file <strong>$errfile</strong>";
            break;
    }

    echo '<div class="ui-widget">';
    echo '<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">';
    echo '<p><strong>'.$errType.':</strong> '.$errMsg.'</p>';
    echo '<p>'.$errContent.'</p>';
    if ( $stacktrace == '' ) {
        echo '<pre>';
        debug_print_backtrace();
        echo '</pre>';
    } else {
        echo '<pre>'.$stacktrace.'</pre>';
    }
    echo '</div>';
    echo '</div>';

    if ( $halt ) {
        exit(-1);
    }

    /* Don't execute PHP internal error handler */
    return TRUE;
}

require_once 'Ddth/Commons/ClassDefaultClassNameTranslator.php';
require_once 'Ddth/Commons/ClassLoader.php';

//load the configuration file if exists
if (file_exists(CONFIG_DIR . '/dzit-config.php')) {
    include_once CONFIG_DIR . '/dzit-config.php';
}

//load the bootstrap file if exists
if (file_exists(CONFIG_DIR . '/dzit-bootstrap.php')) {
    include_once CONFIG_DIR . '/dzit-bootstrap.php';
}

$logger = Ddth_Commons_Logging_LogFactory::getLog('Dzit');
try {
    /**
     * @var Dzit_IDispatcher
     */
    $dispatcher = Dzit_Config::get(Dzit_Config::CONF_DISPATCHER);
    if ($dispatcher === NULL || !($dispatcher instanceof Dzit_IDispatcher)) {
        $dispatcher = new Dzit_DefaultDispatcher();
    }
    if ($logger->isDebugEnabled()) {
        $logger->debug("[__CLASS__::__FUNCTION__]Use dispatcher class [" . get_class($dispatcher) . "]");
    }
    $dispatcher->dispatch();
} catch (Exception $e) {
    $logger->error($e->getMessage(), $e);
    dzitErrorHandler(E_USER_ERROR, $e->getMessage(), $e->getFile(), $e->getLine(), Array(), $e->getTraceAsString());
}
