SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- 1. Clear existing product data
DELETE FROM wpx_posts WHERE post_type IN ('product', 'product_variation', 'attachment') OR (ID >= 1001 AND ID <= 1020);
DELETE FROM wpx_postmeta WHERE post_id NOT IN (SELECT ID FROM wpx_posts) OR (post_id >= 1001 AND post_id <= 1020);
DELETE FROM wpx_term_relationships WHERE object_id NOT IN (SELECT ID FROM wpx_posts) OR (object_id >= 1001 AND object_id <= 1020);

-- 2. Setup Categories and Brands
INSERT IGNORE INTO wpx_terms (term_id, name, slug) VALUES 
(100, 'Laptop Gaming', 'laptop-gaming'),
(101, 'Laptop Văn Phòng', 'laptop-van-phong'),
(102, 'Macbook', 'macbook'),
(103, 'Laptop Workstation', 'laptop-workstation'),
(200, 'Dell', 'dell'),
(201, 'HP', 'hp'),
(202, 'Lenovo', 'lenovo'),
(203, 'ASUS', 'asus'),
(204, 'Apple', 'apple'),
(205, 'Acer', 'acer'),
(206, 'MSI', 'msi'),
(207, 'Microsoft', 'microsoft');

INSERT IGNORE INTO wpx_term_taxonomy (term_taxonomy_id, term_id, taxonomy, description, count) VALUES 
(100, 100, 'product_cat', 'Hiệu năng cao cho game thủ', 0),
(101, 101, 'product_cat', 'Mỏng nhẹ cho công việc', 0),
(102, 102, 'product_cat', 'Sản phẩm Apple', 0),
(103, 103, 'product_cat', 'Đồ họa chuyên nghiệp', 0),
(200, 200, 'berocket_brand', '', 0),
(201, 201, 'berocket_brand', '', 0),
(202, 202, 'berocket_brand', '', 0),
(203, 203, 'berocket_brand', '', 0),
(204, 204, 'berocket_brand', '', 0),
(205, 205, 'berocket_brand', '', 0),
(206, 206, 'berocket_brand', '', 0),
(207, 207, 'berocket_brand', '', 0);

-- 3. Insert 20 Products
-- Standard fields template: ID, post_author, post_date, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_name, post_type, guid, to_ping, pinged, post_content_filtered

