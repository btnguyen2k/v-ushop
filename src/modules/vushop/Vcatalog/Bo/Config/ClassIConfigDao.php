<?php
interface Vcatalog_Bo_Config_IConfigDao extends Ddth_Dao_IDao {
    /**
     * Load a config by key.
     *
     * @param string $key
     * @return string
     */
    public function loadConfig($key);

    /**
     * Save a config.
     *
     * @param string $key
     * @param string $value
     */
    public function saveConfig($key, $value);
}