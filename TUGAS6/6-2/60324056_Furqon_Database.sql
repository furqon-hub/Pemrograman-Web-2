-- ==========================================================
-- FILE: NIM_Nama_database.sql
-- TUGAS 2: DESAIN DATABASE PERPUSTAKAAN LENGKAP
-- ==========================================================

-- 1. CREATE DATABASE
CREATE DATABASE IF NOT EXISTS perpustakaan_lengkap;
USE perpustakaan_lengkap;

-- 2. CREATE TABLE Kategori Buku (Sesuai Struktur Modul)
CREATE TABLE kategori_buku (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50) NOT NULL UNIQUE,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. CREATE TABLE Penerbit (Sesuai Struktur Modul)
CREATE TABLE penerbit (
    id_penerbit INT AUTO_INCREMENT PRIMARY KEY,
    nama_penerbit VARCHAR(100) NOT NULL,
    alamat TEXT,
    telepon VARCHAR(15),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. CREATE TABLE Buku (Hasil Modifikasi & Foreign Key)
CREATE TABLE buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    id_kategori INT, -- Pengganti ENUM
    id_penerbit INT, -- Pengganti VARCHAR
    stok INT DEFAULT 0,
    harga DECIMAL(10,2),
    tahun_terbit YEAR,
    -- Tambahkan FOREIGN KEY
    FOREIGN KEY (id_kategori) REFERENCES kategori_buku(id_kategori),
    FOREIGN KEY (id_penerbit) REFERENCES penerbit(id_penerbit)
);

-- ==========================================================
-- 5. INSERT DATA SAMPLE (Minimal 5 Kategori, 5 Penerbit, 15 Buku)
-- ==========================================================

INSERT INTO kategori_buku (nama_kategori, deskripsi) VALUES 
('Programming', 'Buku teknis koding'),
('Database', 'Buku pengolahan data'),
('Sains', 'Ilmu pengetahuan alam'),
('Fiksi', 'Novel dan cerita'),
('Sejarah', 'Catatan masa lalu');

INSERT INTO penerbit (nama_penerbit, alamat, telepon, email) VALUES 
('Erlangga', 'Jakarta', '021-111', 'info@erlangga.com'),
('Informatika', 'Bandung', '022-222', 'info@informatika.com'),
('Gramedia', 'Jakarta', '021-333', 'contact@gramedia.com'),
('Andi Offset', 'Yogyakarta', '0274-444', 'andi@offset.com'),
('Mizan', 'Bandung', '022-555', 'halo@mizan.com');

INSERT INTO buku (judul, id_kategori, id_penerbit, stok, harga, tahun_terbit) VALUES 
('Lancar Java', 1, 1, 10, 95000, 2023),
('SQL Expert', 2, 2, 5, 120000, 2024),
('Fisika Dasar', 3, 1, 8, 85000, 2022),
('Laskar Pelangi', 4, 3, 20, 75000, 2018),
('Sejarah Dunia', 5, 4, 3, 150000, 2020),
('Python Pro', 1, 2, 12, 110000, 2023),
('NoSQL Database', 2, 2, 7, 130000, 2024),
('Biologi Molekuler', 3, 3, 4, 180000, 2021),
('Bumi Manusia', 4, 5, 15, 99000, 2019),
('Majapahit', 5, 4, 2, 125000, 2021),
('React JS Native', 1, 5, 6, 145000, 2023),
('MongoDB Guide', 2, 1, 9, 105000, 2022),
('Kimia Organik', 3, 2, 5, 160000, 2023),
('Dunia Sophie', 4, 3, 11, 135000, 2017),
('Perang Diponegoro', 5, 5, 4, 90000, 2020);

-- ==========================================================
-- 6. QUERY YANG HARUS DIBUAT (Sesuai Instruksi)
-- ==========================================================

-- 1. JOIN untuk tampilkan buku dengan nama kategori dan penerbit
SELECT b.judul, k.nama_kategori, p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;

-- 2. Jumlah buku per kategori
SELECT k.nama_kategori, COUNT(b.id_buku) as jumlah_buku
FROM kategori_buku k
LEFT JOIN buku b ON k.id_kategori = b.id_kategori
GROUP BY k.nama_kategori;

-- 3. Jumlah buku per penerbit
SELECT p.nama_penerbit, COUNT(b.id_buku) as jumlah_buku
FROM penerbit p
LEFT JOIN buku b ON p.id_penerbit = b.id_penerbit
GROUP BY p.nama_penerbit;

-- 4. Buku beserta detail lengkap (kategori + penerbit)
SELECT b.*, k.nama_kategori, p.nama_penerbit
FROM buku b
JOIN kategori_buku k ON b.id_kategori = k.id_kategori
JOIN penerbit p ON b.id_penerbit = p.id_penerbit;