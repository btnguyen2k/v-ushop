INSERT INTO vcatalog_app_config (conf_key, conf_value)
VALUES('site_skin', 'default');

DROP TABLE IF EXISTS vcatalog_site;
CREATE TABLE vcatalog_site (
    sdomain                 VARCHAR(128)            NOT NULL,
    sref                    VARCHAR(128),
        INDEX (sref),
    plevel                  INT                     NOT NULL DEFAULT 0,
        INDEX (plevel),
    ptimestamp              INT                     NOT NULL DEFAULT 0,
        INDEX (ptimestamp),
    pexpiry                 INT                     NOT NULL DEFAULT 0,
        INDEX (pexpiry),
    pconfig                 MEDIUMTEXT,
    PRIMARY KEY (sdomain)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
