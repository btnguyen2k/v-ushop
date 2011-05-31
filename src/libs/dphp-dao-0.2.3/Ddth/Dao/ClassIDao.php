<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Represents a DAO (business object manager).
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIDao.php 258 2010-12-28 10:39:48Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * This class represents a DAO (business object manager).
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
interface Ddth_Dao_IDao {

    /**
     * Gets a connection to persistent storage.
     *
     * @param bool $startTransaction indicates that if a transaction is automatically started
     * @return mixed the connection, or NULL if the connection can not be created
     */
    public function getConnection($startTransaction=FALSE);

    /**
     * Closes the connection to persistent storage.
     *
     * Normally this function closes the open connection only when necessary. Set $forceClose
     * to force the open connection to be closed.
     *
     * @param bool $hasError indicates that an error has occurred during the usage of the connection
     * @param bool $forceClose force the connection to be closed
     */
    public function closeConnection($hasError=FALSE, $forceClose=FALSE);

    /**
     * Gets the DAO factory instance.
     *
     * @return Ddth_Dao_IDaoFactory
     */
    public function getDaoFactory();

    /**
     * Initializes the DAO.
     *
     * @param Ddth_Dao_IDaoFactory $daoFactory
     */
    public function init($daoFactory);
}
?>
