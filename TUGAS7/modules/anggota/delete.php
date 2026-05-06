<?php
require_once __DIR__ . '/database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
	header('Location: index.php');
	exit;
}

// Ambil data anggota
$q = $conn->query("SELECT foto FROM anggota WHERE id_anggota=$id");
if (!$q || $q->num_rows == 0) {
	header('Location: index.php');
	exit;
}
$data = $q->fetch_assoc();
$foto = $data['foto'];

// Hapus data
$del = $conn->query("DELETE FROM anggota WHERE id_anggota=$id");
if ($del) {
	// Hapus foto jika ada
	if ($foto && file_exists(__DIR__ . '/uploads/' . $foto)) {
		unlink(__DIR__ . '/uploads/' . $foto);
	}
	$msg = 'Anggota berhasil dihapus!';
} else {
	$msg = 'Gagal menghapus anggota.';
}
closeConnection();

// Redirect dengan pesan
header('Location: index.php?msg=' . urlencode($msg));
exit;
