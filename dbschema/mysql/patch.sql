ALTER TABLE vcatalog_category ADD COLUMN cimage_id VARCHAR(64);
CREATE INDEX cimage_id ON vcatalog_category (cimage_id);

ALTER TABLE vcatalog_item ADD COLUMN iimage_id VARCHAR(64);
CREATE INDEX iimage_id ON vcatalog_item (iimage_id);
