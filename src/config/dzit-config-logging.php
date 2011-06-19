<?php
/*
 * Configurations for Ddth::Commons::Logging
 */
global $DPHP_COMMONS_LOGGING_CONFIG;
//$DPHP_COMMONS_LOGGING_CONFIG = Array(
//        'ddth.commons.logging.Logger' => 'Ddth_Commons_Logging_SimpleLog',
//        'logger.setting.default' => IN_DEV_ENV ? 'DEBUG' : 'WARN');
$DPHP_COMMONS_LOGGING_CONFIG = Array('ddth.commons.logging.Logger' => 'Vcatalog_Logging_MysqlLog',
        'logger.setting.default' => IN_DEV_ENV ? 'DEBUG' : 'WARN',
        'logger.setting.mysql.host' => '127.0.0.1',
        'logger.setting.mysql.username' => 'vcatalog',
        'logger.setting.mysql.password' => 'vcatalog',
        'logger.setting.mysql.dbname' => 'vcatalog',
        'logger.setting.mysql.table_name' => 'app_log');
