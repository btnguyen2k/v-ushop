<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Abstract SqlStatement implementation of {@link Ddth_Dao_IDao}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassAbstractSqlStatementDao.php 273 2011-05-24 09:35:16Z btnguyen2k@gmail.com $
 * @since       File available since v0.2.3
 */

/**
 * Abstract SqlStatement implementation of {@link Ddth_Dao_IDao}.
 *
 * This abstract implementation of {@link Ddth_Dao_IDao} utilizes {@link Ddth_Dao_SqlStatement}
 * to interact with the persistent storage.
 *
 * @package    	Dao
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2.1
 */
abstract class Ddth_Dao_AbstractSqlStatementDao extends Ddth_Dao_AbstractConnDao {

    private $sqlStmFactory;
    private $sqlStmFile;

    /**
     * Gets name of the sql statement file.
     *
     * @return string
     */
    protected function getSqlStatementFile() {
        return $this->sqlStmFile;
    }

    /**
     * Sets the sql statement file.
     *
     * @param string $sqlStmFile
     */
    public function setSqlStatementFile($sqlStmFile) {
        $this->sqlStmFile = $sqlStmFile;
    }

    /**
     * @see Ddth_Dao_IDao::init()
     */
    public function init($daoFactory) {
        parent::init($daoFactory);
        $this->initSqlStatementFactory();
    }

    /**
     * Initializes the {@link Ddth_Dao_SqlStatementFactory} instance.
     */
    protected function initSqlStatementFactory() {
        $configFile = $this->getSqlStatementFile();
        $this->sqlStmFactory = Ddth_Dao_SqlStatementFactory::getInstance($configFile);
    }

    /**
     * Gets the {@link Ddth_Dao_SqlStatementFactory} instance.
     *
     * @return Ddth_Dao_SqlStatementFactory
     */
    protected function getSqlStatementFactory() {
        return $this->sqlStmFactory;
    }

    /**
     * Gets a {@link Ddth_Dao_SqlStatement} by name.
     *
     * @param string $name
     * @return Ddth_Dao_SqlStatement
     */
    protected function getSqlStatement($name) {
        $stm = $this->sqlStmFactory->getSqlStatement($name);
        if ($stm === NULL || $stm === FALSE) {
            throw new Ddth_Dao_DaoException("Can not get the statement [$name]!");
        }
        return $stm;
    }
}
?>
