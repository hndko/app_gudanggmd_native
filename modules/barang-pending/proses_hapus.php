<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../auth/login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk delete
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data GET "id_transaksi"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol hapus
    $id_transaksi = mysqli_real_escape_string($mysqli, $_GET['id']);
    $jumlah        = mysqli_query($mysqli, "SELECT jumlah FROM tbl_barang_pending WHERE id_transaksi='$id_transaksi'");
    $barangPending = mysqli_query($mysqli, "SELECT a.barang, b.barang_pending FROM tbl_barang_pending as a INNER JOIN tbl_barang as b WHERE b.id_barang = a.barang");
    $dataPending = mysqli_fetch_assoc($jumlah);
    $dataBarangPending = mysqli_fetch_assoc($barangPending);
    $pengurangan = $dataBarangPending["barang_pending"] - $dataPending["jumlah"];
    $id_barang = $dataBarangPending["barang"];
    echo "<script>console.log('Debug Objects: " . $dataPending["jumlah"] . "' );</script>";
    echo "<script>console.log('Debug Objects: " . $dataBarangPending["barang_pending"] . "' );</script>";
    echo "<script>console.log('Debug Objects: " . $pengurangan . "' );</script>";
    echo "<script>console.log('Debug Objects: " . $id_barang . "' );</script>";
    
    $update = mysqli_query($mysqli, "UPDATE tbl_barang SET barang_pending='$pengurangan' WHERE id_barang='$id_barang'")
      or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));


    // sql statement untuk delete data dari tabel "tbl_barang_pending" berdasarkan "id_transaksi"
    $delete = mysqli_query($mysqli, "DELETE FROM tbl_barang_pending WHERE id_transaksi='$id_transaksi'")
                                     or die('Ada kesalahan pada query delete : ' . mysqli_error($mysqli));
    // cek query
    // jika proses delete berhasil
    if ($delete) {
      // alihkan ke halaman barang pending dan tampilkan pesan berhasil hapus data
      header('location: ../../main.php?module=barang_pending&pesan=2');
      // echo "<script>console.log('Berhasil' );</script>";
    }
  }
}
