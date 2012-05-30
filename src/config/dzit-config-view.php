<?php
/*
 * Configurations for view resolver
 */
define('SITE_SKINS_ROOT_DIR', 'skins/');
/*
 * View resolver configuration.
 *
 * View resolver is responsible for resolving a {@link Dzit_IView} from a name.
 *
 */
include_once ('Smarty.class.php');
define('SKIN_DIR', SITE_SKINS_ROOT_DIR.'default/');
$params = Array('templateDir' => SKIN_DIR,
        'prefix' => 'page_',
        'suffix' => '.tpl',
        'smartyCacheDir' => '../../../smarty/cache',
        'smartyConfigDir' => '../../../smarty/config',
        'smartyCompileDir' => '../../../smarty/template_c',
        'smartyLeftDelimiter' => '[:',
        'smartyRightDelimiter' => ':]');
$viewResolverClass = 'Dzit_View_SmartyViewResolver';
Dzit_Config::set(Dzit_Config::CONF_VIEW_RESOLVER, new $viewResolverClass($params));
