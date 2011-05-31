<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Thrown to indicate that an error has occurred.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassDaoException.php 258 2010-12-28 10:39:48Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/** */
require_once 'Ddth/Commons/Exceptions/ClassAbstractException.php';

/**
 * Thrown to indicate that an error has occurred.
 *
 * @package    	Dao
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
class Ddth_Dao_DaoException extends Ddth_Commons_Exceptions_AbstractException {

    /**
     * Constructs a new Ddth_Dao_DaoException object.
     *
     * @param string exception message
     * @param int user defined exception code
     */
    public function __construct($message = NULL, $code = 0) {
        parent::__construct($message, $code);
    }
}
?>
