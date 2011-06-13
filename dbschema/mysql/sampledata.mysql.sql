-- Test account, password is "test" (without quotes, of course!)
INSERT INTO vlistings_user (uemail, upassword, ugroup_id)
VALUES ('test@localhost', '098f6bcd4621d373cade4e832627b4f6', 2);

-- Sample categories
INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (1, 1, NULL, 'Dien Tu', 'Do dien tu, gia dung');
INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (2, 11, 1, 'Laptop', 'May tinh xach tay');
INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (3, 12, 1, 'Desktop', 'May tinh de ban');
INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (4, 13, 1, 'Accessories', 'Phu kien may tinh');

INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (5, 2, NULL, 'Quan Ao', 'Quan ao thoi trang');
INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (6, 21, 5, 'Quan Ao Mua Dong', 'Quan ao danh cho mua dong');
INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (7, 22, 5, 'Quan Ao Mua He', 'Quan ao danh cho mua he');
INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (8, 23, 5, 'Quan Ao The Thao', 'Quan ao danh cho nguoi tap the thao');

INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (9, 3, NULL, 'Sua', 'Sua cho tre em');
INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (10, 31, 9, 'Sua Me', 'Sua me cung ban luon!');
INSERT INTO vlistings_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (11, 32, 9, 'Sua Bot', 'Sua bot cac loai');
