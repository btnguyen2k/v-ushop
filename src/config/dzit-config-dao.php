<?php
/*
 * Configurations for Ddth::Dao
*/
include_once 'dzit-config-dao-mysql.php';
//include_once 'dzit-config-dao-pgsql.php';

$dbType = getenv('VUSHOP_DBTYPE');
if ($dbType !== FALSE) {
    if (strtoupper($dbType) == 'MYSQL') {
        global $DPHP_DAO_CONFIG_SITE;
        $DPHP_DAO_CONFIG_SITE = &$DPHP_DAO_CONFIG_MYSQL_SITE;

        global $DPHP_DAO_CONFIG;
        $DPHP_DAO_CONFIG = &$DPHP_DAO_CONFIG_MYSQL;
    } elseif (strtoupper($dbType) == 'PGSQL' || strtoupper($dbType) == 'POSTGRES' || strtoupper($dbType) == 'POSTGRESQL') {
        global $DPHP_DAO_CONFIG_SITE;
        $DPHP_DAO_CONFIG_SITE = &$DPHP_DAO_CONFIG_PGSQL_SITE;

        global $DPHP_DAO_CONFIG;
        $DPHP_DAO_CONFIG = &$DPHP_DAO_CONFIG_PGSQL;
    } else {
        die("[$dbType] is not supported!");
    }
} else {
    // MySQL by default
    global $DPHP_DAO_CONFIG_SITE;
    $DPHP_DAO_CONFIG_SITE = &$DPHP_DAO_CONFIG_MYSQL_SITE;

    global $DPHP_DAO_CONFIG;
    $DPHP_DAO_CONFIG = &$DPHP_DAO_CONFIG_MYSQL;
}
