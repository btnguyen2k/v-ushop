<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create {@link Ddth_Dao_SqlStatement} objects.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassSqlStatementFactory.php 267 2011-05-23 09:06:50Z btnguyen2k@gmail.com $
 * @since       File available since v0.1.6
 */

/**
 * Factory to create {@link Ddth_Dao_SqlStatement} objects.
 *
 * This factory loads sql statements from a file ({@link Ddth_Commons_Properties .properties format}).
 * Detailed specification of the configuration file is as the following:
 * <code>
 * statement.class = name of the concrete SqlStatement class (must extend Ddth_Dao_SqlStatement)
 *
 * # Each line is a sql statement, in .properties format
 * <name>=<the SQL query>
 *
 * # Examples:
 * sql.selectUserById = SELECT * FROM tbl_user WHERE id=${id}
 * sql.deleteUserByEmail = DELETE FROM tbl_user WHERE email=${email}
 * sql.createUser = INSERT INTO tbl_user (id, username, email) VALUES (${id}, ${username}, ${email})
 *
 * # Note: do NOT use quotes (" or ') around the place-holders.
 * </code>
 *
 * Usage:
 * <code>
 * $configFile = 'user.sql.properties';
 * $factory = Ddth_Dao_SqlStatementFactory::getInstance($configFile);
 * $sqlStm = $factory->getSqlStatement('sql.selectUserById');
 * </code>
 * See {@link Ddth_Dao_SqlStatement here} for more details on how to use {@link Ddth_Dao_SqlStatement}.
 *
 * @package     Dao
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1.6
 */
class Ddth_Dao_SqlStatementFactory {

    const PROP_STATEMENT_CLASS = 'statement.class';

    /**
     * @var Ddth_Commons_Properties
     */
    private $configs;

    private $cache = Array();

    private $stmClass = NULL;

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    private static $staticCache = Array();

    /**
     * Constructs a Ddth_Dao_SqlStatementFactory object from a configuration file.
     *
     * See {@link Ddth_Dao_SqlStatementFactory} for format of the configuration file.
     *
     * @param string $configFile path to the configuration file
     * @return Ddth_Dao_SqlStatementFactory
     */
    public static function getInstance($configFile) {
        $obj = isset(self::$staticCache[$configFile]) ? self::$staticCache[$configFile] : NULL;
        if ($obj === NULL) {
            $fileContent = Ddth_Commons_Loader::loadFileContent($configFile);
            if ($fileContent === NULL || $fileContent === "") {
                return NULL;
            }
            $props = new Ddth_Commons_Properties();
            $props->import($fileContent);
            $obj = new Ddth_Dao_SqlStatementFactory($props);

            self::$staticCache[$configFile] = $obj;
        }
        return $obj;
    }

    /**
     * Constructs a new Ddth_Dao_SqlStatementFactory object.
     *
     * @param Ddth_Commons_Properties $props
     */
    protected function __construct($props) {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        $this->setConfigs($props);
    }

    /**
     * Sets configurations.
     *
     * @param Ddth_Commons_Properties
     */
    public function setConfigs($props) {
        $this->configs = $props;
        $this->stmClass = $props->getProperty(self::PROP_STATEMENT_CLASS);
        if ($this->stmClass === NULL) {
            $msg = 'Invalid statement class [' . $this->stmClass . ']!';
            $this->LOGGER->warn($msg);
        }
        $this->cache = Array(); //clear cache
    }

    /**
     * Gets the configuration object.
     *
     * @return Ddth_Commons_Properties
     */
    protected function getConfigs() {
        return $this->configs;
    }

    /**
     * Gets a SqlStatement.
     *
     * @param string $name identification name of the statement
     * @return Ddth_Dao_SqlStatement the obtained statement, NULL if not found
     */
    public function getSqlStatement($name) {
        $stm = isset($this->cache[$name]) ? $this->cache[$name] : NULL;
        if ($stm === NULL) {
            $sql = $this->configs->getProperty($name);
            /**
             * @var Ddth_Dao_SqlStatement
             */
            $stm = $sql !== NULL ? new $this->stmClass() : NULL;
            if ($stm !== NULL) {
                if (!($stm instanceof Ddth_Dao_SqlStatement)) {
                    $stm = NULL;
                    $msg = "[{$this->stmClass}] is not instance of [Ddth_Dao_SqlStatement]!";
                    $this->LOGGER->error($msg);
                } else {
                    $stm->setSql($sql);
                    $this->cache[$name] = $stm;
                }
            }
        }
        return $stm;
    }
}
?>
