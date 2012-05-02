DROP TABLE IF EXISTS vcatalog_site;
CREATE TABLE vcatalog_site (
    sname                   VARCHAR(128)            NOT NULL,
    sref                    VARCHAR(128),
    stimestamp_create       INT,
    stimestamp_expiry       INT,
        INDEX (stimestamp_expiry),
    slevel                  INT                     NOT NULL DEFAULT 0,
        INDEX (slevel),
    scredit                 DOUBLE,    
    sproperties             MEDIUMTEXT,
    PRIMARY KEY (sname)
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE vcatalog_user ADD uusername VARCHAR(32) NOT NULL AFTER uid, ADD UNIQUE (uusername);
UPDATE vcatalog_user SET uusername='admin' WHERE uid=1;
