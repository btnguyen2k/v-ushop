<?php
/* vCatalog's boostrap file */

$configDao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao(DAO_CONFIG);
$siteSkin = $configDao->loadConfig(CONFIG_SITE_SKIN);
if ($siteSkin == NULL || $siteSkin == '') {
    $siteSkin = 'default';
}

$skinDir = SITE_SKINS_ROOT_DIR . "$siteSkin/";
$params = Array('templateDir' => $skinDir,
        'prefix' => 'page_',
        'suffix' => '.tpl',
        'smartyCacheDir' => '../../../smarty/cache',
        'smartyConfigDir' => '../../../smarty/config',
        'smartyCompileDir' => '../../../smarty/template_c',
        'smartyLeftDelimiter' => '[:',
        'smartyRightDelimiter' => ':]');
$viewResolverClass = 'Dzit_View_SmartyViewResolver';
Dzit_Config::set(Dzit_Config::CONF_VIEW_RESOLVER, new $viewResolverClass($params));
