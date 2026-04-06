<?php
$nama_anggota = "Budi Santoso";
$total_pinjaman = 2;
$buku_terlambat = 1;
$hari_keterlambatan = 5; // hari

$maks_pinjaman = 3;
$denda_per_hari = 1000;
$maks_denda = 50000;

// Hitung total denda
$total_denda = $buku_terlambat * $hari_keterlambatan * $denda_per_hari;
if ($total_denda > $maks_denda) {
	$total_denda = $maks_denda;
}

// Cek status peminjaman
if ($buku_terlambat > 0) {
	$status_peminjaman = "Tidak bisa pinjam lagi (ada buku terlambat)";
} elseif ($total_pinjaman >= $maks_pinjaman) {
	$status_peminjaman = "Tidak bisa pinjam lagi (sudah mencapai batas maksimal)";
} else {
	$status_peminjaman = "Bisa pinjam lagi";
}

// Tentukan level member
switch (true) {
	case ($total_pinjaman >= 0 && $total_pinjaman <= 5):
		$level_member = "Bronze";
		break;
	case ($total_pinjaman >= 6 && $total_pinjaman <= 15):
		$level_member = "Silver";
		break;
	case ($total_pinjaman > 15):
		$level_member = "Gold";
		break;
	default:
		$level_member = "Tidak diketahui";
}

?>
<h2>Status Peminjaman Anggota Perpustakaan</h2>
<ul>
	<li><strong>Nama Anggota:</strong> <?= $nama_anggota ?></li>
	<li><strong>Total Pinjaman:</strong> <?= $total_pinjaman ?></li>
	<li><strong>Buku Terlambat:</strong> <?= $buku_terlambat ?></li>
	<li><strong>Hari Keterlambatan:</strong> <?= $hari_keterlambatan ?></li>
	<li><strong>Level Member:</strong> <?= $level_member ?></li>
</ul>

<h3>Status Peminjaman Saat Ini:</h3>
<p><?= $status_peminjaman ?></p>

<?php if ($buku_terlambat > 0): ?>
	<p style="color:red;"><strong>Peringatan:</strong> Anda memiliki buku yang terlambat dikembalikan!</p>
	<p><strong>Total Denda:</strong> Rp <?= number_format($total_denda, 0, ',', '.') ?></p>
<?php endif; ?>
