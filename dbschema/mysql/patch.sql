DROP TABLE IF EXISTS gpv_product;
DROP TABLE IF EXISTS gpv_site;

CREATE TABLE gpv_site (
    sdomain                 VARCHAR(128)            NOT NULL,
    sref                    VARCHAR(128),
        INDEX (sref),
    stimestamp              INT                     NOT NULL DEFAULT 0,
        INDEX (stimestamp),
    scustomer_id            VARCHAR(64),
        INDEX (scustomer_id),
    PRIMARY KEY (sdomain),
    FOREIGN KEY (sref) REFERENCES gpv_site(sdomain) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO gpv_site (sdomain, sref, stimestamp) VALUES ('localhost', NULL, UNIX_TIMESTAMP());
INSERT INTO gpv_site (sdomain, sref, stimestamp) VALUES ('localhost.localdomain', 'localhost', UNIX_TIMESTAMP());
INSERT INTO gpv_site (sdomain, sref, stimestamp) VALUES ('127.0.0.1', 'localhost', UNIX_TIMESTAMP());

CREATE TABLE gpv_product (
    psite_domain            VARCHAR(128)            NOT NULL,
        INDEX (psite_domain),
        FOREIGN KEY (psite_domain) REFERENCES gpv_site(sdomain) ON DELETE CASCADE ON UPDATE CASCADE,
    pname                   VARCHAR(32)             NOT NULL,
    pversion_1              TINYINT                 NOT NULL DEFAULT 0,
    pversion_2              TINYINT                 NOT NULL DEFAULT 0,
    pversion_3              TINYINT                 NOT NULL DEFAULT 0,
    pversion_4              TINYINT                 NOT NULL DEFAULT 0,
        INDEX (pversion_1, pversion_2, pversion_3, pversion_4),
    plevel                  INT                     NOT NULL DEFAULT 0,
    ptimestamp              INT                     NOT NULL DEFAULT 0,
    pexpiry                 INT                     NOT NULL DEFAULT 0,
    pconfig                 MEDIUMTEXT,
    PRIMARY KEY (psite_domain, pname)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
INSERT INTO gpv_product (psite_domain, pname, plevel, ptimestamp, pexpiry, pversion_1, pversion_2, pversion_3, pconfig)
VALUES ('localhost', 'VCATALOG', 0, UNIX_TIMESTAMP(), -1, 0, 6, 0, '{"DB":{"TYPE":"MYSQL", "HOST":"localhost", "USER":"vcatalog_localhost", "PASSWORD":"vcatalog_localhost", "DATABASE":"vcatalog_localhost", "SETUP_SQLS":["SET NAMES ''utf8''"]}}');
