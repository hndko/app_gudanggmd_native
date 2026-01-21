<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // mengecek data GET "id_lokasi_rak"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol ubah
    $id_lokasi_rak = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_lokasi_rak" berdasarkan "id_lokasi_rak"
    $query = mysqli_query($mysqli, "SELECT * FROM tbl_lokasi_rak WHERE id_lokasi_rak='$id_lokasi_rak'")
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
  }
?>
  <div class="panel-header bg-primary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> lokasi_rak</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=lokasi_rak" class="text-white">lokasi_rak</a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Ubah</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title">Ubah Data lokasi_rak</div>
      </div>
      <!-- form ubah data -->
      <form action="modules/lokasi-rak/proses_ubah.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <input type="hidden" name="id_lokasi_rak" value="<?php echo $data['id_lokasi_rak']; ?>">

          <div class="form-group">
            <label>Lokasi Gudang <span class="text-danger">*</span></label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
              </div>
              <input type="text" name="lokasi_rak" class="form-control col-lg-5" autocomplete="off" value="<?php echo $data['lokasi_rak']; ?>" required placeholder="Masukkan Lokasi Gudang">
            </div>
            <div class="invalid-feedback">Lokasi Gudang tidak boleh kosong.</div>
          </div>
        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <button type="submit" name="simpan" class="btn btn-primary btn-round pl-4 pr-4 mr-2">
            <i class="fas fa-save"></i> Simpan
          </button>
          <!-- tombol kembali ke halaman data lokasi_rak -->
          <a href="?module=lokasi_rak" class="btn btn-default btn-round pl-4 pr-4">
            <i class="fas fa-undo"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>
<?php } ?>