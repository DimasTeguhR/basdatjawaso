<?php
session_start();
include 'koneksi.php'; 

// Ambil ID peminjaman dari form
$id_peminjaman = $_POST['id_peminjaman'];

// Mulai transaksi
$mysqli->begin_transaction();

try {
    // Ambil detail peminjaman berdasarkan ID peminjaman
    $queryPeminjaman = "SELECT id_buku, tanggal_kembali FROM peminjaman WHERE id_peminjaman = ?";
    $stmt = $mysqli->prepare($queryPeminjaman);
    $stmt->bind_param("i", $id_peminjaman);
    $stmt->execute();
    $stmt->bind_result($id_buku, $tanggal_kembali);
    $stmt->fetch();
    $stmt->close();

    if (!$id_buku) {
        throw new Exception("ID Peminjaman tidak ditemukan!");
    }

    // Hitung denda jika ada (denda per hari keterlambatan)
    $tanggal_pengembalian = date('Y-m-d');
    $denda_per_hari = 1000;
    $denda = 0;
    $status_pengembalian = 'Tepat Waktu';

    // Jika pengembalian melewati batas tanggal kembali, hitung denda
    if (strtotime($tanggal_pengembalian) > strtotime($tanggal_kembali)) {
        $hari_terlambat = (strtotime($tanggal_pengembalian) - strtotime($tanggal_kembali)) / (60 * 60 * 24);
        $denda = $hari_terlambat * $denda_per_hari;
        $status_pengembalian = 'Terlambat';
    }

    // Masukkan data pengembalian ke tabel pengembalian
    $queryPengembalian = "INSERT INTO pengembalian (tanggal_pengembalian, denda, status_pengembalian, id_peminjaman) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($queryPengembalian);
    $stmt->bind_param("sisi", $tanggal_pengembalian, $denda, $status_pengembalian, $id_peminjaman);
    $stmt->execute();
    $stmt->close();

    // Hapus data peminjaman dari tabel peminjaman
    $queryHapusPeminjaman = "DELETE FROM peminjaman WHERE id_peminjaman = ?";
    $stmt = $mysqli->prepare($queryHapusPeminjaman);
    $stmt->bind_param("i", $id_peminjaman);
    $stmt->execute();
    $stmt->close();

    // Update status buku menjadi 'tersedia'
    $queryUpdateBuku = "UPDATE buku SET status_peminjaman = 'tersedia' WHERE id_buku = ?";
    $stmt = $mysqli->prepare($queryUpdateBuku);
    $stmt->bind_param("i", $id_buku);
    $stmt->execute();
    $stmt->close();

    // Commit transaksi jika semua operasi berhasil
    $mysqli->commit();

    // Arahkan kembali ke halaman admin
    header("Location: admin.php");
    exit();

} catch (Exception $e) {
    // Rollback transaksi jika ada error
    $mysqli->rollback();
    echo "Pengembalian buku gagal: " . $e->getMessage();
    exit();
}

$mysqli->close();
?>