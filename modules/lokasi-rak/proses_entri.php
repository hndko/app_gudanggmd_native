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
    $lokasi_rak = mysqli_real_escape_string($mysqli, trim($_POST['lokasi_rak']));

    // mengecek "lokasi_rak" untuk mencegah data duplikat
    // sql statement untuk menampilkan data "lokasi_rak" dari tabel "tbl_lokasi_rak" berdasarkan input "lokasi_rak"
    $query = mysqli_query($mysqli, "SELECT lokasi_rak FROM tbl_lokasi_rak WHERE lokasi_rak='$lokasi_rak'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil jumlah baris data hasil query
    $rows = mysqli_num_rows($query);

    // cek hasil query
    // jika "lokasi_rak" sudah ada di tabel "tbl_lokasi_rak"
    if ($rows <> 0) {
      // alihkan ke halaman satuan dan tampilkan pesan gagal simpan data
      header("location: ../../main.php?module=lokasi_rak&pesan=4&lokasi_rak=$lokasi_rak");
    }
    // jika "lokasi_rak" belum ada di tabel "tbl_lokasi_rak"
    else {
      // sql statement untuk insert data ke tabel "tbl_lokasi_rak"
      $insert = mysqli_query($mysqli, "INSERT INTO tbl_lokasi_rak(lokasi_rak) 
                                       VALUES('$lokasi_rak')")
                                       or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
      // cek query
      // jika proses insert berhasil
      if ($insert) {
        // alihkan ke halaman satuan dan tampilkan pesan berhasil simpan data
        header('location: ../../main.php?module=lokasi_rak&pesan=1');
      }
    }
  }
}
