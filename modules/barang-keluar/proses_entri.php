<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk insert
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";
  require_once "../../helper/kirim_whatsapp.php";
  // mengecek data hasil submit dari form
  if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $id_transaksi  = mysqli_real_escape_string($mysqli, $_POST['id_transaksi']);
    $tanggal       = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
    $barang        = mysqli_real_escape_string($mysqli, $_POST['barang']);
    $jumlah        = mysqli_real_escape_string($mysqli, $_POST['jumlah']);
    $pic 	   = mysqli_real_escape_string($mysqli, $_POST['pic']);
    $keterangan    = mysqli_real_escape_string($mysqli, $_POST['keterangan']);
    $inputby       = mysqli_real_escape_string($mysqli, $_POST['inputby']);
    $status        = 'Barang Keluar';

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal_keluar = date('Y-m-d', strtotime($tanggal));

    // sql statement untuk insert data ke tabel "tbl_barang_keluar"
    $insert = mysqli_query($mysqli, "INSERT INTO tbl_barang_keluar(id_transaksi, tanggal, barang, jumlah, pic, keterangan, inputby) 
                                     VALUES('$id_transaksi', '$tanggal_keluar', '$barang', '$jumlah','$pic', '$keterangan', '$inputby')")
      or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));

    $insert = mysqli_query($mysqli, "INSERT INTO tbl_barang_masuk_keluar(id_transaksi, tanggal, barang, jumlah, status, keterangan, inputby) 
                                     VALUES('$id_transaksi', '$tanggal_keluar', '$barang', '$jumlah', '$status', '$keterangan', '$inputby')")
      or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman barang keluar dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=barang_keluar&pesan=1');
      // kirim notifikasi wa
        $query = mysqli_query($mysqli, "SELECT nama_barang FROM tbl_barang WHERE id_barang='$barang' LIMIT 1")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
        // ambil data hasil query
        $data_barang  = mysqli_fetch_assoc($query);

      $data_notif = [
        "number" => "6282285329673",
        "message" => "*".$status."*\nNo BON : ".$id_transaksi."\nNama Barang : ".$data_barang['nama_barang']."\nJumlah : ".$jumlah."\nPIC : ".$pic." \nKeterangan :".$keterangan
      ];

      $kirim = kirimWhatsapp($data_notif);
    }
  }
}
