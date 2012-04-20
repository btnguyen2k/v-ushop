ALTER TABLE vcatalog_page CHANGE ponmenu pattr INT NOT NULL DEFAULT 0;
ALTER TABLE vcatalog_page DROP INDEX ponmenu, ADD INDEX (pattr);

DROP TABLE IF EXISTS vcatalog_textads;
CREATE TABLE vcatalog_textads (
    aid                 INT                 NOT NULL AUTO_INCREMENT,
    atitle              VARCHAR(128),
    aurl                VARCHAR(255),
    aclicks             INT                 NOT NULL DEFAULT 0,
    atimestamp          TIMESTAMP,
    PRIMARY KEY (aid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
