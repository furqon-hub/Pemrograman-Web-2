	<?php if (isset($_GET['msg'])): ?>
		<div class="alert alert-info"> <?= htmlspecialchars($_GET['msg']) ?> </div>
	<?php endif; ?>
<?php
require_once __DIR__ . '/database.php';

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$where = '';
if ($search) {
	$where = "WHERE nama LIKE '%$search%' OR email LIKE '%$search%' OR telepon LIKE '%$search%'";
}

// Hitung total data
$sql_count = "SELECT COUNT(*) as total FROM anggota $where";
$result_count = $conn->query($sql_count);
$total_rows = $result_count ? $result_count->fetch_assoc()['total'] : 0;
$total_pages = ceil($total_rows / $limit);

// Query data anggota
$sql = "SELECT * FROM anggota $where ORDER BY id_anggota DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Bootstrap 5
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Daftar Anggota Perpustakaan</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
	<h2 class="mb-4">Daftar Anggota Perpustakaan</h2>
	<form class="row mb-3" method="get">
		<div class="col-md-4">
			<input type="text" name="search" class="form-control" placeholder="Cari nama/email/telepon" value="<?= htmlspecialchars($search) ?>">
		</div>
		<div class="col-md-2">
			<button class="btn btn-primary" type="submit">Cari</button>
		</div>
		<div class="col-md-6 text-end">
			<a href="create.php" class="btn btn-success">+ Tambah Anggota</a>
		</div>
	</form>

	<div class="table-responsive">
	<table class="table table-bordered table-hover align-middle">
		<thead class="table-light">
			<tr>
				<th>No</th>
				<th>Foto</th>
				<th>Kode</th>
				<th>Nama</th>
				<th>Email</th>
				<th>Telepon</th>
				<th>Jenis Kelamin</th>
				<th>Status</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
		<?php if ($result && $result->num_rows > 0): $no = $offset + 1; while($row = $result->fetch_assoc()): ?>
			<tr>
				<td><?= $no++ ?></td>
				<td>
					<?php if (!empty($row['foto']) && file_exists(__DIR__ . '/uploads/' . $row['foto'])): ?>
						<img src="uploads/<?= htmlspecialchars($row['foto']) ?>" alt="foto" width="48" height="48" class="rounded-circle" style="object-fit:cover;">
					<?php else: ?>
						<span class="text-muted">-</span>
					<?php endif; ?>
				</td>
				<td><?= htmlspecialchars($row['kode_anggota']) ?></td>
				<td><?= htmlspecialchars($row['nama']) ?></td>
				<td><?= htmlspecialchars($row['email']) ?></td>
				<td><?= htmlspecialchars($row['telepon']) ?></td>
				<td>
					<span class="badge bg-<?= $row['jenis_kelamin'] === 'Laki-laki' ? 'primary' : 'pink' ?>">
						<?= htmlspecialchars($row['jenis_kelamin']) ?>
					</span>
				</td>
				<td>
					<span class="badge bg-<?= $row['status'] === 'Aktif' ? 'success' : 'secondary' ?>">
						<?= htmlspecialchars($row['status']) ?>
					</span>
				</td>
				<td>
					<a href="edit.php?id=<?= $row['id_anggota'] ?>" class="btn btn-warning btn-sm">Edit</a>
					<a href="delete.php?id=<?= $row['id_anggota'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus anggota ini?')">Hapus</a>
				</td>
			</tr>
		<?php endwhile; else: ?>
			<tr><td colspan="9" class="text-center">Data tidak ditemukan.</td></tr>
		<?php endif; ?>
		</tbody>
	</table>
	</div>

	<!-- Pagination -->
	<nav>
		<ul class="pagination justify-content-center">
			<?php for ($i = 1; $i <= $total_pages; $i++): ?>
				<li class="page-item <?= $i == $page ? 'active' : '' ?>">
					<a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
				</li>
			<?php endfor; ?>
		</ul>
	</nav>
</div>
</body>
</html>
<?php closeConnection(); ?>
