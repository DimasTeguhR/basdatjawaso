# JAWASO

**JAWASO** adalah sebuah website toko online yang menyediakan perlengkapan untuk acara pernikahan dan ulang tahun. Proyek ini dibuat menggunakan **PHP** dan **MySQL** sebagai backend serta menyediakan berbagai fitur untuk mengelola produk, kategori, pesanan, dan pelanggan. 

## Fitur Utama
- **Manajemen Produk**: Admin dapat menambahkan, memperbarui, dan menghapus produk beserta kategorinya.
- **Pendaftaran & Otentikasi Pelanggan**: Pelanggan dapat mendaftar, mengelola profil, dan melakukan login untuk melakukan pembelian.
- **Proses Pembayaran**: Mendukung berbagai metode pembayaran (cash, QRIS, dan MasterCard).
- **Manajemen Pesanan**: Admin dapat melacak status pesanan, mulai dari proses hingga pengiriman.
- **Blog & Komentar**: Pelanggan dapat membuat blog dan berinteraksi dengan meninggalkan komentar.
- **Checkout & Ringkasan Order**: Menyediakan halaman checkout dengan ringkasan pesanan dan total harga.

## Struktur Database
Berikut adalah beberapa tabel inti dalam database:
- **admins**: Menyimpan data admin yang memiliki akses untuk mengelola produk dan pesanan.
- **category**: Menyimpan kategori produk.
- **product**: Menyimpan data produk termasuk gambar, deskripsi, harga, dan stok.
- **customers**: Menyimpan data pelanggan yang terdaftar.
- **orders**: Menyimpan data pesanan yang dilakukan oleh pelanggan.
- **order_manager**: Mengelola status dan metode pembayaran pesanan.
- **checkout**: Menyimpan rincian checkout untuk setiap pesanan.
- **blog & comment_blog**: Menyimpan artikel blog yang ditulis pelanggan serta komentar terkait.
