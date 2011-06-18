DROP TABLE IF EXISTS app_log;
DROP TABLE IF EXISTS http_session;
DROP TABLE IF EXISTS vlistings_group;
DROP TABLE IF EXISTS vlistings_user;
DROP TABLE IF EXISTS vlistings_paperclip;
DROP TABLE IF EXISTS vlistings_item;
DROP TABLE IF EXISTS vlistings_category;
DROP TABLE IF EXISTS vlistings_app_config;

CREATE TABLE vlistings_app_config (
    conf_key            VARCHAR(32)         NOT NULL,
    conf_value          TEXT,
    PRIMARY KEY (conf_key)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO vlistings_app_config (conf_key, conf_value)
VALUES('site_name', 'vListings');
INSERT INTO vlistings_app_config (conf_key, conf_value)
VALUES('site_title', 'Online Listing Management System');
INSERT INTO vlistings_app_config (conf_key, conf_value)
VALUES('site_slogan', 'Website slogan');
INSERT INTO vlistings_app_config (conf_key, conf_value)
VALUES('site_keywords', 'vlistings, listing');
INSERT INTO vlistings_app_config (conf_key, conf_value)
VALUES('site_description', 'Listing System');
INSERT INTO vlistings_app_config (conf_key, conf_value)
VALUES('site_copyright', '(C) 2011 by vListings/ddth.org | All Rights Reserved');

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

CREATE TABLE vlistings_group (
    gid             INT                 NOT NULL AUTO_INCREMENT,
    gname           VARCHAR(32),
    gdesc           VARCHAR(255),
    PRIMARY KEY (gid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO vlistings_group (gid, gname, gdesc)
VALUES (1, 'Administrator', 'Administrator has all permissions!');
INSERT INTO vlistings_group (gid, gname, gdesc)
VALUES (2, 'Member', 'Normal member user');

CREATE TABLE vlistings_user (
    uid             INT                     NOT NULL AUTO_INCREMENT,
    uemail          VARCHAR(64)             NOT NULL,
        UNIQUE INDEX uemail(uemail),
    upassword       VARCHAR(64)             NOT NULL,
    ugroup_id       INT                     NOT NULL DEFAULT 0,
        INDEX ugroup_id(ugroup_id),
    PRIMARY KEY (uid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
-- Administrator account, password is "password" (without quotes, of course!)
INSERT INTO vlistings_user (uid, uemail, upassword, ugroup_id)
VALUES (1, 'admin@localhost', '5f4dcc3b5aa765d61d8327deb882cf99', 1);

CREATE TABLE vlistings_category (
    cid             INT                     NOT NULL AUTO_INCREMENT,
    cposition       INT                     NOT NULL DEFAULT 0,
        INDEX cposition(cposition),
    cparent_id      INT,
    ctitle          VARCHAR(64),
    cdesc           VARCHAR(255),
    PRIMARY KEY (cid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vlistings_item (
    iid             INT                     NOT NULL AUTO_INCREMENT,
    icategory_id    INT                     NOT NULL,
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
    istock          INT                     NOT NULL DEFAULT 0,
        INDEX istock(istock),
    PRIMARY KEY (iid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vlistings_paperclip (
    pid             VARCHAR(64)             NOT NULL,
    pfilename       VARCHAR(64)             NOT NULL,
    pfilesize       BIGINT                  NOT NULL DEFAULT 0,
    pfilecontent    MEDIUMBLOB,
    pthumbnail      BLOB,
    pmimetype       VARCHAR(64)             NOT NULL DEFAULT '',
    ptimestamp      INT                     NOT NULL DEFAULT 0,
    PRIMARY KEY (pid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
