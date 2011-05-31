<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * An implementation of {@link Ddth_Dao_IDaoFactory} that is also responsible for creating and closing
 * connections to persistent storage.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAbstractConnDaoFactory.php 267 2011-05-23 09:06:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.2.1
 */

/**
 * An implementation of {@link Ddth_Dao_IDaoFactory} that is also responsible for creating and closing
 * connections to persistent storage.
 * This factory is meant to be used together with {@link Ddth_Dao_AbstractConnDao}.
 *
 * @package     Dao
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2.1
 */
abstract class Ddth_Dao_AbstractConnDaoFactory extends Ddth_Dao_BaseDaoFactory {

    private $conn = NULL;
    private $connCount = 0;

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /**
     * Constructs a new Ddth_Dao_AbstractConnDaoFactory object.
     */
    public function __construct() {
        parent::__construct();
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
    }

    /**
     * Gets a connection to the persistent storage.
     *
     * Note: if this function is called more than once, the same connection is returned.
     * This function also maintains an internal counter to track how many "open" connections
     * are in use.
     *
     * @param bool $startTransaction indicates that if a transaction is automatically started
     * @return mixed the connection, or NULL if the connection can not be created
     */
    public function getConnection($startTransaction = FALSE) {
        if ($this->conn == NULL) {
            if ($this->LOGGER->isDebugEnabled()) {
                $this->LOGGER->debug('Creating new connection...');
            }
            $this->conn = $this->createConnection($startTransaction);
            if ($this->conn === NULL) {
                $msg = 'Can not create new connection!';
                throw new Ddth_Dao_DaoException($msg);
            }
            $this->connCount = 1;
        } else {
            $this->connCount++;
        }
        if ($this->LOGGER->isDebugEnabled()) {
            $this->LOGGER->debug('Connection count: [' . $this->connCount . ']');
        }
        return $this->conn;
    }

    /**
     * Creates a connection to the persistent storage.
     *
     * Sub-class should implement its own function.
     *
     * @param bool $startTransaction indicates that if a transaction is automatically started
     * @return mixed the connection, or NULL if the connection can not be created
     */
    protected abstract function createConnection($startTransaction = FALSE);

    /**
     * Closes an existing connection.
     *
     * Note: by default this function does not close the existing connection if its internal
     * counter is greater than 1.
     *
     * @param bool $hasError indicates that an error has occurred during the usage of the connection
     * @param bool $forceClost force the connection to be closed
     */
    public function closeConnection($hasError = FALSE, $forceClose = FALSE) {
        if ($hasError || $forceClose || $this->connCount < 2) {
            if ($this->LOGGER->isDebugEnabled()) {
                $this->LOGGER->debug('Force closing the connection...');
            }
            $this->forceCloseConnection($this->conn, $hasError);
            $this->conn = NULL;
            $this->connCount = 0;
        } else {
            $this->connCount--;
            if ($this->LOGGER->isDebugEnabled()) {
                $this->LOGGER->debug('Connection count: [' . $this->connCount . ']');
            }
        }
    }

    /**
     * Forces to close the existing connection.
     *
     * @param mixed $conn the current connection this object is holding
     * @param bool $hasError indicates that an error has occurred during the usage of the connection
     */
    protected abstract function forceCloseConnection($conn, $hasError = FALSE);
}
?>
