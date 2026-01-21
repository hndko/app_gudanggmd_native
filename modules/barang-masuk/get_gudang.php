<?php
// pengecekan ajax request untuk mencegah direct access file, agar file tidak bisa diakses secara langsung dari browser
// jika ada ajax request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data GET dari ajax
  if (isset($_GET['lokasi_rak'])) {
    // ambil data GET dari ajax
    $lokasi_rak = $_GET['lokasi_rak'];

    // sql statement untuk menampilkan data dari tabel "tbl_barang" dan tabel "tbl_satuan" berdasarkan "lokasi_rak"
    $query = mysqli_query($mysqli, "SELECT id_barang, nama_barang, lokasi_rak FROM tbl_barang
                                    WHERE lokasi_rak='$lokasi_rak' ORDER BY nama_barang ASC")
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
      $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}
// jika tidak ada ajax request
else {
  // alihkan ke halaman error 404
  header('location: ../../404.html');
}
