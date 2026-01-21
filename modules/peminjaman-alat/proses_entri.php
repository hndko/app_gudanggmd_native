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
    $tanggal_kembali   = mysqli_real_escape_string($mysqli, $_POST['tanggal_kembali']);
    $keterangan        = mysqli_real_escape_string($mysqli, $_POST['keterangan']);
    // $gambar          = mysqli_real_escape_string($mysqli, $_POST['gambar']);
    $status            = 'Barang Dipinjam';

    // ambil data file yang diupload
    $nama_file    = $_FILES['foto']['name'];
    $ukuran_file  = $_FILES['foto']['size'];
    $tipe_file    = $_FILES['foto']['type'];
    $tmp_file     = $_FILES['foto']['tmp_name'];

    // tentukan extension yang diperbolehkan
    $allowed_extensions = array('jpg', 'jpeg', 'png');
    // ambil extension file
    $file_extension = explode('.', $nama_file);
    $file_extension = strtolower(end($file_extension));

    // Cek jika ada file yang diupload
    if (!empty($nama_file)) {
      // Cek validitas extension
      if (in_array($file_extension, $allowed_extensions)) {
        // Cek ukuran file (maks 1MB)
        if ($ukuran_file <= 1000000) {
          // Generate nama file baru agar unik
          $nama_file_baru = uniqid() . '.' . $file_extension;
          $path_file      = "../../images/" . $nama_file_baru;

          // Upload file
          if (move_uploaded_file($tmp_file, $path_file)) {
            $gambar = $nama_file_baru;
          } else {
            // Jika gagal upload
            header('location: ../../main.php?module=peminjaman-alat&pesan=2');
            exit;
          }
        } else {
          // Ukuran terlalu besar
          header('location: ../../main.php?module=peminjaman-alat&pesan=3');
          exit;
        }
      } else {
        // Tipe file tidak sesuai
        header('location: ../../main.php?module=peminjaman-alat&pesan=4');
        exit;
      }
    } else {
      // Jika tidak ada file diupload, set gambar kosong atau default
      $gambar = "";
    }

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
