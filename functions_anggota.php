<?php
// 1. Function untuk hitung total anggota
function hitung_total_anggota($anggota_list) {
    return count($anggota_list);
}

// 2. Function untuk hitung anggota aktif
function hitung_anggota_aktif($anggota_list) {
    $count = 0;
    foreach ($anggota_list as $a) {
        if (strtolower($a['status']) === 'aktif') $count++;
    }
    return $count;
}

// 3. Function untuk hitung rata-rata pinjaman
function hitung_rata_rata_pinjaman($anggota_list) {
    if (count($anggota_list) == 0) return 0;
    $total = 0;
    foreach ($anggota_list as $a) {
        $total += $a['total_pinjaman'];
    }
    return round($total / count($anggota_list), 2);
}

// 4. Function untuk cari anggota by ID
function cari_anggota_by_id($anggota_list, $id) {
    foreach ($anggota_list as $a) {
        if ($a['id'] === $id) return $a;
    }
    return null;
}

// 5. Function untuk cari anggota teraktif
function cari_anggota_teraktif($anggota_list) {
    $max = -1;
    $teraktif = null;
    foreach ($anggota_list as $a) {
        if ($a['total_pinjaman'] > $max) {
            $max = $a['total_pinjaman'];
            $teraktif = $a;
        }
    }
    return $teraktif;
}

// 6. Function untuk filter by status
function filter_by_status($anggota_list, $status) {
    return array_filter($anggota_list, function($a) use ($status) {
        return strtolower($a['status']) === strtolower($status);
    });
}

// 7. Function untuk validasi email
function validasi_email($email) {
    return !empty($email) && strpos($email, '@') !== false && strpos($email, '.') !== false;
}

// 8. Function untuk format tanggal Indonesia
function format_tanggal_indo($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $parts = explode('-', $tanggal);
    if (count($parts) !== 3) return $tanggal;
    return ltrim($parts[2], '0') . ' ' . $bulan[(int)$parts[1]] . ' ' . $parts[0];
}

// BONUS: Sort anggota by nama (A-Z)
function sort_anggota_by_nama($anggota_list) {
    usort($anggota_list, function($a, $b) {
        return strcmp($a['nama'], $b['nama']);
    });
    return $anggota_list;
}

// BONUS: Search anggota by nama (partial match)
function search_anggota_by_nama($anggota_list, $keyword) {
    $keyword = strtolower($keyword);
    return array_filter($anggota_list, function($a) use ($keyword) {
        return strpos(strtolower($a['nama']), $keyword) !== false;
    });
}
