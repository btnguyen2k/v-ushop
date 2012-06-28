INSERT INTO gpv_product (pname, pversion_1, pversion_2, pversion_3, pversion_4, pconfig)
VALUES ('VUSHOP', 0, 1, 0, 0,
'{
  "LEVELS": {
    "0": {
      "NUM_SHOPS": 10,
      "CATALOG_CATEGORIES": 10,
      "CATALOG_ITEMS": 50,
      "CMS_PAGES": 20,
      "PAPERCLIP_FILES": 80,
      "PAPERCLIP_FILESIZE": 100000
    },
    "1": {
      "NUM_SHOPS": 100,
      "CATALOG_CATEGORIES": 100,
      "CATALOG_ITEMS": 10000,
      "CMS_PAGES": 200,
      "PAPERCLIP_FILES": 10300,
      "PAPERCLIP_FILESIZE": 120000
    },
    "2": {
      "NUM_SHOPS": 1000,
      "CATALOG_CATEGORIES": 500,
      "CATALOG_ITEMS": 100000,
      "CMS_PAGES": 2000,
      "PAPERCLIP_FILES": 102500,
      "PAPERCLIP_FILESIZE": 150000
    }
  }
}'
);


INSERT INTO gpv_site (sdomain, sref, stimestamp) VALUES ('vushop.local', 'localhost', UNIX_TIMESTAMP());
INSERT INTO gpv_site_product (site_domain, prod_name, prod_level, prod_timestamp, prod_expiry, prod_config)
VALUES ('localhost', 'VUSHOP', 0, UNIX_TIMESTAMP(), -1, '{"DB":{"TYPE":"MYSQL", "HOST":"127.0.0.1", "USER":"vushop_local", "PASSWORD":"vushop_local", "DATABASE":"vushop_local", "SETUP_SQLS":["SET NAMES ''utf8''"]}}');
