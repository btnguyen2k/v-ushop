DROP TABLE IF EXISTS app_profile_detail;
DROP TABLE IF EXISTS app_profile;
DROP TABLE IF EXISTS app_log;
DROP TABLE IF EXISTS vushop_tag;
DROP TABLE IF EXISTS vushop_group;
DROP TABLE IF EXISTS vushop_paperclip;
DROP TABLE IF EXISTS vushop_cart_item;
DROP TABLE IF EXISTS vushop_cart;
DROP TABLE IF EXISTS vushop_item;
DROP TABLE IF EXISTS vushop_shop;
DROP TABLE IF EXISTS vushop_user;
DROP TABLE IF EXISTS vushop_category;
DROP TABLE IF EXISTS vushop_app_config;
DROP TABLE IF EXISTS vushop_page;
DROP TABLE IF EXISTS vushop_textads;
DROP TABLE IF EXISTS http_session;
DROP TABLE IF EXISTS vushop_order_detail;
DROP TABLE IF EXISTS vushop_order;

CREATE TABLE vushop_textads (
    aid                 INT                 NOT NULL AUTO_INCREMENT,
    atitle              VARCHAR(128),
    aurl                VARCHAR(255),
    aclicks             INT                 NOT NULL DEFAULT 0,
    aimage_id           VARCHAR(64),
    atimestamp          TIMESTAMP,
    PRIMARY KEY (aid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_page (
    pid                 VARCHAR(32)         NOT NULL,
    pattr               INT                 NOT NULL DEFAULT 0,
        INDEX (pattr),
    pposition           INT                 NOT NULL DEFAULT 0,
        INDEX (pposition),
    pcategory           VARCHAR(64)         NOT NULL DEFAULT '',
        INDEX (pcategory),
    ptitle              VARCHAR(128)        NOT NULL DEFAULT '',
    pcontent            TEXT,
    PRIMARY KEY (pid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_app_config (
    conf_key            VARCHAR(32)         NOT NULL,
    conf_value          TEXT,
    PRIMARY KEY (conf_key)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('site_name', 'v-uShop');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('site_title', 'Your Shop Online');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('site_slogan', 'Website slogan');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('site_keywords', 'shopping, ecommerce');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('site_description', 'Online Shop System');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('site_copyright', '(C) 2011 by v-uShop/gpv.com.vn | All Rights Reserved');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('site_skin', 'default');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('use_smtp', '1');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('smtp_host', 'localhost');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('smtp_port', '25');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('smtp_ssl', '0');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('smtp_username', '');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('smtp_password', '');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('email_outgoing', 'your_outgoing_email@here.com');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('email_order_notification', 'your_email_to_receive_order_notification@here.com');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('email_on_subject', '{SITE_NAME} New order from {ORDER_NAME}');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('email_on_body',
'<p>You have a new order from <b>{ORDER_NAME}</b> <i>(Email: {ORDER_EMAIL} / Phone: {ORDER_PHONE})</i></p>
<p>Order details:</p>
{ORDER_ITEMS}
<p>Payment method: <b>{PAYMENT_METHOD}</b></p>
<p>Additional information:</p>
{ORDER_OTHER_INFO}');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('currency', 'VND');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('price_decimal_places', '0');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('quantity_decimal_places', '0');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('decimal_separator', ',');
INSERT INTO vushop_app_config (conf_key, conf_value)
VALUES('thousands_separator', '.');

CREATE TABLE app_log(
    logid               INT                 NOT NULL AUTO_INCREMENT,
    logTimestamp        INT,
        INDEX (logTimestamp),
    logLevel            VARCHAR(64),
        INDEX (logLevel),
    logClass            VARCHAR(96),
        INDEX (logClass),
    logMessage          TEXT,
    logStacktrace       TEXT,
    PRIMARY KEY (logid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE app_profile (
    pid                 VARCHAR(16)         NOT NULL,
    purl                VARCHAR(64),
    ptimestamp          TIMESTAMP           NOT NULL,
    pduration           DOUBLE              NOT NULL DEFAULT 0.0,
    pdetail             TEXT,
    PRIMARY KEY (pid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE app_profile_detail (
    pid                 VARCHAR(16)         NOT NULL,
    pdid                VARCHAR(16)         NOT NULL,
        INDEX (pid, pdid),
        FOREIGN KEY (pid) REFERENCES app_profile(pid) ON DELETE CASCADE,
    pdparent_id         VARCHAR(16),
    pdname              VARCHAR(64),
    pdduration          DOUBLE              NOT NULL DEFAULT 0.0
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE http_session (
    session_id                  VARCHAR(32)             NOT NULL,
    session_timestamp           INT                     NOT NULL DEFAULT 0,
        INDEX (session_timestamp),
    session_data               LONGTEXT,
    PRIMARY KEY(session_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_group (
    gid             INT                 NOT NULL AUTO_INCREMENT,
    gname           VARCHAR(32),
    gdesc           VARCHAR(255),
    PRIMARY KEY (gid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO vushop_group (gid, gname, gdesc)
VALUES (1, 'Administrator', 'Administrator has all permissions!');
INSERT INTO vushop_group (gid, gname, gdesc)
VALUES (2, 'ShopOwner', 'Shop Owner');
INSERT INTO vushop_group (gid, gname, gdesc)
VALUES (3, 'Member', 'Member');

CREATE TABLE vushop_user (
    uid             INT                     NOT NULL AUTO_INCREMENT,
    uusername       VARCHAR(32)             NOT NULL,
        UNIQUE INDEX (uusername),
    uemail          VARCHAR(64)             NOT NULL,
        UNIQUE INDEX (uemail),
    upassword       VARCHAR(64)             NOT NULL,
    ugroup_id       INT                     NOT NULL DEFAULT 0,
        INDEX (ugroup_id),
    utitle          VARCHAR(32),
    ufullname       VARCHAR(64),
    ulocation       VARCHAR(64),
    PRIMARY KEY (uid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
-- Administrator account, password is "password" (without quotes, of course!)
INSERT INTO vushop_user (uid, uusername, uemail, upassword, ugroup_id)
VALUES (1, 'admin', 'admin@localhost', '5f4dcc3b5aa765d61d8327deb882cf99', 1);

CREATE TABLE vushop_shop (
    sowner          INT                     NOT NULL DEFAULT 0,
        FOREIGN KEY (sowner) REFERENCES vushop_user(uid) ON DELETE CASCADE,
    sposition       INT                     NOT NULL DEFAULT 0,
        INDEX(sposition),
    stitle          VARCHAR(64)             NOT NULL DEFAULT '',
    slocation       TEXT,
    sdesc           TEXT,
    simage_id       VARCHAR(64),
        INDEX (simage_id),
    PRIMARY KEY (sowner)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_category (
    cid             INT                     NOT NULL AUTO_INCREMENT,
    cposition       INT                     NOT NULL DEFAULT 0,
        INDEX (cposition),
    cparent_id      INT,
    ctitle          VARCHAR(64),
    cdesc           VARCHAR(255),
    cimage_id       VARCHAR(64),
        INDEX (cimage_id),
    PRIMARY KEY (cid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_item (
    iid             INT                     NOT NULL AUTO_INCREMENT,
    iactive         INT                     NOT NULL DEFAULT 1,
        INDEX (iactive),
    icategory_id    INT,
        INDEX (icategory_id),
        FOREIGN KEY (icategory_id) REFERENCES vushop_category(cid) ON DELETE SET NULL,
    iowner_id       INT,
        INDEX (iowner_id),
        FOREIGN KEY (iowner_id) REFERENCES vushop_shop(sowner) ON DELETE CASCADE,
    ititle          VARCHAR(64)             NOT NULL,
    idesc           TEXT,
    ivendor         VARCHAR(64),
        INDEX (ivendor),
    icode           VARCHAR(32),
        INDEX (icode),
    itimestamp      INT                     NOT NULL,
        INDEX (itimestamp),
    iprice          DECIMAL(10,2)           NOT NULL,
        INDEX (iprice),
    iold_price      DECIMAL(10,2),
    istock          DECIMAL(10,2)           NOT NULL DEFAULT 0.00,
        INDEX (istock),
    iimage_id       VARCHAR(64),
        INDEX (iimage_id),
    ihot_item       INT                     NOT NULL DEFAULT 0,
        INDEX (ihot_item),
    inew_item       INT                     NOT NULL DEFAULT 0,
        INDEX (inew_item),
    PRIMARY KEY (iid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_tag (
    titem_id        INT                     NOT NULL,
    ttag            VARCHAR(32)             COLLATE utf8_bin NOT NULL,
        INDEX (ttag),
    ttype           INT                     NOT NULL DEFAULT 0,
        INDEX (ttype),
    PRIMARY KEY (titem_id, ttag, ttype),
    FOREIGN KEY (titem_id) REFERENCES vushop_item(iid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_cart (
    csession_id         VARCHAR(32)             NOT NULL,
    cstatus             INT                     NOT NULL DEFAULT 0,
        INDEX (cstatus),
    cupdate_timestamp   INT                     NOT NULL DEFAULT 0,
        INDEX (cupdate_timestamp),
    cuser_id            INT                     NOT NULL DEFAULT 0,
        INDEX (cuser_id),
    PRIMARY KEY (csession_id)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_cart_item (
    csession_id         VARCHAR(64)             NOT NULL,
    citem_id            INT                     NOT NULL,
    cquantity           DECIMAL(10,2)           NOT NULL,
    cprice              DECIMAL(10,2)           NOT NULL,
    PRIMARY KEY (csession_id, citem_id),
    FOREIGN KEY (csession_id) REFERENCES vushop_cart(csession_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_paperclip (
    pid             VARCHAR(64)             NOT NULL,
    pfilename       VARCHAR(64)             NOT NULL,
    pfilesize       BIGINT                  NOT NULL DEFAULT 0,
    pfilecontent    MEDIUMBLOB,
    pimg_width      INT                     NOT NULL DEFAULT 0,
    pimg_height     INT                     NOT NULL DEFAULT 0,
    pthumbnail      BLOB,
    pmimetype       VARCHAR(64)             NOT NULL DEFAULT '',
    ptimestamp      INT                     NOT NULL DEFAULT 0,
        INDEX (ptimestamp),
    pis_draft       INT                     NOT NULL DEFAULT 0,
        INDEX (pis_draft),
    PRIMARY KEY (pid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE vushop_order (
    oid         				VARCHAR(64)             NOT NULL,   
    otimestamp      			INT                     NOT NULL DEFAULT 0,
        INDEX (otimestamp),
    ofull_name          		VARCHAR(64)				NOT NULL DEFAULT '',
    oemail          			VARCHAR(64)				NOT NULL DEFAULT '',
    ophone						VARCHAR(64)				NOT NULL DEFAULT '',
    opayment_method				TINYINT(1)				NOT NULL DEFAULT 0,
    oaddress					TEXT, 
    PRIMARY KEY (oid)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vushop_order_detail (   
    order_id            			VARCHAR(64)             NOT NULL,
    	INDEX (order_id),
    odetail_item_id            		INT                     NOT NULL,
    	INDEX (odetail_item_id),   
    odetail_quantity           		DECIMAL(10,2)           NOT NULL,
    odetail_price              		DECIMAL(10,2)           NOT NULL, 
    odetail_status	             	TINYINT(1)            	NOT NULL DEFAULT 0,
        INDEX (odetail_status),
   	odetail_timestamp      			INT                     NOT NULL DEFAULT 0,
        INDEX (odetail_timestamp),
    PRIMARY KEY (order_id,odetail_item_id),
    FOREIGN KEY (order_id) REFERENCES vushop_order(oid) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
