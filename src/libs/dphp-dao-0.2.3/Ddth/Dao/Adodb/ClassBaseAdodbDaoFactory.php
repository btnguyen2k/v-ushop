<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create {@link Ddth_Dao_Adodb_IAdodbDao} instances.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @subpackage  Adodb
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassBaseAdodbDaoFactory.php 267 2011-05-23 09:06:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.2
 */

/**
 * Factory to create {@link Ddth_Dao_Adodb_IAdodbDao} instances. This can be used as a base
 * implementation of Adodb-based DAO factory.
 *
 * This factory uses the same configuration array as {@link Ddth_Dao_BaseDaoFactory}.
 *
 * @package     Dao
 * @subpackage  Adodb
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Ddth_Dao_Adodb_BaseAdodbDaoFactory extends Ddth_Dao_AbstractConnDaoFactory {

    /**
     * @var Ddth_Adodb_IAdodbFactory
     */
    private $adodbFactory;

    /**
     * Constructs a new Ddth_Dao_Adodb_BaseAdodbDaoFactory object.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @see Ddth_Dao_IDaoFactory::init();
     */
    public function init($config) {
        parent::init($config);
        $this->adodbFactory = Ddth_Adodb_AdodbFactory::getInstance();
    }

    /**
     * Gets the Adodb factory.
     *
     * @return Ddth_Adodb_IAdodbFactory
     */
    protected function getAdodbFactory() {
        return $this->adodbFactory;
    }

    /**
     * Sets the Adodb factory.
     *
     * @param Ddth_Adodb_IAdodbFactory $adodbFactory
     */
    protected function setAdodbFactory($adodbFactory) {
        $this->adodbFactory = $adodbFactory;
    }

    /**
     * Gets a DAO by name.
     *
     * @param string $name
     * @return Ddth_Dao_Adodb_IAdodbDao
     * @throws Ddth_Dao_DaoException
     */
    public function getDao($name) {
        $dao = parent::getDao($name);
        if ($dao !== NULL && !($dao instanceof Ddth_Dao_Adodb_IAdodbDao)) {
            $msg = 'DAO [' . $name . '] is not of type [Ddth_Dao_Adodb_IAdodbDao]!';
            throw new Ddth_Dao_DaoException($msg);
        }
        return $dao;
    }

    /**
     * @see Ddth_Dao_AbstractConnDaoFactory::createConnection()
     */
    protected function createConnection($startTransaction = FALSE) {
        return $this->adodbFactory->getConnection($startTransaction);
    }

    /**
     * @see Ddth_Dao_AbstractConnDaoFactory::forceCloseConnection()
     */
    protected function forceCloseConnection($conn, $hasError = FALSE) {
        $this->adodbFactory->closeConnection($conn, $hasError);
    }
}
?>
