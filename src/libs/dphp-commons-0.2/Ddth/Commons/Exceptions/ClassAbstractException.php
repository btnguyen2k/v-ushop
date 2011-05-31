<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * This class is the top level abstract class of all other exception classes.
 *
 * LICENSE: See the included license.txt file for detail.
 * 
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Commons
 * @subpackage  Exceptions
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAbstractException.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * This class is the top level abstract class of all other exception classes.
 *
 * @package     Commons
 * @subpackage  Exceptions
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
abstract class Ddth_Commons_Exceptions_AbstractException extends Exception {

    /**
     * Constructs a new Ddth_Commons_Exceptions_AbstractException object.
     * 
     * @param string exception message
     * @param int user defined exception code
     */
    public function __construct($message = NULL, $code = 0) {
        parent::__construct($message, $code);
    }
    
    /**
     * Custom string representation of the object.
     * 
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
?>
