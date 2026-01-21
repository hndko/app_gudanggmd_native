-- Seeder Data for Aplikasi Gudang (Native PHP)
-- UPDATED: Explicit Master IDs to ensure INNER JOINs work correctly.

-- 1. Seeder table "tbl_jenis"
-- Explicitly inserting IDs 1-5
INSERT INTO tbl_jenis (id_jenis, nama_jenis) VALUES
(1, 'Elektronik'),
(2, 'Alat Tulis Kantor'),
(3, 'Perabotan'),
(4, 'Peralatan Kebersihan'),
(5, 'Komputer & Aksesoris');

-- 2. Seeder table "tbl_satuan"
-- Explicitly inserting IDs 1-6
INSERT INTO tbl_satuan (id_satuan, nama_satuan) VALUES
(1, 'Pcs'),
(2, 'Unit'),
(3, 'Box'),
(4, 'Paket'),
(5, 'Rim'),
(6, 'Set');

-- 3. Seeder table "tbl_lokasi_rak"
-- Explicitly inserting IDs 1-6
INSERT INTO tbl_lokasi_rak (id_lokasi_rak, lokasi_rak) VALUES
(1, 'Rak A-1'),
(2, 'Rak A-2'),
(3, 'Rak B-1'),
(4, 'Rak B-2'),
(5, 'Lemari Besi 1'),
(6, 'Gudang Belakang');

-- 4. Seeder table "tbl_barang"
-- Now confident that jenis 1-5, satuan 1-6, lokasi_rak 1-6 EXIST.

INSERT INTO tbl_barang (id_barang, nama_barang, jenis, stok_minimum, stok, satuan, lokasi_rak, barang_pending, foto) VALUES
('B001', 'Laptop ASUS Rog', 1, 5, 0, 2, '1', 0, NULL),
('B002', 'Mouse Logitech Wireless', 5, 10, 0, 2, '1', 0, NULL),
('B003', 'Kertas A4 Sidu', 2, 20, 0, 5, '2', 0, NULL),
('B004', 'Kursi Kantor Ergonomis', 3, 2, 0, 2, '3', 0, NULL),
('B005', 'Sapu Ijuk', 4, 5, 0, 1, '6', 0, NULL),
('B006', 'Monitor LG 24 Inch', 5, 3, 0, 2, '1', 0, NULL),
('B007', 'Pulpen Pilot Hitam', 2, 50, 0, 1, '2', 0, NULL),
('B008', 'Meja Kerja Kayu', 3, 2, 0, 2, '3', 0, NULL),
('B009', 'Printer Epson L3110', 5, 1, 0, 2, '1', 0, NULL),
('B010', 'Cairan Pembersih Lantai', 4, 10, 0, 1, '6', 0, NULL);

-- 5. Seeder table "tbl_barang_masuk"
-- 'inputby' matched to 'Administrator' from existing users.

INSERT INTO tbl_barang_masuk (id_transaksi, tanggal, barang, jumlah, keterangan, inputby) VALUES
('TM-20240101-001', '2024-01-01', 'B001', 10, 'Pengadaan Awal Tahun', 'Administrator'),
('TM-20240102-002', '2024-01-02', 'B002', 20, 'Pengadaan Awal Tahun', 'Administrator'),
('TM-20240103-003', '2024-01-03', 'B003', 50, 'Stok Bulanan', 'Administrator'),
('TM-20240105-004', '2024-01-05', 'B004', 5, 'Kursi Baru', 'Administrator'),
('TM-20240105-005', '2024-01-05', 'B005', 15, 'Alat Kebersihan', 'Administrator'),
('TM-20240106-006', '2024-01-06', 'B006', 8, 'Upgrade Monitor', 'Administrator'),
('TM-20240107-007', '2024-01-07', 'B007', 100, 'Stok ATK', 'Administrator'),
('TM-20240108-008', '2024-01-08', 'B008', 5, 'Meja Staff', 'Administrator'),
('TM-20240109-009', '2024-01-09', 'B009', 3, 'Printer Ruangan', 'Administrator'),
('TM-20240110-010', '2024-01-10', 'B010', 25, 'Stok Kebersihan', 'Administrator');

-- 6. Seeder table "tbl_barang_keluar"
-- 'pic' included.

INSERT INTO tbl_barang_keluar (id_transaksi, tanggal, barang, jumlah, keterangan, inputby, pic) VALUES
('TK-20240201-001', '2024-02-01', 'B001', 2, 'Dipakai Tim IT', 'Administrator', 'Rudi IT'),
('TK-20240202-002', '2024-02-02', 'B002', 5, 'Dipakai Staff Admin', 'Administrator', 'Siti Admin'),
('TK-20240203-003', '2024-02-03', 'B003', 10, 'Keperluan Rapat', 'Administrator', 'Budi HRD'),
('TK-20240204-004', '2024-02-04', 'B007', 20, 'Bagian Keuangan', 'Administrator', 'Dewi Finance'),
('TK-20240205-005', '2024-02-05', 'B010', 5, 'Pembersihan Gudang', 'Administrator', 'Joko OB');

-- 7. Seeder table "tbl_peminjaman_barang"
-- 'gambar' included.

INSERT INTO tbl_peminjaman_barang (nama_barang, jumlah_peminjaman, pic, tanggal_pinjam, tanggal_kembali, keterangan, gambar, status) VALUES
('Laptop ASUS Rog', 1, 'Budi Santoso', '2024-03-01 09:00:00', '2024-03-03 17:00:00', 'Presentasi Marketing', 'no_image.png', 'Barang Telah Dikembalikan'),
('Proyektor', 1, 'Ani Wijaya', '2024-03-02 10:00:00', '2024-03-02 15:00:00', 'Meeting Direksi', 'no_image.png', 'Barang Telah Dikembalikan'),
('Kabel HDMI', 2, 'Rudi Hartono', '2024-03-05 08:30:00', '2024-03-05 00:00:00', 'Peminjaman Inventaris', 'no_image.png', 'Barang Dipinjam'),
('Bor Listrik', 1, 'Tim Maintenance', '2024-03-06 13:00:00', '2024-03-07 10:00:00', 'Perbaikan Meja', 'no_image.png', 'Barang Telah Dikembalikan'),
('Tangga Lipat', 1, 'Office Boy', '2024-03-10 09:00:00', '2024-03-10 00:00:00', 'Ganti Lampu', 'no_image.png', 'Barang Dipinjam');
