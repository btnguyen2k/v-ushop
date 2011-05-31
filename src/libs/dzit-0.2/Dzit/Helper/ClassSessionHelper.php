<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Helper: Session manipulating.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @subpackage  Helper
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSessionHelper.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * Helper: Session manipulating.
 *
 * @package     Dzit
 * @subpackage  Helper
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_Helper_SessionHelper {
    /**
     * Sets a http session attribute.
     *
     * @param string $name name of the session attribute
     * @param mixed $value value of the session attribute
     * @param int $maxIdleTime (optional) max idle time (in seconds) of the session attribute
     */
    public static function setSessionAttribute($name, $value, $maxIdleTime=0) {
        if ( $maxIdleTime > 0 ) {
            $value = new Dzit_Session_SessionAttributeWrapper($name, $value, $maxIdleTime);
            //if ( ini_get('session.gc_maxlifetime') < $maxIdleTime ) {
            //    ini_set('session.gc_maxlifetime', $maxIdleTime);
            //}
        }
        $_SESSION[$name] = $value;
    }

    /**
     * Gets a http session attribute by name.
     *
     * @param string $name name of the session attribute
     * @return mixed the session attribute value, or NULL if not found or expired
     */
    public static function getSessionAttribute($name) {
        $value = isset($_SESSION[$name])?$_SESSION[$name]:NULL;
        if ( $value instanceof Dzit_Session_SessionAttributeWrapper ) {
            $value = $value->getValue();
            if ( $value == NULL ) {
                //timed out
                unset($_SESSION[$name]);
            }
        }
        return $value;
    }
}
?>
