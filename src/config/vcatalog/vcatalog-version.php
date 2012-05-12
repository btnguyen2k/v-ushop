<?php
$vCatalogVersion = preg_replace('/\\$Revision:.*?(\\d+).*?$/', '$1', 'v0.6.0.$Revision$');
define('VCATALOG_VERSION', $vCatalogVersion);
/*
 * * 2012-05-12: v0.6.0
 *   - New backend system
 *
 * * 2012-04-20: v0.5.1:
 *   - Added "text ads" support
 *
 * * 2012-03-16: v0.5.1
 *   - Added "new" item feature
 *
 * * 2012-01-01: v0.5.0
 *   - Support paging when viewing category
 */
