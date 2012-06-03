<?php
defined('DZIT_INCLUDE_KEY') || die('No direct access allowed!');
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

if ( !(ini_get('output_handler') || ini_get('zlib.output_compression')) ) {
    ob_start("ob_gzhandler");
}

/**
 * Dzit's core bootstrap file.
 * What this bootstrap does?
 * - Load each application module's bootstrap file.
 */

if (defined('MODULES_DIR')) {
    /* load module bootstraps */
    $_BOOTSTRAPS = Array();
    if (!defined("MODULE_BOOTSTRAP_FILE")) {
        define('MODULE_BOOTSTRAP_FILE', 'bootstrap.php');
    }
    if (($dh = @opendir(MODULES_DIR)) !== FALSE) {
        while (($file = readdir($dh)) !== FALSE) {
            if (is_dir(MODULES_DIR . "/$file") && $file != "." && $file != "..") {
                $bootstrap = MODULES_DIR . "/$file/" . MODULE_BOOTSTRAP_FILE;
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
}
