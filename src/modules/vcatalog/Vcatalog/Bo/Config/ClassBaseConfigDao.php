<?php
abstract class Vcatalog_Bo_Config_BaseConfigDao extends Commons_Bo_BaseDao implements
        Vcatalog_Bo_Config_IConfigDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Bo_Config_IConfigDao::loadConfig()
     */
    public function loadConfig($key) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('key' => $key);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $result = $this->fetchResultAssoc($rs);

        $this->closeConnection();
        return $result !== FALSE ? $result['value'] : NULL;
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Bo_Config_IConfigDao::saveConfig()
     */
    public function saveConfig($key, $value) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('key' => $key, 'value' => $value);
        $sqlStm->execute($sqlConn->getConn(), $params);
        $this->closeConnection();
    }
}
