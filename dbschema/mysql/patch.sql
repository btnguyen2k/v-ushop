DROP TABLE IF EXISTS app_profile_detail;
DROP TABLE IF EXISTS app_profile;

CREATE TABLE app_profile (
    pid                 VARCHAR(16)         NOT NULL,
    purl                VARCHAR(64),
    ptimestamp          TIMESTAMP           NOT NULL,
    pduration           DOUBLE              NOT NULL DEFAULT 0.0,
    pdetail             TEXT,
    PRIMARY KEY (pid)
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE app_profile_detail (
    pid                 VARCHAR(16)         NOT NULL,
    pdid                VARCHAR(16)         NOT NULL,
        INDEX (pid, pdid),
    pdparent_id         VARCHAR(16),
    pdname              VARCHAR(64),
    pdduration          DOUBLE              NOT NULL DEFAULT 0.0
) ENGINE=MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;