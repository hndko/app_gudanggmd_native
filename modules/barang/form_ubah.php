<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // mengecek data GET "id_barang"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol ubah
    $id_barang = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan" berdasarkan "id_barang"
    $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, a.foto, b.nama_jenis, c.nama_satuan, d.lokasi_rak, d.id_lokasi_rak
                                    FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c INNER JOIN tbl_lokasi_rak as d
                                    ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan AND a.lokasi_rak=d.id_lokasi_rak
                                    WHERE a.id_barang='$id_barang'")
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
  }
?>
  <!-- menampilkan pesan kesalahan unggah file -->
  <div id="pesan"></div>

  <div class="panel-header bg-primary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> Barang</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=barang" class="text-white">Barang</a></li>
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
        <div class="card-title">Ubah Data Barang</div>
      </div>
      <!-- form ubah data -->
      <form action="modules/barang/proses_ubah.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>Part Number <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                  </div>
                  <input type="text" name="id_barang" class="form-control" value="<?php echo $data['id_barang']; ?>" readonly placeholder="Part Number">
                </div>
              </div>

              <div class="form-group">
                <label>Nama Barang <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-box"></i></span>
                  </div>
                  <input type="text" name="nama_barang" class="form-control" autocomplete="off" value="<?php echo $data['nama_barang']; ?>" required placeholder="Masukkan Nama Barang">
                </div>
                <div class="invalid-feedback">Nama barang tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Jenis Barang <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-tags"></i></span>
                  </div>
                  <select name="jenis" class="form-control chosen-select" autocomplete="off" required>
                    <option value="<?php echo $data['jenis']; ?>"><?php echo $data['nama_jenis']; ?></option>
                    <option disabled value="">-- Pilih Kategori --</option>
                    <?php
                    // sql statement untuk menampilkan data dari tabel "tbl_jenis"
                    $query_jenis = mysqli_query($mysqli, "SELECT * FROM tbl_jenis ORDER BY nama_jenis ASC")
                      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                    // ambil data hasil query
                    while ($data_jenis = mysqli_fetch_assoc($query_jenis)) {
                      // tampilkan data
                      echo "<option value='$data_jenis[id_jenis]'>$data_jenis[nama_jenis]</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="invalid-feedback">Jenis Barang tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Stok Minimum <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                  </div>
                  <input type="text" name="stok_minimum" class="form-control" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" value="<?php echo $data['stok_minimum']; ?>" required placeholder="Masukkan Stok Minimum">
                </div>
                <div class="invalid-feedback">Stok minimum tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Satuan <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                  </div>
                  <select name="satuan" class="form-control chosen-select" autocomplete="off" required>
                    <option value="<?php echo $data['satuan']; ?>"><?php echo $data['nama_satuan']; ?></option>
                    <option disabled value="">-- Pilih Satuan --</option>
                    <?php
                    // sql statement untuk menampilkan data dari tabel "tbl_satuan"
                    $query_satuan = mysqli_query($mysqli, "SELECT * FROM tbl_satuan ORDER BY nama_satuan ASC")
                      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                    // ambil data hasil query
                    while ($data_satuan = mysqli_fetch_assoc($query_satuan)) {
                      // tampilkan data
                      echo "<option value='$data_satuan[id_satuan]'>$data_satuan[nama_satuan]</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="invalid-feedback">Satuan tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Lokasi Rak <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  </div>
                  <select name="lokasi_rak" class="form-control chosen-select" autocomplete="off" required>
                    <option value="<?php echo $data['id_lokasi_rak']; ?>"><?php echo $data['lokasi_rak']; ?></option>
                    <option disabled value="">-- Pilih Lokasi Gudang --</option>
                    <?php
                    // sql statement untuk menampilkan data dari tabel "tbl_lokasi_rak"
                    $query_lokasi_rak = mysqli_query($mysqli, "SELECT * FROM tbl_lokasi_rak ORDER BY lokasi_rak ASC")
                      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                    // ambil data hasil query
                    while ($data_lokasi_rak = mysqli_fetch_assoc($query_lokasi_rak)) {
                      // tampilkan data
                      echo "<option value='$data_lokasi_rak[id_lokasi_rak]'>$data_lokasi_rak[lokasi_rak]</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="invalid-feedback">Lokasi Rak tidak boleh kosong.</div>
              </div>
            </div>
            <div class="col-md-5 ml-auto">
              <div class="form-group">
                <label>Foto Barang</label>
                <input type="file" id="foto" name="foto" class="form-control" autocomplete="off">
                <div class="card mt-3 mb-3">
                  <div class="card-body text-center">
                    <?php
                    // mengecek data foto barang
                    // jika data "foto" tidak ada di database
                    if (is_null($data['foto'])) { ?>
                      <!-- tampilkan foto default -->
                      <img style="max-height:200px" src="uploads/no_image.png" class="img-fluid foto-preview" alt="Foto Barang">
                    <?php
                    }
                    // jika data "foto" ada di database
                    else { ?>
                      <!-- tampilkan foto barang dari database -->
                      <img style="max-height:200px" src="uploads/<?php echo $data['foto']; ?>" class="img-fluid foto-preview" alt="Foto Barang">
                    <?php } ?>
                  </div>
                </div>
                <small class="form-text text-primary">
                  Keterangan : <br>
                  - Tipe file yang bisa diunggah adalah *.jpg atau *.png. <br>
                  - Ukuran file yang bisa diunggah maksimal 1 Mb.
                </small>
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <button type="submit" name="simpan" class="btn btn-primary btn-round pl-4 pr-4 mr-2">
            <i class="fas fa-save"></i> Simpan
          </button>
          <!-- tombol kembali ke halaman data barang -->
          <a href="?module=barang" class="btn btn-default btn-round pl-4 pr-4">
            <i class="fas fa-undo"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      // validasi file dan preview file sebelum diunggah
      $('#foto').change(function() {
        // mengambil value dari file
        var filePath = $('#foto').val();
        var fileSize = $('#foto')[0].files[0].size;
        // tentukan extension file yang diperbolehkan
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

        // Jika tipe file yang diunggah tidak sesuai dengan "allowedExtensions"
        if (!allowedExtensions.exec(filePath)) {
          // tampilkan pesan peringatan tipe file tidak sesuai
          $('#pesan').html('<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-times"></span><span data-notify="title" class="text-danger">Gagal!</span> <span data-notify="message">Tipe file tidak sesuai. Harap unggah file yang memiliki tipe *.jpg atau *.png.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input file
          $('#foto').val('');
          // tampilkan file default
          $('.foto-preview').attr('src', 'uploads/no_image.png');

          return false;
        }
        // jika ukuran file yang diunggah lebih dari 1 Mb
        else if (fileSize > 1000000) {
          // tampilkan pesan peringatan ukuran file tidak sesuai
          $('#pesan').html('<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-times"></span><span data-notify="title" class="text-danger">Gagal!</span> <span data-notify="message">Ukuran file lebih dari 1 Mb. Harap unggah file yang memiliki ukuran maksimal 1 Mb.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input file
          $('#foto').val('');
          // tampilkan file default
          $('.foto-preview').attr('src', 'uploads/no_image.png');

          return false;
        }
        // jika file yang diunggah sudah sesuai, tampilkan preview file
        else {
          var fileInput = document.getElementById('foto');

          if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
              // preview file
              $('.foto-preview').attr('src', e.target.result);
            };
          };
          reader.readAsDataURL(fileInput.files[0]);
        }
      });
    });
  </script>
<?php } ?>