ALTER TABLE vcatalog_page CHANGE ptitle ptitle VARCHAR(128) NOT NULL DEFAULT '';
ALTER TABLE vcatalog_page ADD pcategory VARCHAR(64) NOT NULL DEFAULT '' AFTER ponmenu, ADD INDEX (pcategory);

ALTER TABLE vcatalog_user ADD utitle VARCHAR(32);
ALTER TABLE vcatalog_user ADD ufullname VARCHAR(64);
ALTER TABLE vcatalog_user ADD ulocation VARCHAR(64);
