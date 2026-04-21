<?php
// Data buku (minimal 10)
$buku_list = [
	["kode"=>"B001","judul"=>"Pemrograman PHP","kategori"=>"Teknologi","pengarang"=>"Andi","penerbit"=>"Elexmedia","tahun"=>2020,"harga"=>85000,"stok"=>5],
	["kode"=>"B002","judul"=>"Belajar Laravel","kategori"=>"Teknologi","pengarang"=>"Budi","penerbit"=>"Gramedia","tahun"=>2021,"harga"=>95000,"stok"=>2],
	["kode"=>"B003","judul"=>"Dasar Akuntansi","kategori"=>"Ekonomi","pengarang"=>"Citra","penerbit"=>"Salemba","tahun"=>2019,"harga"=>78000,"stok"=>0],
	["kode"=>"B004","judul"=>"Fisika SMA","kategori"=>"Sains","pengarang"=>"Dewi","penerbit"=>"Erlangga","tahun"=>2018,"harga"=>67000,"stok"=>3],
	["kode"=>"B005","judul"=>"Kimia Dasar","kategori"=>"Sains","pengarang"=>"Eka","penerbit"=>"Erlangga","tahun"=>2017,"harga"=>72000,"stok"=>1],
	["kode"=>"B006","judul"=>"Sejarah Dunia","kategori"=>"Sosial","pengarang"=>"Fajar","penerbit"=>"Gramedia","tahun"=>2016,"harga"=>60000,"stok"=>4],
	["kode"=>"B007","judul"=>"Psikologi Remaja","kategori"=>"Psikologi","pengarang"=>"Gina","penerbit"=>"Andi","tahun"=>2022,"harga"=>88000,"stok"=>6],
	["kode"=>"B008","judul"=>"Matematika Diskrit","kategori"=>"Sains","pengarang"=>"Hadi","penerbit"=>"Salemba","tahun"=>2023,"harga"=>99000,"stok"=>0],
	["kode"=>"B009","judul"=>"Manajemen SDM","kategori"=>"Ekonomi","pengarang"=>"Indra","penerbit"=>"Elexmedia","tahun"=>2020,"harga"=>83000,"stok"=>2],
	["kode"=>"B010","judul"=>"Sosiologi Modern","kategori"=>"Sosial","pengarang"=>"Joko","penerbit"=>"Gramedia","tahun"=>2015,"harga"=>57000,"stok"=>7],
];

