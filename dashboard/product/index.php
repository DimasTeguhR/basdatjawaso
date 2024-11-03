<?php
// Menyertakan file konfigurasi dan koneksi database
include_once "../../init.php";
include "../../genral/config.php";

// Menampilkan semua error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Menggunakan query langsung untuk mendapatkan data produk dari tabel `product`
$select = "SELECT * FROM product";
$s = mysqli_query($connectSQL, $select);

// Cek jika query berhasil
if (!$s) {
    die("Error executing query: " . mysqli_error($connectSQL));
}

// Penerapan Commit & Rollback untuk penghapusan produk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
  
    // Mulai transaksi
    mysqli_begin_transaction($connectSQL);

    try {
        // Hapus data produk berdasarkan ID
        $delete = "DELETE FROM product WHERE id = ?";
        $stmt = mysqli_prepare($connectSQL, $delete);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);

        // Commit transaksi jika penghapusan berhasil
        mysqli_commit($connectSQL);

        // Redirect ke halaman produk setelah penghapusan
        header("Location: " . $root_path . "/dashboard/product/index.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi kesalahan
        mysqli_rollback($connectSQL);

        // Tampilkan pesan error
        echo "Error: " . $e->getMessage();
    }
}

// Menyertakan layout
include "../../genral/functions.php";
include "../layouts/header.php";
include "../layouts/sidebar.php";
?>

<main class="app-content">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Display Products</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Descriptions</th>
                        <th scope="col">Price (Rp)</th>
                        <th scope="col">Category</th>
                        <th scope="col">Image</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php while($data = mysqli_fetch_assoc($s)) { ?>
                            <tr>
                                <td><?php echo $data['title']; ?></td>
                                <td><?php echo $data['descriptions']; ?></td>
                                <td><?php echo number_format($data['price'], 0, ',', '.'); ?></td>
                                <td><?php echo $data['categoryId']; ?></td>
                                <td><img style="width:50px;" src="./upload/<?php echo $data['image']; ?>" alt=""></td>
                                <td>
                                    <a href="<?php echo $root_path; ?>/dashboard/product/add.php?edit=<?php echo $data['id']; ?>" class="btn btn-info">Edit</a>
                                </td>
                                <td>
                                    <a href="<?php echo $root_path; ?>/dashboard/product/index.php?delete=<?php echo $data['id']; ?>" class="btn btn-danger">Remove</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php
include "../layouts/footer.php";
