<?php
$errors = [];
$values = [
	'nama' => '',
	'email' => '',
	'telepon' => '',
	'alamat' => '',
	'jk' => '',
	'tgl_lahir' => '',
	'pekerjaan' => '',
];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Ambil data
	foreach ($values as $k => $v) {
		$values[$k] = trim($_POST[$k] ?? '');
	}

	// Validasi Nama
	if ($values['nama'] === '') {
		$errors['nama'] = 'Nama wajib diisi';
	} elseif (mb_strlen($values['nama']) < 3) {
		$errors['nama'] = 'Nama minimal 3 karakter';
	}

	// Validasi Email
	if ($values['email'] === '') {
		$errors['email'] = 'Email wajib diisi';
	} elseif (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Format email tidak valid';
	}

	// Validasi Telepon
	if ($values['telepon'] === '') {
		$errors['telepon'] = 'Telepon wajib diisi';
	} elseif (!preg_match('/^08[0-9]{8,11}$/', $values['telepon'])) {
		$errors['telepon'] = 'Format telepon harus 08xxxxxxxxxx (10-13 digit)';
	}

	// Validasi Alamat
	if ($values['alamat'] === '') {
		$errors['alamat'] = 'Alamat wajib diisi';
	} elseif (mb_strlen($values['alamat']) < 10) {
		$errors['alamat'] = 'Alamat minimal 10 karakter';
	}

	// Validasi Jenis Kelamin
	if ($values['jk'] === '') {
		$errors['jk'] = 'Jenis kelamin wajib dipilih';
	}

	// Validasi Tanggal Lahir
	if ($values['tgl_lahir'] === '') {
		$errors['tgl_lahir'] = 'Tanggal lahir wajib diisi';
	} else {
		$umur = (int)date('Y') - (int)date('Y', strtotime($values['tgl_lahir']));
		$bulan = (int)date('m') - (int)date('m', strtotime($values['tgl_lahir']));
		$hari = (int)date('d') - (int)date('d', strtotime($values['tgl_lahir']));
		if ($bulan < 0 || ($bulan === 0 && $hari < 0)) {
			$umur--;
		}
		if ($umur < 10) {
			$errors['tgl_lahir'] = 'Umur minimal 10 tahun';
		}
	}

	// Validasi Pekerjaan
	if ($values['pekerjaan'] === '') {
		$errors['pekerjaan'] = 'Pekerjaan wajib dipilih';
	}

	if (!$errors) {
		$success = true;
	}
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Form Registrasi Anggota</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
	<h2 class="mb-4">Form Registrasi Anggota Perpustakaan</h2>

	<?php if ($success): ?>
		<div class="alert alert-success">Registrasi berhasil!</div>
		<div class="card mb-4">
			<div class="card-header">Data Anggota</div>
			<div class="card-body">
				<ul class="list-group list-group-flush">
					<li class="list-group-item"><strong>Nama:</strong> <?= htmlspecialchars($values['nama']) ?></li>
					<li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($values['email']) ?></li>
					<li class="list-group-item"><strong>Telepon:</strong> <?= htmlspecialchars($values['telepon']) ?></li>
					<li class="list-group-item"><strong>Alamat:</strong> <?= htmlspecialchars($values['alamat']) ?></li>
					<li class="list-group-item"><strong>Jenis Kelamin:</strong> <?= $values['jk'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></li>
					<li class="list-group-item"><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($values['tgl_lahir']) ?></li>
					<li class="list-group-item"><strong>Pekerjaan:</strong> <?= htmlspecialchars($values['pekerjaan']) ?></li>
				</ul>
			</div>
		</div>
	<?php endif; ?>

	<form method="post" novalidate>
		<div class="mb-3">
			<label class="form-label">Nama Lengkap</label>
			<input type="text" name="nama" class="form-control<?= isset($errors['nama']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['nama']) ?>" required minlength="3">
			<?php if (isset($errors['nama'])): ?><div class="invalid-feedback"> <?= $errors['nama'] ?> </div><?php endif; ?>
		</div>
		<div class="mb-3">
			<label class="form-label">Email</label>
			<input type="email" name="email" class="form-control<?= isset($errors['email']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['email']) ?>" required>
			<?php if (isset($errors['email'])): ?><div class="invalid-feedback"> <?= $errors['email'] ?> </div><?php endif; ?>
		</div>
		<div class="mb-3">
			<label class="form-label">Telepon</label>
			<input type="text" name="telepon" class="form-control<?= isset($errors['telepon']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['telepon']) ?>" required pattern="08[0-9]{8,11}">
			<?php if (isset($errors['telepon'])): ?><div class="invalid-feedback"> <?= $errors['telepon'] ?> </div><?php endif; ?>
		</div>
		<div class="mb-3">
			<label class="form-label">Alamat</label>
			<textarea name="alamat" class="form-control<?= isset($errors['alamat']) ? ' is-invalid' : '' ?>" required minlength="10"><?= htmlspecialchars($values['alamat']) ?></textarea>
			<?php if (isset($errors['alamat'])): ?><div class="invalid-feedback"> <?= $errors['alamat'] ?> </div><?php endif; ?>
		</div>
		<div class="mb-3">
			<label class="form-label">Jenis Kelamin</label><br>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="jk" id="jkL" value="L" <?= $values['jk'] === 'L' ? 'checked' : '' ?>>
				<label class="form-check-label" for="jkL">Laki-laki</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="jk" id="jkP" value="P" <?= $values['jk'] === 'P' ? 'checked' : '' ?>>
				<label class="form-check-label" for="jkP">Perempuan</label>
			</div>
			<?php if (isset($errors['jk'])): ?><div class="invalid-feedback d-block"> <?= $errors['jk'] ?> </div><?php endif; ?>
		</div>
		<div class="mb-3">
			<label class="form-label">Tanggal Lahir</label>
			<input type="date" name="tgl_lahir" class="form-control<?= isset($errors['tgl_lahir']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['tgl_lahir']) ?>" required>
			<?php if (isset($errors['tgl_lahir'])): ?><div class="invalid-feedback"> <?= $errors['tgl_lahir'] ?> </div><?php endif; ?>
		</div>
		<div class="mb-3">
			<label class="form-label">Pekerjaan</label>
			<select name="pekerjaan" class="form-select<?= isset($errors['pekerjaan']) ? ' is-invalid' : '' ?>" required>
				<option value="">-- Pilih --</option>
				<option value="Pelajar" <?= $values['pekerjaan'] === 'Pelajar' ? 'selected' : '' ?>>Pelajar</option>
				<option value="Mahasiswa" <?= $values['pekerjaan'] === 'Mahasiswa' ? 'selected' : '' ?>>Mahasiswa</option>
				<option value="Pegawai" <?= $values['pekerjaan'] === 'Pegawai' ? 'selected' : '' ?>>Pegawai</option>
				<option value="Lainnya" <?= $values['pekerjaan'] === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
			</select>
			<?php if (isset($errors['pekerjaan'])): ?><div class="invalid-feedback"> <?= $errors['pekerjaan'] ?> </div><?php endif; ?>
		</div>
		<button type="submit" class="btn btn-primary">Daftar</button>
	</form>
</div>
</body>
</html>
