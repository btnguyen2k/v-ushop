<?php
/*
 * Configurations for Ddth::Commons::Logging
 */

global $DPHP_COMMONS_LOGGING_CONFIG_SIMPLE;
$DPHP_COMMONS_LOGGING_CONFIG_SIMPLE = Array(
        'ddth.commons.logging.Logger' => 'Ddth_Commons_Logging_SimpleLog',
        'logger.setting.default' => 'WARN');

global $DPHP_COMMONS_LOGGING_CONFIG_MYSQL;
$DPHP_COMMONS_LOGGING_CONFIG_MYSQL = Array(
        'ddth.commons.logging.Logger' => 'Vushop_Logging_MysqlLog',
        'logger.setting.default' => 'WARN',
        'logger.setting.mysql.host' => '127.0.0.1',
        'logger.setting.mysql.username' => 'vushop',
        'logger.setting.mysql.password' => 'vushop',
        'logger.setting.mysql.dbname' => 'vushop',
        'logger.setting.mysql.table_name' => 'app_log');

global $DPHP_COMMONS_LOGGING_CONFIG_PGSQL;
$DPHP_COMMONS_LOGGING_CONFIG_PGSQL = Array(
        'ddth.commons.logging.Logger' => 'Vushop_Logging_PgsqlLog',
        'logger.setting.default' => 'WARN',
        'logger.setting.pgsql.host' => '127.0.0.1',
        'logger.setting.pgsql.username' => 'vushop',
        'logger.setting.pgsql.password' => 'vushop',
        'logger.setting.pgsql.dbname' => 'vushop',
        'logger.setting.pgsql.table_name' => 'app_log');

global $DPHP_COMMONS_LOGGING_CONFIG;
if (IN_DEV_ENV) {
    $DPHP_COMMONS_LOGGING_CONFIG = &$DPHP_COMMONS_LOGGING_CONFIG_SIMPLE;
} else {
    $dbType = getenv('VUSHOP_DBTYPE');
    if ($dbType !== FALSE) {
        if (strtoupper($dbType) == 'MYSQL') {
            $DPHP_COMMONS_LOGGING_CONFIG = &$DPHP_COMMONS_LOGGING_CONFIG_MYSQL;
        } elseif (strtoupper($dbType) == 'PGSQL' || strtoupper($dbType) == 'POSTGRES' || strtoupper($dbType) == 'POSTGRESQL') {
            $DPHP_COMMONS_LOGGING_CONFIG = &$DPHP_COMMONS_LOGGING_CONFIG_PGSQL;
        }
    } else {
        $DPHP_COMMONS_LOGGING_CONFIG = &$DPHP_COMMONS_LOGGING_CONFIG_MYSQL;
    }
}
