<?php
$vCatalogVersion = preg_replace('/\\$Revision:.*?(\\d+).*?$/', '$1', 'v0.5.0.$Revision$');
define('VCATALOG_VERSION', $vCatalogVersion);
/*
 * * 2012-01-01: v0.5.0
 *   - Support paging when viewing category
 */