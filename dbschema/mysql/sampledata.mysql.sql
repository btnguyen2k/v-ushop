-- Sample user accounts
DELETE FROM vcatalog_user;
-- Administrator account, password is "password" (without quotes, of course!)
INSERT INTO vcatalog_user (uid, uemail, upassword, ugroup_id)
VALUES (1, 'admin@localhost', '5f4dcc3b5aa765d61d8327deb882cf99', 1);
-- Test account, password is "test" (without quotes, of course!)
INSERT INTO vcatalog_user (uemail, upassword, ugroup_id)
VALUES ('test@localhost', '098f6bcd4621d373cade4e832627b4f6', 2);

-- Sample page
DELETE FROM vcatalog_page;
INSERT INTO vcatalog_page (pid, ponmenu, pposition, ptitle, pcontent)
VALUES ('about', 1, 1, 'Giới Thiệu', '<h1 style="text-align: center;">Giới Thiệu Về Chúng Tôi</h1>
<p><span style="text-decoration: underline;"><strong>Chúng Tôi Là Ai?</strong></span></p>
<p>Chúng tôi là...</p>
<p><span style="text-decoration: underline;"><strong>Chúng Tôi Làm gì?</strong></span></p>
<p>Chúng tôi làm...</p>');

INSERT INTO vcatalog_page (pid, ponmenu, pposition, ptitle, pcontent)
VALUES ('contact', 1, 2, 'Liên Hệ', '<h1 style="text-align: center;">Liên Hệ Với Chúng Tôi</h1>
<p><span style="text-decoration: underline;"><strong>Trụ Sở Chính</strong></span></p>
<p>...</p>
<p><span style="text-decoration: underline;"><strong>Chi Nhánh</strong></span></p>
<p>...</p>');

-- Sample categories
DELETE FROM vcatalog_category;
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

-- Sample items
DELETE FROM vcatalog_item;
INSERT INTO vcatalog_item (icategory_id, ititle, idesc, ivendor, itimestamp, iprice, iold_price, istock)
VALUES (2, 'N200', '<p>Laptop hàng hiệu chính hãng</p>', 'Lenovo', NOW(), 725, NULL, 100);
INSERT INTO vcatalog_item (icategory_id, ititle, idesc, ivendor, itimestamp, iprice, iold_price, istock)
VALUES (2, 'T410', '<p>Laptop hàng hiệu chính hãng</p>', 'Lenovo', NOW(), 1099, NULL, 75);
INSERT INTO vcatalog_item (icategory_id, ititle, idesc, ivendor, itimestamp, iprice, iold_price, istock)
VALUES (3, 'Compaq Presario 2011', '<p>Máy tính bộ chính hãng</p>', 'HP-Compaq', NOW(), 699, NULL, -1);
INSERT INTO vcatalog_item (icategory_id, ititle, idesc, ivendor, itimestamp, iprice, iold_price, istock)
VALUES (3, 'Phong Vũ Student', '<p>Bộ máy tính Phong Vũ dành cho Sinh viên</p>', 'Lenovo', NOW(), 1099, NULL, 75);
INSERT INTO vcatalog_item (icategory_id, ititle, idesc, ivendor, itimestamp, iprice, iold_price, istock)
VALUES (10, 'Mama', '<p>Sữa của mama</p>', '', NOW(), 0, NULL, 0);
INSERT INTO vcatalog_item (icategory_id, ititle, idesc, ivendor, itimestamp, iprice, iold_price, istock)
VALUES (NULL, 'Linh Tinh', '<p>Chưa biết xếp vào danh mục nào</p>', '', NOW(), 0, NULL, 0);
