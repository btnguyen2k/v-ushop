<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Thrown to indicate that the commons logging configuration file contains
 * error or a logger instance can not be created.
 *
 * LICENSE: See the included license.txt file for detail.
 * 
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Commons
 * @subpackage  Logging
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassLogConfigurationException.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/** */
require_once 'Ddth/Commons/Exceptions/ClassAbstractException.php';

/**
 * Thrown to indicate that the commons logging configuration file contains
 * error or a logger instance can not be created.
 *
 * @package     Commons
 * @subpackage  Logging
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL 3.0
 * @since       Class available since v0.1
 */
class Ddth_Commons_Logging_LogConfigurationException extends Ddth_Commons_Exceptions_AbstractException {

    /**
     * Constructs a new Ddth_Commons_Logging_LogConfigurationException object.
     * 
     * @param string exception message
     * @param int user defined exception code
     */
    public function __construct($message = NULL, $code = 0) {
        parent::__construct($message, $code);
    }
}
?>