INSERT INTO wpx_posts (ID, post_author, post_date, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_name, post_type, guid, to_ping, pinged, post_content_filtered) VALUES 
(1001, 1, NOW(), '', 'Dell Latitude 7490 - Core i5 8350U | 8GB | 256GB | 14 inch FHD', 'Laptop văn phòng bền bỉ', 'publish', 'open', 'closed', 'dell-latitude-7490', 'product', '', '', '', ''),
(1002, 1, NOW(), '', 'Acer Nitro 5 Tiger 2022 - Core i5 12500H | RTX 3050 | 144Hz', 'Laptop gaming quốc dân', 'publish', 'open', 'closed', 'acer-nitro-5-tiger', 'product', '', '', '', ''),
(1003, 1, NOW(), '', 'Apple Macbook Air M1 2020 - 8GB | 256GB SSD', 'Siêu phẩm mỏng nhẹ', 'publish', 'open', 'closed', 'macbook-air-m1', 'product', '', '', '', ''),
(1004, 1, NOW(), '', 'HP EliteBook 840 G5 - Core i5 8250U | 8GB | 256GB', 'Thiết kế nhôm nguyên khối sang trọng', 'publish', 'open', 'closed', 'hp-elitebook-840-g5', 'product', '', '', '', ''),
(1005, 1, NOW(), '', 'Lenovo ThinkPad X1 Carbon Gen 6 - Core i7 8650U | 16GB | 512GB', 'Đẳng cấp doanh nhân', 'publish', 'open', 'closed', 'thinkpad-x1-carbon-gen-6', 'product', '', '', '', ''),
(1006, 1, NOW(), '', 'Dell XPS 13 9300 - Core i5 1035G1 | 8GB | 256GB | 4K Touch', 'Màn hình vô cực siêu đẹp', 'publish', 'open', 'closed', 'dell-xps-13-9300', 'product', '', '', '', ''),
(1007, 1, NOW(), '', 'ASUS ROG Strix G15 - Ryzen 7 4800H | RTX 3050 | 144Hz', 'Chiến game cực đỉnh', 'publish', 'open', 'closed', 'asus-rog-strix-g15', 'product', '', '', '', ''),
(1008, 1, NOW(), '', 'MSI Modern 14 - Core i3 1115G4 | 8GB | 256GB', 'Mỏng nhẹ thời trang cho sinh viên', 'publish', 'open', 'closed', 'msi-modern-14', 'product', '', '', '', ''),
(1009, 1, NOW(), '', 'Lenovo Legion 5 15IAH7 - Core i5 12500H | RTX 3050Ti', 'Vua laptop gaming tầm trung', 'publish', 'open', 'closed', 'lenovo-legion-5-2022', 'product', '', '', '', ''),
(1010, 1, NOW(), '', 'Dell Precision 5530 - Core i7 8850H | Quadro P1000', 'Máy trạm đồ họa mỏng nhẹ', 'publish', 'open', 'closed', 'dell-precision-5530', 'product', '', '', '', ''),
(1011, 1, NOW(), '', 'HP ZBook Studio G5 - Core i7 8750H | Quadro P1000', 'Làm đồ họa chuyên nghiệp', 'publish', 'open', 'closed', 'hp-zbook-studio-g5', 'product', '', '', '', ''),
(1012, 1, NOW(), '', 'ASUS TUF Gaming F15 - Core i5 11400H | RTX 3050', 'Bền bỉ chuẩn quân đội', 'publish', 'open', 'closed', 'asus-tuf-gaming-f15', 'product', '', '', '', ''),
(1013, 1, NOW(), '', 'Apple Macbook Pro 14 2021 - M1 Pro | 16GB | 512GB', 'Đỉnh cao đồ họa Apple', 'publish', 'open', 'closed', 'macbook-pro-14-m1-pro', 'product', '', '', '', ''),
(1014, 1, NOW(), '', 'Acer Swift 3 SF314 - Ryzen 5 5500U | 8GB | 512GB', 'Vỏ nhôm, pin trâu', 'publish', 'open', 'closed', 'acer-swift-3-ryzen-5', 'product', '', '', '', ''),
(1015, 1, NOW(), '', 'Dell Latitude 5400 - Core i5 8265U | 8GB | 256GB', 'Laptop văn phòng giá rẻ', 'publish', 'open', 'closed', 'dell-latitude-5400', 'product', '', '', '', ''),
(1016, 1, NOW(), '', 'HP Pavilion 15 - Core i5 1235U | 8GB | 512GB', 'Thiết kế mới trẻ trung', 'publish', 'open', 'closed', 'hp-pavilion-15-2022', 'product', '', '', '', ''),
(1017, 1, NOW(), '', 'MSI Bravo 15 - Ryzen 5 5600H | RX 5500M', 'Laptop gaming thuần AMD', 'publish', 'open', 'closed', 'msi-bravo-15', 'product', '', '', '', ''),
(1018, 1, NOW(), '', 'Lenovo IdeaPad 3 15IAU7 - Core i3 1215U | 8GB | 256GB', 'Giá tốt cho dân văn phòng', 'publish', 'open', 'closed', 'lenovo-ideapad-3-gen-7', 'product', '', '', '', ''),
(1019, 1, NOW(), '', 'Dell Vostro 3510 - Core i5 1135G7 | 8GB | 512GB', 'Bền bỉ cho doanh nghiệp nhỏ', 'publish', 'open', 'closed', 'dell-vostro-3510', 'product', '', '', '', ''),
(1020, 1, NOW(), '', 'Surface Laptop 4 - Ryzen 5 4680U | 8GB | 256GB', 'Màn hình cảm ứng siêu nét', 'publish', 'open', 'closed', 'surface-laptop-4', 'product', '', '', '', '');

