CREATE TABLE vcatalog_tag (
    titem_id        INT                     NOT NULL,
    ttag            VARCHAR(32)             COLLATE utf8_bin NOT NULL,
        INDEX ttag(ttag),
    ttype           INT                     NOT NULL DEFAULT 0,
        INDEX ttype(ttype),
    PRIMARY KEY (titem_id, ttag, ttype)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
