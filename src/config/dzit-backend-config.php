<?php
defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's core configuration file.
 */

function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    $start = $length * -1; // negative
    return (substr($haystack, $start) === $needle);
}

/*
 * If environment variable DEV_ENV exists then we are on development server.
 */
define('IN_DEV_ENV', getenv('DEV_ENV') || $_SERVER['SERVER_NAME'] == 'localhost' || endsWith($_SERVER['SERVER_NAME'], '.local') || isset($_GET['_DEBUG_']));

if (IN_DEV_ENV) {
    define('REPORT_ERROR', TRUE);
    define('PROFILING', TRUE);
} elseif (rand(1, 10) < 3) {
    define('PROFILING', TRUE);
}

/*
 * If CLI_MODE is TRUE, the application is running in CLI (command line
 * interface) mode.
 */
define('CLI_MODE', strtolower(php_sapi_name()) == 'cli' && empty($_SERVER['REMOTE_ADDR']));

/*
 * Since PHP 5.3, you should not rely on the default time zone setting any more!
 * Do set your own timezone here!
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');

/*
 * Put list of classes that should be ignored by Dzit's auto loading. Note: PCRE
 * regular expression supported (http://www.php.net/manual/en/pcre.pattern.php).
 */
global $DZIT_IGNORE_AUTOLOAD;
$DZIT_IGNORE_AUTOLOAD = Array('/^Smarty_*/', '/^Yadif_*/');

include 'vcatalog/vcatalog-config-constants.php';
include 'vcatalog/vcatalog-backend-config-version.php';

include 'dzit-config-logging.php';
include 'dzit-config-cache.php';
include 'dzit-config-dao.php';

include 'dzit-backend-config-mls.php';
include 'dzit-backend-config-router.php';
include 'dzit-backend-config-view.php';

/*
 * Configure the url creator.
 */
Dzit_Config::set(Dzit_Config::CONF_URL_CREATOR, new Dzit_DefaultUrlCreator());

/*
 * Name of the default language pack.
 */
Dzit_Config::set(Dzit_Config::CONF_DEFAULT_LANGUAGE_NAME, 'vn');

/*
 * Name of the default template pack.
 */
Dzit_Config::set(Dzit_Config::CONF_DEFAULT_TEMPLATE_NAME, 'default');

/*
 * Name of the module's bootstrap file.
 */

define('MODULE_BOOTSTRAP_FILE', 'bootstrap.php');
