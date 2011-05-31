<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Thrown to indicate that a method has been passed an illegal or inappropriate argument.
 *
 * LICENSE: See the included license.txt file for detail.
 * 
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Commons
 * @subpackage  Exceptions
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIllegalArgumentException.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/** */
require_once 'ClassAbstractException.php';

/**
 * Thrown to indicate that a method has been passed an illegal or inappropriate argument.
 *
 * @package     Commons
 * @subpackage  Exceptions
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
class Ddth_Commons_Exceptions_IllegalArgumentException extends Ddth_Commons_Exceptions_AbstractException {

    /**
     * Constructs a new Ddth_Commons_Exceptions_IllegalArgumentException object.
     *
     * @param string exception message
     * @param int user defined exception code
     */
    public function __construct($message = "Invalid argument!", $code = 0) {
        parent::__construct($message, $code);
    }
}
?>
