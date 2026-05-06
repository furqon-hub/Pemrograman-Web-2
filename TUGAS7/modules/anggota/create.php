<?php
require_once __DIR__ . '/database.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Ambil dan validasi data
	$kode_anggota = sanitize($_POST['kode_anggota'] ?? '');
	$nama = sanitize($_POST['nama'] ?? '');
	$email = sanitize($_POST['email'] ?? '');
	$telepon = sanitize($_POST['telepon'] ?? '');
	$alamat = sanitize($_POST['alamat'] ?? '');
	$tanggal_lahir = sanitize($_POST['tanggal_lahir'] ?? '');
	$jenis_kelamin = sanitize($_POST['jenis_kelamin'] ?? '');
	$pekerjaan = sanitize($_POST['pekerjaan'] ?? '');
	$tanggal_daftar = date('Y-m-d');
	$status = 'Aktif';
	$foto = '';

	// Validasi required
	if (!$kode_anggota || !$nama || !$email || !$telepon || !$alamat || !$tanggal_lahir || !$jenis_kelamin) {
		$errors[] = 'Semua field wajib diisi.';
	}
	// Validasi email
	if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = 'Format email tidak valid.';
	}
	// Validasi telepon
	if ($telepon && !preg_match('/^08[0-9]{8,11}$/', $telepon)) {
		$errors[] = 'Format telepon harus 08xxxxxxxxxx.';
	}
	// Validasi umur minimal 10 tahun
	if ($tanggal_lahir) {
		$umur = date_diff(date_create($tanggal_lahir), date_create('today'))->y;
		if ($umur < 10) {
			$errors[] = 'Umur minimal 10 tahun.';
		}
	}
	// Validasi kode/email unik
	$cek = $conn->query("SELECT id_anggota FROM anggota WHERE kode_anggota='$kode_anggota' OR email='$email'");
	if ($cek && $cek->num_rows > 0) {
		$errors[] = 'Kode anggota atau email sudah terdaftar.';
	}

	// Upload foto jika ada
	if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
		$ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
		$allowed = ['jpg', 'jpeg', 'png', 'gif'];
		if (!in_array($ext, $allowed)) {
			$errors[] = 'Format foto harus jpg, jpeg, png, atau gif.';
		} else {
			$foto = uniqid('foto_') . '.' . $ext;
			$upload_path = __DIR__ . '/uploads/' . $foto;
			if (!move_uploaded_file($_FILES['foto']['tmp_name'], $upload_path)) {
				$errors[] = 'Gagal upload foto.';
			}
		}
	}

	// Jika validasi lolos, insert ke database
	if (!$errors) {
		$stmt = $conn->prepare("INSERT INTO anggota (kode_anggota, nama, email, telepon, alamat, tanggal_lahir, jenis_kelamin, pekerjaan, tanggal_daftar, status, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('sssssssssss', $kode_anggota, $nama, $email, $telepon, $alamat, $tanggal_lahir, $jenis_kelamin, $pekerjaan, $tanggal_daftar, $status, $foto);
		if ($stmt->execute()) {
			$success = 'Anggota berhasil ditambahkan!';
			// Reset form
			$kode_anggota = $nama = $email = $telepon = $alamat = $tanggal_lahir = $jenis_kelamin = $pekerjaan = '';
			$foto = '';
		} else {
			$errors[] = 'Gagal menambah anggota. Coba lagi.';
		}
		$stmt->close();
	}
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah Anggota</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
	<h2 class="mb-4">Tambah Anggota Baru</h2>
	<a href="index.php" class="btn btn-secondary mb-3">&laquo; Kembali</a>

	<?php if ($errors): ?>
		<div class="alert alert-danger">
			<ul class="mb-0">
				<?php foreach ($errors as $e): ?><li><?= $e ?></li><?php endforeach; ?>
			</ul>
		</div>
	<?php elseif ($success): ?>
		<div class="alert alert-success"> <?= $success ?> </div>
	<?php endif; ?>

	<form method="post" enctype="multipart/form-data" class="row g-3">
		<div class="col-md-6">
			<label class="form-label">Kode Anggota *</label>
			<input type="text" name="kode_anggota" class="form-control" required value="<?= htmlspecialchars($kode_anggota ?? '') ?>">
		</div>
		<div class="col-md-6">
			<label class="form-label">Nama *</label>
			<input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($nama ?? '') ?>">
		</div>
		<div class="col-md-6">
			<label class="form-label">Email *</label>
			<input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($email ?? '') ?>">
		</div>
		<div class="col-md-6">
			<label class="form-label">Telepon *</label>
			<input type="text" name="telepon" class="form-control" required value="<?= htmlspecialchars($telepon ?? '') ?>" placeholder="08xxxxxxxxxx">
		</div>
		<div class="col-md-12">
			<label class="form-label">Alamat *</label>
			<textarea name="alamat" class="form-control" required><?= htmlspecialchars($alamat ?? '') ?></textarea>
		</div>
		<div class="col-md-4">
			<label class="form-label">Tanggal Lahir *</label>
			<input type="date" name="tanggal_lahir" class="form-control" required value="<?= htmlspecialchars($tanggal_lahir ?? '') ?>">
		</div>
		<div class="col-md-4">
			<label class="form-label">Jenis Kelamin *</label>
			<select name="jenis_kelamin" class="form-select" required>
				<option value="">- Pilih -</option>
				<option value="Laki-laki" <?= (isset($jenis_kelamin) && $jenis_kelamin=='Laki-laki')?'selected':'' ?>>Laki-laki</option>
				<option value="Perempuan" <?= (isset($jenis_kelamin) && $jenis_kelamin=='Perempuan')?'selected':'' ?>>Perempuan</option>
			</select>
		</div>
		<div class="col-md-4">
			<label class="form-label">Pekerjaan</label>
			<input type="text" name="pekerjaan" class="form-control" value="<?= htmlspecialchars($pekerjaan ?? '') ?>">
		</div>
		<div class="col-md-6">
			<label class="form-label">Foto (opsional)</label>
			<input type="file" name="foto" class="form-control" accept="image/*">
		</div>
		<div class="col-md-6 d-flex align-items-end">
			<button class="btn btn-primary w-100" type="submit">Simpan</button>
		</div>
	</form>
</div>
</body>
</html>
<?php closeConnection(); ?>
