ALTER TABLE vcatalog_item ADD COLUMN ihot_item INT NOT NULL DEFAULT 0;
CREATE INDEX ihot_item ON vcatalog_item(ihot_item);
