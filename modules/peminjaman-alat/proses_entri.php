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
  if (isset($_POST['simpan_peminjaman'])) {
    // ambil data hasil submit dari form
    $nama_barang       = mysqli_real_escape_string($mysqli, $_POST['nama_barang']);
    $jumlah_peminjaman = mysqli_real_escape_string($mysqli, $_POST['jumlah_peminjaman']);
    $pic               = mysqli_real_escape_string($mysqli, $_POST['pic']);
    $tanggal           = mysqli_real_escape_string($mysqli, $_POST['tanggal_pinjam']);
    // $tanggal_kembali   = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
    $keterangan      = mysqli_real_escape_string($mysqli, $_POST['keterangan']);
    $gambar          = mysqli_real_escape_string($mysqli, $_POST['gambar']);
    $status          = 'Barang Dipinjam';

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    // $tanggal_pinjam = date('Y-m-d H:i:s', strtotime($tanggal));

    // sql statement untuk insert data ke tabel "tbl_peminjaman_barang"
    $insert = mysqli_query($mysqli, "INSERT INTO tbl_peminjaman_barang(nama_barang, jumlah_peminjaman, pic, tanggal_pinjam, tanggal_kembali, keterangan, gambar,  status)
                                     VALUES('$nama_barang', '$jumlah_peminjaman', '$pic', '$tanggal', '$tanggal_kembali', '$keterangan', '$gambar', '$status')")
      or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman barang masuk dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=peminjaman-alat&pesan=1');
      // kirim notifikasi wa

      $data_notif_2 = [
        "number" => "6282285329673",
        "message" => "*INFO PEMINJAMAN BARANG GMD/BMD*\nNama Barang : " . $nama_barang . "\nJumlah Peminjaman : " . $jumlah_peminjaman . "\ntanggal_pinjam : " . $tanggal . "\ntanggal_kembali:" . $tanggal_kembali . "\nketerangan:" . $keterangan . "\nstatus:" . $status
      ];

      $kirim = kirimWhatsapp($data_notif_2);
    }
  }
}