-- 4. Insert Meta Data for 20 Products
INSERT INTO wpx_postmeta (post_id, meta_key, meta_value) VALUES 
(1001, '_price', '5500000'), (1001, '_regular_price', '6500000'), (1001, '_sku', 'DELL-7490'), (1001, 'thong_so_ky_thuat', 'CPU: i5-8350U | RAM: 8GB | SSD: 256GB | 14" FHD'), (1001, 'khuyen_mai', 'Balo + Chuột không dây'),
(1002, '_price', '15900000'), (1002, '_regular_price', '18000000'), (1002, '_sku', 'ACER-N5-2022'), (1002, 'thong_so_ky_thuat', 'CPU: i5-12500H | RAM: 8GB | SSD: 512GB | RTX 3050'), (1002, 'khuyen_mai', 'Chuột Gaming + Lót chuột'),
(1003, '_price', '18500000'), (1003, '_regular_price', '20000000'), (1003, '_sku', 'MAC-AIR-M1'), (1003, 'thong_so_ky_thuat', 'Chip M1 | RAM: 8GB | SSD: 256GB | Retina P3'), (1003, 'khuyen_mai', 'Túi chống sốc'),
(1004, '_price', '7200000'), (1004, '_regular_price', '8500000'), (1004, '_sku', 'HP-840-G5'), (1004, 'thong_so_ky_thuat', 'CPU: i5-8250U | RAM: 8GB | SSD: 256GB | 14" FHD'), (1004, 'khuyen_mai', 'Balo + Chuột'),
(1005, '_price', '9500000'), (1005, '_regular_price', '11000000'), (1005, '_sku', 'X1-CARBON-G6'), (1005, 'thong_so_ky_thuat', 'CPU: i7-8650U | RAM: 16GB | SSD: 512GB | 14" FHD IPS'), (1005, 'khuyen_mai', 'Túi chống sốc + Chuột'),
(1006, '_price', '14500000'), (1006, '_regular_price', '16500000'), (1006, '_sku', 'DELL-XPS-9300'), (1006, 'thong_so_ky_thuat', 'CPU: i5-1035G1 | RAM: 8GB | SSD: 256GB | 13.3" 4K'), (1006, 'khuyen_mai', 'Bao da cao cấp'),
(1007, '_price', '16800000'), (1007, '_regular_price', '19000000'), (1007, '_sku', 'ASUS-G15'), (1007, 'thong_so_ky_thuat', 'CPU: R7-4800H | RAM: 8GB | SSD: 512GB | RTX 3050'), (1007, 'khuyen_mai', 'Balo ROG + Chuột Gaming'),
(1008, '_price', '8900000'), (1008, '_regular_price', '10500000'), (1008, '_sku', 'MSI-M14'), (1008, 'thong_so_ky_thuat', 'CPU: i3-1115G4 | RAM: 8GB | SSD: 256GB | 14" FHD'), (1008, 'khuyen_mai', 'Túi MSI'),
(1009, '_price', '19500000'), (1009, '_regular_price', '22000000'), (1009, '_sku', 'LEGION-5-2022'), (1009, 'thong_so_ky_thuat', 'CPU: i5-12500H | RAM: 16GB | SSD: 512GB | RTX 3050Ti'), (1009, 'khuyen_mai', 'Balo Legion + Chuột'),
(1010, '_price', '12500000'), (1010, '_regular_price', '14000000'), (1010, '_sku', 'DELL-P5530'), (1010, 'thong_so_ky_thuat', 'CPU: i7-8850H | RAM: 16GB | SSD: 512GB | Quadro P1000'), (1010, 'khuyen_mai', 'Balo + Chuột chuyên dụng'),
(1011, '_price', '13500000'), (1011, '_regular_price', '15500000'), (1011, '_sku', 'ZBOOK-STU-G5'), (1011, 'thong_so_ky_thuat', 'CPU: i7-8750H | RAM: 16GB | SSD: 512GB | Quadro P1000'), (1011, 'khuyen_mai', 'Balo + Chuột'),
(1012, '_price', '14200000'), (1012, '_regular_price', '16500000'), (1012, '_sku', 'ASUS-TUF-F15'), (1012, 'thong_so_ky_thuat', 'CPU: i5-11400H | RAM: 8GB | SSD: 512GB | RTX 3050'), (1012, 'khuyen_mai', 'Balo TUF'),
(1013, '_price', '38500000'), (1013, '_regular_price', '42000000'), (1013, '_sku', 'MAC-PRO-14'), (1013, 'thong_so_ky_thuat', 'M1 Pro | RAM: 16GB | SSD: 512GB | Liquid Retina XDR'), (1013, 'khuyen_mai', 'Túi chống sốc xịn'),
(1014, '_price', '9800000'), (1014, '_regular_price', '11500000'), (1014, '_sku', 'ACER-SWIFT-3'), (1014, 'thong_so_ky_thuat', 'CPU: R5-5500U | RAM: 8GB | SSD: 512GB | 14" IPS'), (1014, 'khuyen_mai', 'Túi chống sốc'),
(1015, '_price', '4800000'), (1015, '_regular_price', '5500000'), (1015, '_sku', 'DELL-5400'), (1015, 'thong_so_ky_thuat', 'CPU: i5-8265U | RAM: 8GB | SSD: 256GB | 14" HD'), (1015, 'khuyen_mai', 'Balo + Chuột'),
(1016, '_price', '13200000'), (1016, '_regular_price', '15000000'), (1016, '_sku', 'HP-PAV-15'), (1016, 'thong_so_ky_thuat', 'CPU: i5-1235U | RAM: 8GB | SSD: 512GB | 15.6" FHD'), (1016, 'khuyen_mai', 'Balo HP'),
(1017, '_price', '12500000'), (1017, '_regular_price', '14500000'), (1017, '_sku', 'MSI-BRAVO-15'), (1017, 'thong_so_ky_thuat', 'CPU: R5-5600H | RAM: 8GB | SSD: 512GB | RX 5500M'), (1017, 'khuyen_mai', 'Chuột Gaming'),
(1018, '_price', '7800000'), (1018, '_regular_price', '9000000'), (1018, '_sku', 'LENOVO-IP3'), (1018, 'thong_so_ky_thuat', 'CPU: i3-1215U | RAM: 8GB | SSD: 256GB | 15.6" FHD'), (1018, 'khuyen_mai', 'Bộ vệ sinh laptop'),
(1019, '_price', '11200000'), (1019, '_regular_price', '13000000'), (1019, '_sku', 'DELL-VOSTRO-3510'), (1019, 'thong_so_ky_thuat', 'CPU: i5-1135G7 | RAM: 8GB | SSD: 512GB | 15.6" FHD'), (1019, 'khuyen_mai', 'Balo + Chuột'),
(1020, '_price', '15500000'), (1020, '_regular_price', '17500000'), (1020, '_sku', 'SURFACE-LAP-4'), (1020, 'thong_so_ky_thuat', 'CPU: R5-4680U | RAM: 8GB | SSD: 256GB | 13.5" Touch'), (1020, 'khuyen_mai', 'Túi Surface');

