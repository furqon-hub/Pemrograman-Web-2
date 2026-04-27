# Tugas 1: Eksplorasi Database Perpustakaan

## Hasil Query
### Statistik Buku
1. **Total buku seluruhnya**
    ![SELECT COUNT(*) AS total_buku FROM buku;]![alt text](image.png)
2. **Total nilai inventaris (sum harga × stok)**
    ![SELECT SUM(harga * stok) AS total_nilai_inventaris FROM buku;](![alt text](image-1.png))
3. **Rata-rata harga buku**
    ![SELECT AVG(harga) AS rata_rata_harga FROM buku;](image-2.png)
4. **Buku termahal (tampilkan judul dan harga)**
    ![SELECT judul, harga FROM buku ORDER BY harga DESC LIMIT 1](![alt text](image-3.png))
5. **Buku dengan stok terbanyak**
    ![SELECT judul, stok FROM buku ORDER BY stok DESC LIMIT 1](![alt text](image-4.png))
6. **Semua buku kategori Programming yang harga < 100.000**
    ![SELECT * FROM buku WHERE kategori = 'Programming' AND harga < 100000 LIMIT 100](![alt text](image-5.png))
7. **Buku yang judulnya mengandung kata "PHP" atau "MySQL"**
    ![SELECT * FROM buku WHERE judul LIKE '%PHP%' OR judul LIKE '%MySQL%' LIMIT 100](![alt text](image-6.png))
8. **Buku yang terbit tahun 2024**
    ![SELECT * FROM buku WHERE tahun_terbit = 2024 LIMIT 100](![alt text](image-7.png))
9. **Buku yang stoknya antara 5-10**
    ![SELECT * FROM buku WHERE stok BETWEEN 5 AND 10 LIMIT 100](![alt text](image-8.png))
10. **Buku yang pengarangnya "Budi Raharjo"**
    ![SELECT * FROM buku WHERE pengarang = 'Budi Raharjo' LIMIT 100](![alt text](image-9.png))
11. **Jumlah buku per kategori (dengan total stok per kategori)**
    ![SELECT kategori, COUNT(*) AS jumlah_buku, SUM(stok) AS total_stok FROM buku GROUP BY kategori LIMIT 100](![alt text](image-10.png))
12. **Rata-rata harga per kategori**
    ![SELECT kategori, AVG(harga) AS rata_rata_harga FROM buku GROUP BY kategori LIMIT 100](![alt text](image-11.png))
13. **Kategori dengan total nilai inventaris terbesar**
    ![SELECT kategori, SUM(harga * stok) AS total_nilai_inventaris FROM buku GROUP BY kategori ORDER BY total_nilai_inventaris DESC LIMIT 1](![alt text](image-12.png))
14. **Naikkan harga semua buku kategori Programming sebesar 5%**
    ![UPDATE buku SET harga = harga * 1.05 WHERE kategori = 'Programming';
](![alt text](image-13.png))
15. **Tambah stok 10 untuk semua buku yang stoknya < 5**
    ![UPDATE buku SET stok = stok + 10 WHERE stok < 5;](![alt text](image-14.png))
16. **Daftar buku yang perlu restocking (stok < 5)**
    ![SELECT * FROM buku WHERE stok < 5 LIMIT 100](![alt text](image-15.png))
17. **Top 5 buku termahal**
    ![SELECT * FROM buku ORDER BY harga DESC LIMIT 5](![alt text](image-16.png))