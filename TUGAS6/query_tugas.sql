-- Gunakan database perpustakaan
USE perpustakaan2;

-- Statistik Buku
-- 1. Total buku seluruhnya
SELECT COUNT(*) AS total_buku FROM buku;

-- 2. Total nilai inventaris (sum harga × stok)
SELECT SUM(harga * stok) AS total_nilai_inventaris FROM buku;

-- 3. Rata-rata harga buku
SELECT AVG(harga) AS rata_rata_harga FROM buku;

-- 4. Buku termahal (tampilkan judul dan harga)
SELECT judul, harga FROM buku ORDER BY harga DESC LIMIT 1;

-- 5. Buku dengan stok terbanyak
SELECT judul, stok FROM buku ORDER BY stok DESC LIMIT 1;

-- Filter dan Pencarian
-- 6. Semua buku kategori Programming yang harga < 100.000
SELECT * FROM buku WHERE kategori = 'Programming' AND harga < 100000;

-- 7. Buku yang judulnya mengandung kata "PHP" atau "MySQL"
SELECT * FROM buku WHERE judul LIKE '%PHP%' OR judul LIKE '%MySQL%';

-- 8. Buku yang terbit tahun 2024
SELECT * FROM buku WHERE tahun_terbit = 2024;

-- 9. Buku yang stoknya antara 5-10
SELECT * FROM buku WHERE stok BETWEEN 5 AND 10;

-- 10. Buku yang pengarangnya "Budi Raharjo"
SELECT * FROM buku WHERE pengarang = 'Budi Raharjo';

-- Grouping dan Agregasi
-- 11. Jumlah buku per kategori (dengan total stok per kategori)
SELECT kategori, COUNT(*) AS jumlah_buku, SUM(stok) AS total_stok FROM buku GROUP BY kategori;

-- 12. Rata-rata harga per kategori
SELECT kategori, AVG(harga) AS rata_rata_harga FROM buku GROUP BY kategori;

-- 13. Kategori dengan total nilai inventaris terbesar
SELECT kategori, SUM(harga * stok) AS total_nilai_inventaris FROM buku GROUP BY kategori ORDER BY total_nilai_inventaris DESC LIMIT 1;

-- Update Data
-- 14. Naikkan harga semua buku kategori Programming sebesar 5%
UPDATE buku SET harga = harga * 1.05 WHERE kategori = 'Programming';

-- 15. Tambah stok 10 untuk semua buku yang stoknya < 5
UPDATE buku SET stok = stok + 10 WHERE stok < 5;

-- Laporan Khusus
-- 16. Daftar buku yang perlu restocking (stok < 5)
SELECT * FROM buku WHERE stok < 5;

-- 17. Top 5 buku termahal
SELECT * FROM buku ORDER BY harga DESC LIMIT 5;
