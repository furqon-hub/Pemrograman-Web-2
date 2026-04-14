<?php
require_once 'functions_anggota.php';
$anggota_list = [
	[
		"id" => "AGT-001",
		"nama" => "Budi Santoso",
		"email" => "budi@email.com",
		"telepon" => "081234567890",
		"alamat" => "Jakarta",
		"tanggal_daftar" => "2024-01-15",
		"status" => "Aktif",
		"total_pinjaman" => 5
	],
	[
		"id" => "AGT-002",
		"nama" => "Siti Aminah",
		"email" => "siti@email.com",
		"telepon" => "081298765432",
		"alamat" => "Bandung",
		"tanggal_daftar" => "2024-02-10",
		"status" => "Non-Aktif",
		"total_pinjaman" => 2
	],
	[
		"id" => "AGT-003",
		"nama" => "Andi Wijaya",
		"email" => "andi@email.com",
		"telepon" => "081212345678",
		"alamat" => "Surabaya",
		"tanggal_daftar" => "2024-03-05",
		"status" => "Aktif",
		"total_pinjaman" => 7
	],
	[
		"id" => "AGT-004",
		"nama" => "Dewi Lestari",
		"email" => "dewi@email.com",
		"telepon" => "081223344556",
		"alamat" => "Yogyakarta",
		"tanggal_daftar" => "2024-01-25",
		"status" => "Aktif",
		"total_pinjaman" => 3
	],
	[
		"id" => "AGT-005",
		"nama" => "Rudi Hartono",
		"email" => "rudi@email.com",
		"telepon" => "081234567891",
		"alamat" => "Semarang",
		"tanggal_daftar" => "2024-04-01",
		"status" => "Non-Aktif",
		"total_pinjaman" => 1
	],
];

// Proses sort dan search
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$anggota_tampil = $anggota_list;
if ($search !== '') {
	$anggota_tampil = search_anggota_by_nama($anggota_tampil, $search);
}
if ($sort === 'nama') {
	$anggota_tampil = sort_anggota_by_nama($anggota_tampil);
}