// Ambil parameter GET
$keyword = $_GET['keyword'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$min_harga = $_GET['min_harga'] ?? '';
$max_harga = $_GET['max_harga'] ?? '';
$tahun = $_GET['tahun'] ?? '';
$status = $_GET['status'] ?? 'semua';
$sort = $_GET['sort'] ?? 'judul';

// Validasi
$errors = [];
if ($min_harga !== '' && $max_harga !== '') {
	if ($min_harga > $max_harga) {
		$errors[] = "Harga minimum tidak boleh lebih besar dari harga maksimum";
	}
}
if ($tahun !== '' && ($tahun < 1900 || $tahun > date('Y'))) {
	$errors[] = "Tahun harus antara 1900 dan ".date('Y');
}

// Filter
$hasil = array_filter($buku_list, function($buku) use ($keyword, $kategori, $min_harga, $max_harga, $tahun, $status) {
	// Keyword (judul/pengarang)
	$match = true;
	if ($keyword !== '') {
		$match = stripos($buku['judul'], $keyword) !== false || stripos($buku['pengarang'], $keyword) !== false;
	}
	// Kategori
	if ($match && $kategori !== '' && $kategori !== 'semua') {
		$match = $buku['kategori'] === $kategori;
	}
	// Harga
	if ($match && $min_harga !== '') {
		$match = $buku['harga'] >= $min_harga;
	}
	if ($match && $max_harga !== '') {
		$match = $buku['harga'] <= $max_harga;
	}
	// Tahun
	if ($match && $tahun !== '') {
		$match = $buku['tahun'] == $tahun;
	}
	// Status
	if ($match && $status !== 'semua') {
		if ($status === 'tersedia') $match = $buku['stok'] > 0;
		elseif ($status === 'habis') $match = $buku['stok'] == 0;
	}
	return $match;
});

// Sorting
usort($hasil, function($a, $b) use ($sort) {
	if ($sort === 'judul') return strcasecmp($a['judul'], $b['judul']);
	if ($sort === 'harga') return $a['harga'] <=> $b['harga'];
	if ($sort === 'tahun') return $a['tahun'] <=> $b['tahun'];
	return 0;
});

// Pagination
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$per_page = 10;
$total = count($hasil);
$pages = ceil($total / $per_page);
$hasil_page = array_slice($hasil, ($page-1)*$per_page, $per_page);

// Kategori unik
$kategori_list = array_unique(array_column($buku_list, 'kategori'));
sort($kategori_list);
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pencarian Buku Lanjutan</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
	<h2 class="mb-4">Pencarian Buku Lanjutan</h2>

	<?php if ($errors): ?>
		<div class="alert alert-danger">
			<ul class="mb-0">
				<?php foreach($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form class="row g-3 mb-4" method="get">
		<div class="col-md-3">
			<input type="text" name="keyword" class="form-control" placeholder="Judul/Pengarang" value="<?= htmlspecialchars($keyword) ?>">
		</div>
		<div class="col-md-2">
			<select name="kategori" class="form-select">
				<option value="semua">Semua Kategori</option>
				<?php foreach($kategori_list as $kat): ?>
					<option value="<?= $kat ?>" <?= $kategori === $kat ? 'selected' : '' ?>><?= $kat ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="col-md-2">
			<input type="number" name="min_harga" class="form-control" placeholder="Min Harga" value="<?= htmlspecialchars($min_harga) ?>">
		</div>
		<div class="col-md-2">
			<input type="number" name="max_harga" class="form-control" placeholder="Max Harga" value="<?= htmlspecialchars($max_harga) ?>">
		</div>
		<div class="col-md-1">
			<input type="number" name="tahun" class="form-control" placeholder="Tahun" value="<?= htmlspecialchars($tahun) ?>">
		</div>
		<div class="col-md-2">
			<div class="d-flex gap-2">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="status" id="semua" value="semua" <?= $status==='semua'?'checked':'' ?>>
					<label class="form-check-label" for="semua">Semua</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="status" id="tersedia" value="tersedia" <?= $status==='tersedia'?'checked':'' ?>>
					<label class="form-check-label" for="tersedia">Tersedia</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="status" id="habis" value="habis" <?= $status==='habis'?'checked':'' ?>>
					<label class="form-check-label" for="habis">Habis</label>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<select name="sort" class="form-select">
				<option value="judul" <?= $sort==='judul'?'selected':'' ?>>Sort Judul</option>
				<option value="harga" <?= $sort==='harga'?'selected':'' ?>>Sort Harga</option>
				<option value="tahun" <?= $sort==='tahun'?'selected':'' ?>>Sort Tahun</option>
			</select>
		</div>
		<div class="col-md-2">
			<button type="submit" class="btn btn-primary w-100">Cari</button>
		</div>
	</form>

	<div class="mb-2">Ditemukan: <strong><?= $total ?></strong> hasil</div>

	<div class="table-responsive">
		<table class="table table-bordered table-striped align-middle">
			<thead class="table-light">
				<tr>
					<th>Kode</th>
					<th>Judul</th>
					<th>Kategori</th>
					<th>Pengarang</th>
					<th>Penerbit</th>
					<th>Tahun</th>
					<th>Harga</th>
					<th>Stok</th>
				</tr>
			</thead>
			<tbody>
			<?php if ($hasil_page): foreach($hasil_page as $buku): ?>
				<tr>
					<td><?= $buku['kode'] ?></td>
					<td><?= htmlspecialchars($buku['judul']) ?></td>
					<td><?= $buku['kategori'] ?></td>
					<td><?= htmlspecialchars($buku['pengarang']) ?></td>
					<td><?= $buku['penerbit'] ?></td>
					<td><?= $buku['tahun'] ?></td>
					<td>Rp<?= number_format($buku['harga'],0,',','.') ?></td>
					<td><?= $buku['stok'] > 0 ? $buku['stok'] : '<span class="badge bg-danger">Habis</span>' ?></td>
				</tr>
			<?php endforeach; else: ?>
				<tr><td colspan="8" class="text-center">Tidak ada data</td></tr>
			<?php endif; ?>
			</tbody>
		</table>
	</div>

	<!-- Pagination -->
	<nav>
		<ul class="pagination">
			<?php for($i=1;$i<=$pages;$i++): ?>
				<li class="page-item<?= $i==$page?' active':'' ?>">
					<a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page'=>$i])) ?>"><?= $i ?></a>
				</li>
			<?php endfor; ?>
		</ul>
	</nav>

</div>
</body>
</html>
