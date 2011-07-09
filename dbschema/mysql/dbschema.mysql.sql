DROP TABLE IF EXISTS app_log;
DROP TABLE IF EXISTS http_session;
DROP TABLE IF EXISTS vcatalog_group;
DROP TABLE IF EXISTS vcatalog_user;
DROP TABLE IF EXISTS vcatalog_paperclip;
DROP TABLE IF EXISTS vcatalog_order_history;
DROP TABLE IF EXISTS vcatalog_cart_detail;
DROP TABLE IF EXISTS vcatalog_cart;
DROP TABLE IF EXISTS vcatalog_item;
DROP TABLE IF EXISTS vcatalog_category;
DROP TABLE IF EXISTS vcatalog_app_config;
DROP TABLE IF EXISTS vcatalog_page;

CREATE TABLE vcatalog_page (
    pid                 VARCHAR(32)         NOT NULL,
    ponmenu             INT                 NOT NULL DEFAULT 0,
        INDEX ponmenu(ponmenu),
    pposition           INT                 NOT NULL DEFAULT 0,
        INDEX pposition (pposition),
    ptitle              VARCHAR(128)        NOT NULL,
    pcontent            TEXT,
    PRIMARY KEY (pid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vcatalog_app_config (
    conf_key            VARCHAR(32)         NOT NULL,
    conf_value          TEXT,
    PRIMARY KEY (conf_key)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO vcatalog_app_config (conf_key, conf_value)
VALUES('site_name', 'vCatalog');
INSERT INTO vcatalog_app_config (conf_key, conf_value)
VALUES('site_title', 'Online Catalog Ecommerce System');
INSERT INTO vcatalog_app_config (conf_key, conf_value)
VALUES('site_slogan', 'Website slogan');
INSERT INTO vcatalog_app_config (conf_key, conf_value)
VALUES('site_keywords', 'catalog, ecommerce');
INSERT INTO vcatalog_app_config (conf_key, conf_value)
VALUES('site_description', 'Online Catalog Ecommerce System');
INSERT INTO vcatalog_app_config (conf_key, conf_value)
VALUES('site_copyright', '(C) 2011 by vCatalog/gpv.com.vn | All Rights Reserved');

CREATE TABLE app_log(
    logid               INT                 NOT NULL AUTO_INCREMENT,
    logTimestamp        INT,
        INDEX logTimestamp(logTimestamp),
    logLevel            VARCHAR(64),
        INDEX logLevel(logLevel),
    logClass            VARCHAR(96),
        INDEX logClass(logClass),
    logMessage          TEXT,
    logStacktrace       TEXT,
    PRIMARY KEY (logid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE http_session (
    sid             VARCHAR(32)             NOT NULL,
    sdata           TEXT,
    PRIMARY KEY(sid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vcatalog_group (
    gid             INT                 NOT NULL AUTO_INCREMENT,
    gname           VARCHAR(32),
    gdesc           VARCHAR(255),
    PRIMARY KEY (gid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO vcatalog_group (gid, gname, gdesc)
VALUES (1, 'Administrator', 'Administrator has all permissions!');
INSERT INTO vcatalog_group (gid, gname, gdesc)
VALUES (2, 'Member', 'Normal member user');

CREATE TABLE vcatalog_user (
    uid             INT                     NOT NULL AUTO_INCREMENT,
    uemail          VARCHAR(64)             NOT NULL,
        UNIQUE INDEX uemail(uemail),
    upassword       VARCHAR(64)             NOT NULL,
    ugroup_id       INT                     NOT NULL DEFAULT 0,
        INDEX ugroup_id(ugroup_id),
    PRIMARY KEY (uid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
-- Administrator account, password is "password" (without quotes, of course!)
INSERT INTO vcatalog_user (uid, uemail, upassword, ugroup_id)
VALUES (1, 'admin@localhost', '5f4dcc3b5aa765d61d8327deb882cf99', 1);

CREATE TABLE vcatalog_category (
    cid             INT                     NOT NULL AUTO_INCREMENT,
    cposition       INT                     NOT NULL DEFAULT 0,
        INDEX cposition(cposition),
    cparent_id      INT,
    ctitle          VARCHAR(64),
    cdesc           VARCHAR(255),
    PRIMARY KEY (cid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vcatalog_item (
    iid             INT                     NOT NULL AUTO_INCREMENT,
    iactive         INT                     NOT NULL DEFAULT 1,
        INDEX iactive(iactive),
    icategory_id    INT,
        INDEX icategory_id(icategory_id),
    ititle          VARCHAR(64)             NOT NULL,
    idesc           TEXT,
    ivendor         VARCHAR(64),
        INDEX ivendor(ivendor),
    itimestamp      INT                     NOT NULL,
        INDEX itimestamp(itimestamp),
    iprice          DECIMAL(10,2)           NOT NULL,
        INDEX iprice(iprice),
    iold_price      DECIMAL(10,2),
    istock          DECIMAL(10,2)           NOT NULL DEFAULT 0.00,
        INDEX istock(istock),
    PRIMARY KEY (iid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vcatalog_cart (
    csession_id         VARCHAR(32)             NOT NULL,
    cstatus             INT                     NOT NULL DEFAULT 0,
        INDEX cstatus(cstatus),
    cupdate_timestamp   INT                     NOT NULL DEFAULT 0,
        INDEX cupdate_timestamp(cupdate_timestamp),
    cuser_id            INT                     NOT NULL DEFAULT 0,
        INDEX cuser_id(cuser_id),
    PRIMARY KEY (csession_id)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vcatalog_cart_item (
    csession_id         VARCHAR(64)             NOT NULL,
    citem_id            INT                     NOT NULL,
    cquantity           DECIMAL(10,2)           NOT NULL,
    cprice              DECIMAL(10,2)           NOT NULL,
    PRIMARY KEY (csession_id, citem_id)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vcatalog_paperclip (
    pid             VARCHAR(64)             NOT NULL,
    pfilename       VARCHAR(64)             NOT NULL,
    pfilesize       BIGINT                  NOT NULL DEFAULT 0,
    pfilecontent    MEDIUMBLOB,
    pthumbnail      BLOB,
    pmimetype       VARCHAR(64)             NOT NULL DEFAULT '',
    ptimestamp      INT                     NOT NULL DEFAULT 0,
    PRIMARY KEY (pid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
