ALTER TABLE vcatalog_page CHANGE ponmenu pattr INT NOT NULL DEFAULT 0;
ALTER TABLE vcatalog_page DROP INDEX ponmenu, ADD INDEX (pattr);