$total = hitung_total_anggota($anggota_list);
$aktif = hitung_anggota_aktif($anggota_list);
$nonaktif = $total - $aktif;
$rata = hitung_rata_rata_pinjaman($anggota_list);
$anggota_teraktif = cari_anggota_teraktif($anggota_list);
$anggota_aktif_list = filter_by_status($anggota_list, 'Aktif');
$anggota_nonaktif_list = filter_by_status($anggota_list, 'Non-Aktif');
$persen_aktif = $total > 0 ? round($aktif / $total * 100, 1) : 0;
$persen_nonaktif = $total > 0 ? round($nonaktif / $total * 100, 1) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sistem Anggota Perpustakaan</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
	<div class="container mt-5">
		<h1 class="mb-4"><i class="bi bi-people"></i> Sistem Anggota Perpustakaan</h1>
		<!-- Dashboard Statistik -->
		<div class="row mb-4">
			<div class="col-md-2">
				<div class="card text-bg-primary mb-3">
					<div class="card-body">
						<h6 class="card-title">Total Anggota</h6>
						<p class="card-text fs-4"><?=$total?></p>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="card text-bg-success mb-3">
					<div class="card-body">
						<h6 class="card-title">Aktif (%)</h6>
						<p class="card-text fs-4"><?=$aktif?> (<?=$persen_aktif?>%)</p>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="card text-bg-danger mb-3">
					<div class="card-body">
						<h6 class="card-title">Non-Aktif (%)</h6>
						<p class="card-text fs-4"><?=$nonaktif?> (<?=$persen_nonaktif?>%)</p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card text-bg-warning mb-3">
					<div class="card-body">
						<h6 class="card-title">Rata-rata Pinjaman</h6>
						<p class="card-text fs-4"><?=$rata?></p>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="card text-bg-info mb-3">
					<div class="card-body">
						<h6 class="card-title">Anggota Teraktif</h6>
						<p class="card-text fs-6 mb-0"><?=$anggota_teraktif["nama"]?></p>
						<small>Total Pinjaman: <?=$anggota_teraktif["total_pinjaman"]?></small>
					</div>
				</div>
			</div>
		</div>

		<!-- Tabel Anggota -->
		<div class="card mb-4">
			<div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
				<h5 class="mb-0">Daftar Anggota</h5>
				<form class="d-flex" method="get" style="gap:8px;">
					<input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama..." value="<?=htmlspecialchars($search)?>">
					<button type="submit" class="btn btn-light btn-sm"><i class="bi bi-search"></i></button>
					<input type="hidden" name="sort" value="<?=htmlspecialchars($sort)?>">
				</form>
				<a href="?sort=nama" class="btn btn-warning btn-sm ms-2">Sort Nama A-Z</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead class="table-dark">
						<tr>
							<th>ID</th>
							<th>Nama</th>
							<th>Email</th>
							<th>Telepon</th>
							<th>Alamat</th>
							<th>Tanggal Daftar</th>
							<th>Status</th>
							<th>Total Pinjaman</th>
						</tr>
					</thead>
					<tbody>
					<?php if (count($anggota_tampil) == 0): ?>
						<tr><td colspan="8" class="text-center">Tidak ada data anggota.</td></tr>
					<?php else: ?>
						<?php foreach ($anggota_tampil as $anggota): ?>
						<tr>
							<td><?=$anggota["id"]?></td>
							<td><?=$anggota["nama"]?></td>
							<td><?=$anggota["email"]?></td>
							<td><?=$anggota["telepon"]?></td>
							<td><?=$anggota["alamat"]?></td>
							<td><?=format_tanggal_indo($anggota["tanggal_daftar"])?></td>
							<td><?=$anggota["status"]?></td>
							<td><?=$anggota["total_pinjaman"]?></td>
						</tr>
						<?php endforeach; ?>
					<?php endif; ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>

		<!-- Anggota Teraktif -->
		<div class="card mb-4">
			<div class="card-header bg-success text-white">
				<h5 class="mb-0">Anggota Teraktif</h5>
			</div>
			<div class="card-body">
				<?php if ($anggota_teraktif): ?>
					<ul class="list-group">
						<li class="list-group-item"><b>ID:</b> <?=$anggota_teraktif["id"]?></li>
						<li class="list-group-item"><b>Nama:</b> <?=$anggota_teraktif["nama"]?></li>
						<li class="list-group-item"><b>Email:</b> <?=$anggota_teraktif["email"]?></li>
						<li class="list-group-item"><b>Telepon:</b> <?=$anggota_teraktif["telepon"]?></li>
						<li class="list-group-item"><b>Alamat:</b> <?=$anggota_teraktif["alamat"]?></li>
						<li class="list-group-item"><b>Tanggal Daftar:</b> <?=format_tanggal_indo($anggota_teraktif["tanggal_daftar"])?></li>
						<li class="list-group-item"><b>Status:</b> <?=$anggota_teraktif["status"]?></li>
						<li class="list-group-item"><b>Total Pinjaman:</b> <?=$anggota_teraktif["total_pinjaman"]?></li>
					</ul>
				<?php else: ?>
					<p>Tidak ada data anggota teraktif.</p>
				<?php endif; ?>
			</div>
		</div>

		<!-- Daftar Anggota Aktif & Non-Aktif -->
		<div class="row mb-4">
			<div class="col-md-6">
				<div class="card border-success mb-3">
					<div class="card-header bg-success text-white">Anggota Aktif</div>
					<div class="card-body">
						<ul class="list-group">
						<?php foreach ($anggota_aktif_list as $a): ?>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<?=$a["nama"]?>
								<span class="badge bg-success"><?=$a["id"]?></span>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card border-danger mb-3">
					<div class="card-header bg-danger text-white">Anggota Non-Aktif</div>
					<div class="card-body">
						<ul class="list-group">
						<?php foreach ($anggota_nonaktif_list as $a): ?>
							<li class="list-group-item d-flex justify-content-between align-items-center">
								<?=$a["nama"]?>
								<span class="badge bg-danger"><?=$a["id"]?></span>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
