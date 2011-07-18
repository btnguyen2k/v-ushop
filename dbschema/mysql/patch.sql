ALTER TABLE vcatalog_paperclip ADD COLUMN pis_draft INT NOT NULL DEFAULT 0;
CREATE INDEX pis_draft ON vcatalog_paperclip (pis_draft);
CREATE INDEX ptimestamp ON vcatalog_paperclip (ptimestamp);
