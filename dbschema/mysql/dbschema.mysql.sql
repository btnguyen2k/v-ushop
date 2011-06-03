DROP TABLE IF EXISTS http_session;
CREATE TABLE IF NOT EXISTS http_session (
    sid             VARCHAR(32)             NOT NULL PRIMARY KEY,
    sdata           TEXT
) ENGINE=MYISAM;
