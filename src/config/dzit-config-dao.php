<?php
/*
 * Configurations for Ddth::Dao
 */
global $DPHP_DAO_CONFIG;
$DPHP_DAO_CONFIG = Array('ddth-dao.factoryClass' => 'Ddth_Dao_Adodb_BaseAdodbDaoFactory',
        'dao.simpleBlog' => 'Dzit_Demo_Bo_MysqlSimpleBlogDao');

/*
 * Configurations for Ddth::Adodb
 */
global $DPHP_ADODB_CONFIG;
$DPHP_ADODB_CONFIG = Array('adodb.url' => 'mysql://vcs:vcs@localhost/vcs',
        'adodb.setupSqls' => Array("SET NAMES 'utf8'"));