-- 5. Relationships
-- Categories: 100-Gaming, 101-VanPhong, 102-Macbook, 103-Workstation
-- Brands: 200-Dell, 201-HP, 202-Lenovo, 203-ASUS, 204-Apple, 205-Acer, 206-MSI, 207-Microsoft

INSERT INTO wpx_term_relationships (object_id, term_taxonomy_id) VALUES 
(1001, 101), (1001, 200), (1002, 100), (1002, 205), (1003, 102), (1003, 204),
(1004, 101), (1004, 201), (1005, 101), (1005, 202), (1006, 101), (1006, 200),
(1007, 100), (1007, 203), (1008, 101), (1008, 206), (1009, 100), (1009, 202),
(1010, 103), (1010, 200), (1011, 103), (1011, 201), (1012, 100), (1012, 203),
(1013, 102), (1013, 204), (1014, 101), (1014, 205), (1015, 101), (1015, 200),
(1016, 101), (1016, 201), (1017, 100), (1017, 206), (1018, 101), (1018, 202),
(1019, 101), (1019, 200), (1020, 101), (1020, 207);

-- 6. Set products to 'instock' and 'visible'
INSERT INTO wpx_postmeta (post_id, meta_key, meta_value)
SELECT ID, '_stock_status', 'instock' FROM wpx_posts WHERE ID >= 1001 AND ID <= 1020
ON DUPLICATE KEY UPDATE meta_value = 'instock';

INSERT INTO wpx_postmeta (post_id, meta_key, meta_value)
SELECT ID, '_visibility', 'visible' FROM wpx_posts WHERE ID >= 1001 AND ID <= 1020
ON DUPLICATE KEY UPDATE meta_value = 'visible';

SET FOREIGN_KEY_CHECKS = 1;
