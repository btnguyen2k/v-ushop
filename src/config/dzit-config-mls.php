<?php
/*
 * Configurations for Ddth::Mls
 */
global $DPHP_MLS_CONFIG;
$DPHP_MLS_CONFIG = Array('factory.class' => 'Ddth_Mls_BaseLanguageFactory',
        //'languages' => 'vn, en',
        'languages' => 'vn',
        'language.baseDirectory' => '../config/language',
        'language.class' => 'Ddth_Mls_FileLanguage',
        'language.vn.location' => 'vi_vn',
        'language.vn.displayName' => 'Tiếng Việt',
        'language.vn.locale' => 'vi_VN',
        'language.vn.description' => 'Ngôn ngữ tiếng Việt',
        'language.en.location' => 'en_us',
        'language.en.displayName' => 'English',
        'language.en.locale' => 'en_US',
        'language.en.description' => 'English (US) language pack');
