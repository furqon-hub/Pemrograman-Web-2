<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Informasi Buku</h1>
        
        <?php
        // Data buku dalam array asosiatif
        $buku = [
            [
                'judul' => 'Laravel: From Beginner to Advanced',
                'pengarang' => 'Budi Raharjo',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2023,
                'harga' => 125000,
                'stok' => 15,
                'isbn' => '978-602-1234-56-7',
                'kategori' => 'Programming',
                'bahasa' => 'Indonesia',
                'halaman' => 520,
                'berat' => 700
            ],
            [
                'judul' => 'Pemrograman PHP Modern',
                'pengarang' => 'Andi Setiawan',
                'penerbit' => 'Elex Media',
                'tahun_terbit' => 2022,
                'harga' => 98000,
                'stok' => 10,
                'isbn' => '978-602-9876-54-3',
                'kategori' => 'Programming',
                'bahasa' => 'Indonesia',
                'halaman' => 450,
                'berat' => 600
            ],
            [
                'judul' => 'MySQL Database Administration',
                'pengarang' => 'John Smith',
                'penerbit' => 'OReilly',
                'tahun_terbit' => 2021,
                'harga' => 150000,
                'stok' => 8,
                'isbn' => '978-1-491-98765-2',
                'kategori' => 'Database',
                'bahasa' => 'Inggris',
                'halaman' => 380,
                'berat' => 550
            ],
            [
                'judul' => 'Desain Web Responsif',
                'pengarang' => 'Siti Aminah',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2020,
                'harga' => 87000,
                'stok' => 12,
                'isbn' => '978-602-1234-99-4',
                'kategori' => 'Web Design',
                'bahasa' => 'Indonesia',
                'halaman' => 300,
                'berat' => 400
            ]
        ];

        // Badge warna untuk kategori
        function kategoriBadge($kategori) {
            switch ($kategori) {
                case 'Programming':
                    return 'bg-success';
                case 'Database':
                    return 'bg-warning text-dark';
                case 'Web Design':
                    return 'bg-info text-dark';
                default:
                    return 'bg-secondary';
            }
        }
        ?>

        <div class="row row-cols-1 row-cols-md-2 g-4">
        <?php foreach ($buku as $b) : ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><?php echo $b['judul']; ?></h5>
                        <span class="badge <?php echo kategoriBadge($b['kategori']); ?>">
                            <?php echo $b['kategori']; ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="200">Pengarang</th>
                                <td>: <?php echo $b['pengarang']; ?></td>
                            </tr>
                            <tr>
                                <th>Penerbit</th>
                                <td>: <?php echo $b['penerbit']; ?></td>
                            </tr>
                            <tr>
                                <th>Tahun Terbit</th>
                                <td>: <?php echo $b['tahun_terbit']; ?></td>
                            </tr>
                            <tr>
                                <th>ISBN</th>
                                <td>: <?php echo $b['isbn']; ?></td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>: Rp <?php echo number_format($b['harga'], 0, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>: <?php echo $b['stok']; ?> buku</td>
                            </tr>
                            <tr>
                                <th>Bahasa</th>
                                <td>: <?php echo $b['bahasa']; ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah Halaman</th>
                                <td>: <?php echo $b['halaman']; ?> halaman</td>
                            </tr>
                            <tr>
                                <th>Berat</th>
                                <td>: <?php echo $b['berat']; ?> gram</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>