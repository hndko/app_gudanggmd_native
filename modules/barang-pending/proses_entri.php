<?php
session_start();      // mengaktifkan session

// pengecekan session login user
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../auth/login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk insert
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data hasil submit dari form
  if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $id_transaksi  = mysqli_real_escape_string($mysqli, $_POST['id_transaksi']);
    $tanggal       = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
    $barang        = mysqli_real_escape_string($mysqli, $_POST['barang']);
    $jumlah        = mysqli_real_escape_string($mysqli, $_POST['jumlah']);
    $keterangan        = mysqli_real_escape_string($mysqli, $_POST['keterangan']);
    $total        = mysqli_real_escape_string($mysqli, $_POST['total']);

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal_pending = date('Y-m-d', strtotime($tanggal));

    // Cek apakah id_transaksi sudah ada
    $query_cek = mysqli_query($mysqli, "SELECT id_transaksi FROM tbl_barang_pending WHERE id_transaksi='$id_transaksi'")
      or die('Ada kesalahan pada query cek id : ' . mysqli_error($mysqli));
    $rows_cek = mysqli_num_rows($query_cek);

    // Jika id_transaksi sudah ada, generate ID baru
    if ($rows_cek > 0) {
      $query_id = mysqli_query($mysqli, "SELECT RIGHT(id_transaksi,5) as nomor FROM tbl_barang_pending WHERE id_transaksi LIKE 'BP-" . date('dmY') . "%' ORDER BY id_transaksi DESC LIMIT 1")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $data_id = mysqli_fetch_assoc($query_id);
      if (mysqli_num_rows($query_id) <> 0) {
        $nomor_urut = intval($data_id['nomor']) + 1;
      } else {
        $nomor_urut = 1;
      }
      $id_transaksi = "BP-" . date("dmY") . "-" . str_pad($nomor_urut, 5, "0", STR_PAD_LEFT);
    }

    // sql statement untuk insert data ke tabel "tbl_barang_pending"
    $insert = mysqli_query($mysqli, "INSERT INTO tbl_barang_pending(id_transaksi, tanggal, barang, jumlah, keterangan)
                                     VALUES('$id_transaksi', '$tanggal_pending', '$barang', '$jumlah', '$keterangan')")
      or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));

    $update = mysqli_query($mysqli, "UPDATE tbl_barang SET barang_pending='$total' WHERE id_barang='$barang'")
      or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman barang pending dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=barang_pending&pesan=1');
    }
  }
}
