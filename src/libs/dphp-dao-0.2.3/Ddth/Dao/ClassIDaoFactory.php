<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create {@link Ddth_Dao_IDao} objects.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIDaoFactory.php 258 2010-12-28 10:39:48Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * Factory to create {@link Ddth_Dao_IDao} objects.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
interface Ddth_Dao_IDaoFactory {
    /**
     * Gets a DAO by name.
     *
     * @param Ddth_Dao_IDao $name
     */
    public function getDao($name);

    /**
     * Initializes the DAO factory.
     *
     * @param Array $config
     */
    public function init($config);
}
?>
