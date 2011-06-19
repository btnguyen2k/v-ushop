-- Test account, password is "test" (without quotes, of course!)
INSERT INTO vcatalog_user (uemail, upassword, ugroup_id)
VALUES ('test@localhost', '098f6bcd4621d373cade4e832627b4f6', 2);

-- Sample categories
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (1, 1, NULL, 'Điện Tử', 'Đồ điện tử, gia dụng');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (2, 11, 1, 'Laptop', 'Máy tính xác thay');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (3, 12, 1, 'Desktop', 'Máy tính để bàn');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (4, 13, 1, 'Accessories', 'Phụ kiện máy tính');

INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (5, 2, NULL, 'Quần Áo', 'Quần áo thời trang');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (6, 21, 5, 'Quần Áo Mùa Đông', 'Quần áo dành cho mùa đông');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (7, 22, 5, 'Quần Áo Mùa Hè', 'Quần áo dành cho mùa hè');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (8, 23, 5, 'Quần Áo Thể Thao', 'Quần áo dành cho người tập thể thao');

INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (9, 3, NULL, 'Sữa', 'Sữa cho trẻ em');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (10, 31, 9, 'Sữa Mẹ', 'Sữa mẹ cũng bán luôn!');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc)
VALUES (11, 32, 9, 'Sữa Bột', 'Sữa bột các coại');
