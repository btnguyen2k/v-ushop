<?php
/*
 * Configurations for Ddth::Dao
 */
global $DPHP_DAO_CONFIG;
$DPHP_DAO_CONFIG = Array('dphp-dao.factoryClass' => 'Ddth_Dao_Mysql_BaseMysqlDaoFactory',
        'dphp-dao.mysql.host' => '127.0.0.1',
        'dphp-dao.mysql.username' => 'vlistings',
        'dphp-dao.mysql.password' => 'vlistings',
        'dphp-dao.mysql.database' => 'vlistings',
        'dao.session' => 'Vlistings_Bo_Session_MysqlSessionDao');
