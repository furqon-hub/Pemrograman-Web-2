<?php
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

// Hitung statistik
$total_anggota = count($anggota_list);
$aktif = 0;
$nonaktif = 0;
$total_pinjaman = 0;
$anggota_teraktif = null;
$max_pinjaman = -1;
foreach ($anggota_list as $anggota) {
	if (strtolower($anggota["status"]) == "aktif") {
		$aktif++;
	} else {
		$nonaktif++;
	}
	$total_pinjaman += $anggota["total_pinjaman"];
	if ($anggota["total_pinjaman"] > $max_pinjaman) {
		$max_pinjaman = $anggota["total_pinjaman"];
		$anggota_teraktif = $anggota;
	}
}
$persen_aktif = $total_anggota > 0 ? round($aktif / $total_anggota * 100, 1) : 0;
$persen_nonaktif = $total_anggota > 0 ? round($nonaktif / $total_anggota * 100, 1) : 0;
$rata_pinjaman = $total_anggota > 0 ? round($total_pinjaman / $total_anggota, 2) : 0;

// Filter berdasarkan status
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';
$anggota_filtered = $anggota_list;
if ($filter_status == 'Aktif' || $filter_status == 'Non-Aktif') {
	$anggota_filtered = array_filter($anggota_list, function($a) use ($filter_status) {
		return $a['status'] === $filter_status;
	});
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Data Anggota Perpustakaan</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
	<h2 class="mb-4">Data Anggota Perpustakaan</h2>
	<div class="row mb-4">
		<div class="col-md-2">
			<div class="card text-bg-primary mb-3">
				<div class="card-body">
					<h5 class="card-title">Total Anggota</h5>
					<p class="card-text fs-4"><?=$total_anggota?></p>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card text-bg-success mb-3">
				<div class="card-body">
					<h5 class="card-title">Aktif (%)</h5>
					<p class="card-text fs-4"><?=$aktif?> (<?=$persen_aktif?>%)</p>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<div class="card text-bg-danger mb-3">
				<div class="card-body">
					<h5 class="card-title">Non-Aktif (%)</h5>
					<p class="card-text fs-4"><?=$nonaktif?> (<?=$persen_nonaktif?>%)</p>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card text-bg-warning mb-3">
				<div class="card-body">
					<h5 class="card-title">Rata-rata Pinjaman</h5>
					<p class="card-text fs-4"><?=$rata_pinjaman?></p>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card text-bg-info mb-3">
				<div class="card-body">
					<h5 class="card-title">Anggota Teraktif</h5>
					<p class="card-text fs-6 mb-0"><?=$anggota_teraktif["nama"]?></p>
					<small>Total Pinjaman: <?=$anggota_teraktif["total_pinjaman"]?></small>
				</div>
			</div>
		</div>
	</div>

	<form class="mb-3" method="get">
		<div class="row g-2 align-items-center">
			<div class="col-auto">
				<label for="status" class="col-form-label">Filter Status:</label>
			</div>
			<div class="col-auto">
				<select name="status" id="status" class="form-select">
					<option value="">Semua</option>
					<option value="Aktif" <?=($filter_status=="Aktif"?'selected':'')?>>Aktif</option>
					<option value="Non-Aktif" <?=($filter_status=="Non-Aktif"?'selected':'')?>>Non-Aktif</option>
				</select>
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary">Terapkan</button>
			</div>
		</div>
	</form>

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
		<?php if (count($anggota_filtered) == 0): ?>
			<tr><td colspan="8" class="text-center">Tidak ada data anggota.</td></tr>
		<?php else: ?>
			<?php foreach ($anggota_filtered as $anggota): ?>
			<tr>
				<td><?=$anggota["id"]?></td>
				<td><?=$anggota["nama"]?></td>
				<td><?=$anggota["email"]?></td>
				<td><?=$anggota["telepon"]?></td>
				<td><?=$anggota["alamat"]?></td>
				<td><?=$anggota["tanggal_daftar"]?></td>
				<td><?=$anggota["status"]?></td>
				<td><?=$anggota["total_pinjaman"]?></td>
			</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>
	</table>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
