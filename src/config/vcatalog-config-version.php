<?php
$vCatalogVersion = preg_replace('/\\$Revision:.*?(\\d+).*?$/', '$1', 'v0.1.0.$Revision:28$');
define('VCATALOG_VERSION', $vCatalogVersion);
var_dump($vCatalogVersion);
