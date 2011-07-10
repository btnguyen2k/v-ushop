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
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(1, 1, NULL, 'Đồ dùng cho bé', 'đồ dùng cho bé được nhập khẩu từ Mỹ , các sản phẩm không chứa chất độc hại , rất an toàn cho sức khỏe của bé');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(2, 11, 1, 'Đồ dùng ăn uống', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(3, 12, 1, 'Gặm nướu', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(4, 13, 1, 'Bình sữa BPA Free', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(5, 1310049589, NULL, 'Chăm sóc bé', 'sản phẩm chăm sóc bé được nhập khẩu từ Mỹ rất an toàn cho sức khỏe của bé');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(6, 21, 5, 'Sữa tắm-gội-dưỡng da', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(7, 22, 5, 'Chăm sóc răng miệng', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(8, 23, 5, 'kem chống nắng', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(9, 1310049590, NULL, 'Đồ chơi - xe đẩy - xe tập đi', 'Đồ chơi, xe tập đi, xe đẩy đều được nhập khẩu từ Mỹ, các sản phẩm không chứa chất độc hại , rất an toàn và giúp phát triển các kỹ năng của bé');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(14, 1310221935, 9, 'Xe đẩy-tập đi-ghế ăn', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(11, 32, 9, 'Đồ chơi', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(12, 1310049591, NULL, 'Thời trang của bé', 'hàng VNXK,TQXK');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(13, 1310050054, 12, 'Thời trang bé gái', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(15, 1310221984, 1, 'Ba lô - túi xách', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(16, 1310222025, 1, 'Tã Goon', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(17, 1310222195, 12, 'Thời trang bé trai', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(18, 1310222274, NULL, 'Mỹ phẩm - nước hoa', 'Hàng xách tay từ Mỹ, Pháp, Nhật...');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(19, 1310222298, 18, 'Chăm sóc cơ thể', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(20, 1310222318, 18, 'Chăm sóc tóc', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(21, 1310222339, 18, 'Chăm sóc da mặt', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(22, 1310222360, 18, 'Dành cho nam', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(23, 1310222419, 18, 'Nước hoa', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(24, 1310222465, 18, 'Chăm sóc răng miệng', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(25, 1310222529, NULL, 'Thời trang xuất khẩu', 'hàng VNXK, TQXK');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(26, 1310222546, 25, 'Thời trang nữ', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(27, 1310222556, 25, 'Thời trang nam', NULL);
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(28, 1310222590, NULL, 'Thực phẩm chức năng', 'Hàng chính hãng xách tay từ Mỹ');
INSERT INTO vcatalog_category (cid, cposition, cparent_id, ctitle, cdesc) VALUES(29, 1310223553, 12, 'Giày dép', NULL);
