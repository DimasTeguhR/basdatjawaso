<?php
include_once "./genral/config.php";

// Periksa apakah 'order_id' ada di $_POST
if (!isset($_POST['order_id'])) {
    echo "Error: Order ID tidak ditemukan.";
    exit();
}

// Ambil ID pesanan dari form
$order_id = $_POST['order_id'];

// Mulai transaksi
$mysqli->begin_transaction();

try {
    // Ambil detail pesanan berdasarkan ID pesanan
    $queryOrder = "SELECT productId, quantity, order_status FROM orders WHERE id = ?";
    $stmt = $mysqli->prepare($queryOrder);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($product_id, $quantity, $order_status);
    $stmt->fetch();
    $stmt->close();

    if (!$product_id) {
        throw new Exception("ID Pesanan tidak ditemukan!");
    }

    // Cek status pesanan sebelum melanjutkan
    if ($order_status !== 'OnProcess') {
        throw new Exception("Pesanan tidak dapat dibatalkan karena statusnya bukan 'OnProcess'.");
    }

    // Tambahkan stok kembali ke produk
    $queryUpdateStock = "UPDATE product SET stok = stok + ? WHERE id = ?";
    $stmt = $mysqli->prepare($queryUpdateStock);
    $stmt->bind_param("ii", $quantity, $product_id);
    $stmt->execute();
    $stmt->close();

    // Hapus data pesanan dari tabel orders
    $queryDeleteOrder = "DELETE FROM orders WHERE id = ?";
    $stmt = $mysqli->prepare($queryDeleteOrder);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->close();

    // Hapus data terkait di order_manager
    $queryDeleteOrderManager = "DELETE FROM order_manager WHERE order_Id = ?";
    $stmt = $mysqli->prepare($queryDeleteOrderManager);
    $stmt->bind_param("i", $order_id);
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
    echo "Penghapusan pesanan gagal: " . $e->getMessage();
    exit();
}

$mysqli->close();
?>
