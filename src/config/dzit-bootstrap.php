<?php
defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's core bootstrap file.
 * What this bootstrap does?
 * - Setup the "module directory" (default is "../modules"). Each module of the
 *   application is located inside a sub-directory of the "module directory".
 * - Include each module's directory indo the PHP's include path.
 * - Load each module's bootstrap file.
 */

/*
 * Note: Change this if your "modules" directory is located at another location!
 */
define('MODULES_DIR', '../modules');

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

/* load module bootstraps */
$_BOOTSTRAPS = Array();
if ( !defined("MODULE_BOOTSTRAP_FILE") ) {
    define('MODULE_BOOTSTRAP_FILE', 'bootstrap.php');
}
if (($dh = @opendir(MODULES_DIR)) !== FALSE) {
    while (($file = readdir($dh)) !== FALSE) {
        if (is_dir(MODULES_DIR . "/$file") && $file != "." && $file != "..") {
            $bootstrap = MODULES_DIR . "/$file/".MODULE_BOOTSTRAP_FILE;
            if (file_exists($bootstrap)) {
                $_BOOTSTRAPS[] = $bootstrap;
            }
        }
    }
}
//bootstrap files are included in order!
sort($_BOOTSTRAPS);
foreach ($_BOOTSTRAPS as $bootstrap) {
    include_once $bootstrap;
}
