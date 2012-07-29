<?php
define('PRODUCT_CODE', 'VUSHOP');

define('WORD_SPLIT_PATTERN', '/[\s,\."\';:]+/');

define('CONFIG_SITE_COPYRIGHT', 'site_copyright');
define('CONFIG_SITE_DESCRIPTION', 'site_description');
define('CONFIG_SITE_KEYWORDS', 'site_keywords');
define('CONFIG_SITE_NAME', 'site_name');
define('CONFIG_SITE_SLOGAN', 'site_slogan');
define('CONFIG_SITE_TITLE', 'site_title');

define('CONFIG_SITE_SKIN', 'site_skin');

define('CONFIG_USE_SMTP', 'use_smtp');
define('CONFIG_SMTP_HOST', 'smtp_host');
define('CONFIG_SMTP_PORT', 'smtp_port');
define('CONFIG_SMTP_SSL', 'smtp_ssl');
define('CONFIG_SMTP_USERNAME', 'smtp_username');
define('CONFIG_SMTP_PASSWORD', 'smtp_password');
define('CONFIG_EMAIL_OUTGOING', 'email_outgoing');
define('CONFIG_EMAIL_ORDER_NOTIFICATION', 'email_order_notification');
define('CONFIG_EMAIL_ON_SUBJECT', 'email_on_subject');
define('CONFIG_EMAIL_ON_BODY', 'email_on_body');

define('CONFIG_CURRENCY', 'currency');
define('CONFIG_PRICE_DECIMAL_PLACES', 'price_decimal_places');
define('CONFIG_QUANTITY_DECIMAL_PLACES', 'quantity_decimal_places');
define('CONFIG_DECIMAL_SEPARATOR', 'decimal_separator');
define('CONFIG_THOUSANDS_SEPARATOR', 'thousands_separator');
define('CONFIG_THUMBNAIL_WIDTH', 'thumbnail_width');
define('CONFIG_THUMBNAIL_HEIGHT', 'thumbnail_height');

define('MAX_UPLOAD_FILESIZE', 300000);
define('ALLOWED_UPLOAD_FILE_TYPES', '*.gif,*.jpg;.*.png');

define('THUMBNAIL_WIDTH', 230);
define('THUMBNAIL_HEIGHT', 200);

define('FORM_ERROR_MESSAGES', 'errorMessages');
define('FORM_INFO_MESSAGES', 'infoMessages');

define('MODEL_APP_NAME', 'APP_NAME');
define('MODEL_APP_VERSION', 'APP_VERSION');

define('MODEL_REQUEST_MODULE', 'reqModule');
define('MODEL_REQUEST_ACTION', 'reqAction');

define('MODEL_SHOP_OWNERS', 'shopOwners');
define('MODEL_USER_LIST', 'userList');
define('MODEL_CATEGORY_TREE', 'categoryTree');
define('MODEL_CATEGORY_LIST', 'categoryList');
define('MODEL_CART', 'cart');
define('MODEL_PAGE_LIST', 'pageList');
define('MODEL_ADS_LIST', 'adsList');
define('MODEL_ITEM_LIST', 'itemList');
define('MODEL_HOT_ITEMS', 'hotItems');
define('MODEL_NEW_ITEMS', 'newItems');
define('MODEL_FEATURED_ITEMS', 'featuredItems');
define('MODEL_ONMENU_PAGES', 'onMenuPages');
define('MODEL_ALL_PAGES_BY_CATEGORY', 'allPagesByCat');
define('MODEL_INFO_MESSAGES', 'infoMessages');
define('MODEL_ERROR_MESSAGES', 'errorMessages');
define('MODEL_TRANSIT_MESSAGE', 'transitMessage');
define('MODEL_URL_TRANSIT', 'urlTransit');
define('MODEL_PAGINATOR', 'paginator');
define('MODEL_DEBUG', 'debug');

define('CATEGORY_NAME', 'categoryName');

define('SESSION_ITEM_SORTING', 'ITEM_SORTING');
define('SESSION_LAST_ACCESS_URL', 'LAST_ACCESS_URL');
define('SESSION_USER_ID', 'USER_ID');
define('SESSION_LANGUAGE_NAME', 'LANGUAGE_NAME');

define('FEATURED_ITEM_NONE', 0);
define('FEATURED_ITEM_HOT' , 1);
define('FEATURED_ITEM_NEW' , 2);
define('FEATURED_ITEM_ALL' , 3);

define('DEFAULT_ITEM_SORTING', 'timedesc');
define('ITEM_SORTING_TIMEDESC', 'timedesc');
define('ITEM_SORTING_TIMEASC', 'timeasc');
define('ITEM_SORTING_PRICEDESC', 'pricedesc');
define('ITEM_SORTING_PRICEASC', 'priceasc');
define('ITEM_SORTING_TITLE', 'title');

define('PAGE_ATTR_ONMENU', 1);

define('DEFAULT_PAGE_SIZE', 10);

define('USER_GROUP_GUEST', 0);
define('USER_GROUP_ADMIN', 1);
define('USER_GROUP_SHOP_OWNER', 2);

define('DAO_SITE', 'dao.site');


define('DAO_CATALOG', 'dao.catalog');
define('DAO_CART', 'dao.cart');
define('DAO_SHOP', 'dao.shop');
define('DAO_CONFIG', 'dao.config');
define('DAO_PAGE', 'dao.page');
define('DAO_TEXTADS', 'dao.textAds');
define('DAO_PAPERCLIP', 'dao.paperclip');
define('DAO_SESSION', 'dao.session');
define('DAO_USER', 'dao.user');
define('DAO_PROFILE', 'dao.profile');
