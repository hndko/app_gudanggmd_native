<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk delete
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data GET "id_transaksi"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol hapus
    $id_peminjaman = mysqli_real_escape_string($mysqli, $_GET['id']);
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_kembali= date("Y-m-d H:i:s");

    // sql statement untuk delete data dari tabel "tbl_barang_keluar" berdasarkan "id_transaksi"
    $update = mysqli_query($mysqli, "UPDATE tbl_peminjaman_barang SET status='Barang Telah Dikembalikan', tanggal_kembali='$tanggal_kembali' WHERE id_peminjaman='$id_peminjaman'")
      or die('Ada kesalahan pada query delete : ' . mysqli_error($mysqli));

    // cek query
    // jika proses delete berhasil
    if ($update) {
      // alihkan ke halaman barang keluar dan tampilkan pesan berhasil hapus data
      header('location: ../../main.php?module=peminjaman-alat&pesan=2');
    }
  }
}
