<?php
$actual_link = $_SERVER['REQUEST_URI'];
$link = parse_url($actual_link);
$path = explode('=', $link['query']);
if (count($path) > 2) {
  $part_number = $path[2];
} else {
  $part_number = null;
}
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { ?>

  <!-- menampilkan pesan kesalahan -->
  <div id="pesan"></div>

  <div class="panel-header bg-primary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-sign-out-alt mr-2"></i> Barang Keluar</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=barang_keluar" class="text-white">Barang Keluar</a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Entri</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title">Entri Data Barang Keluar</div>
      </div>
      <!-- form entri data -->
      <form action="modules/barang-keluar/proses_entri.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <?php
                // membuat "id_transaksi"
                // sql statement untuk menampilkan 7 digit terakhir dari "id_transaksi" pada tabel "tbl_barang_keluar"
                $query = mysqli_query($mysqli, "SELECT RIGHT(id_transaksi,5) as nomor FROM tbl_barang_keluar ORDER BY id_transaksi DESC LIMIT 1")
                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil jumlah baris data hasil query
                $rows = mysqli_num_rows($query);

                // cek hasil query
                // jika "id_transaksi" sudah ada
                if ($rows <> 0) {
                  // ambil data hasil query
                  $data = mysqli_fetch_assoc($query);
                  // nomor urut "id_transaksi" yang terakhir + 1 (contoh nomor urut yang terakhir adalah 2, maka 2 + 1 = 3, dst..)
                  $nomor_urut = $data['nomor'] + 1;
                }
                // jika "id_transaksi" belum ada
                else {
                  // nomor urut "id_transaksi" = 1
                  $nomor_urut = 1;
                }

                // menambahkan karakter "TK-" diawal dan karakter "0" disebelah kiri nomor urut
                $id_transaksi = "BK-" .  date("dmY") . "-" . str_pad($nomor_urut, 5, "0", STR_PAD_LEFT);
                ?>
                <label>ID Transaksi <span class="text-danger">*</span></label>
                <!-- tampilkan "id_transaksi" -->
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-receipt"></i></span>
                  </div>
                  <input type="text" name="id_transaksi" class="form-control" value="<?php echo $id_transaksi; ?>" readonly>
                </div>
              </div>
            </div>

            <div class="col-md-5 ml-auto">
              <div class="form-group">
                <label>Tanggal <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                  </div>
                  <input type="text" name="tanggal" class="form-control date-picker" autocomplete="off" value="<?php echo date("d-m-Y"); ?>" required>
                </div>
                <div class="invalid-feedback">Tanggal tidak boleh kosong.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>Keterangan <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                  </div>
                  <input type="text" name="keterangan" class="form-control" required placeholder="Keterangan Barang Keluar">
                </div>
                <div class="invalid-feedback">Keterangan tidak boleh kosong.</div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label>Input <span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input value="<?php echo $_SESSION['nama_user']; ?>" type="text" name="inputby" class="form-control" readonly required>
                </div>
                <div class="invalid-feedback">Data tidak boleh kosong.</div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                PIC<span class="text-danger">*</span></label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <select name="pic" class="form-control js-example-basic-single">
                    <option value='0'>--Pilih--</option>
                    <option value='Fikri santoso'>Fikri Santoso</option>
                    <option value='Surip'>Surip</option>
                    <option value='Sri'>Sri</option>
                    <option value='Rustambi'>Rustambi</option>
                    <option value='H.Tambir'>H.Tambir</option>
                    <option value='Yusuf/eman'>Yusuf/Ehen</option>
                    <option value='Amir'>Amir</option>
                    <option value='Iyus'>Iyus</option>
                  </select>
                </div>
                <div class="invalid-feedback">Keterangan tidak boleh kosong.</div>
              </div>
            </div>
          </div>

          <hr class="mt-3 mb-4">
          <div class="py-3" id="keluar-barang">
            <div class="row">
              <div class="col-md-7">
                <?php if ($part_number == null) { ?>
                  <div class="form-group">
                    <label>Barang <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box"></i></span>
                      </div>
                      <select class="form-control js-example-basic-single" id="data_barang" name="barang" class="form-control chosen-select" autocomplete="off" required>
                        <option selected disabled value="">-- Pilih --</option>
                        <?php
                        // sql statement untuk menampilkan data dari tabel "tbl_barang"
                        $query_barang = mysqli_query($mysqli, "SELECT id_barang, nama_barang FROM tbl_barang ORDER BY id_barang ASC")
                          or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                        // ambil data hasil query
                        while ($data_barang = mysqli_fetch_assoc($query_barang)) {
                          // tampilkan data
                          echo "<option value='$data_barang[id_barang]'>$data_barang[id_barang] - $data_barang[nama_barang]</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="invalid-feedback">Barang tidak boleh kosong.</div>
                  </div>
                <?php } else { ?>
                  <div class="form-group">
                    <label>Barang <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-box"></i></span>
                      </div>
                      <select class="js-example-basic-single form-control" id="data_barang" name="barang" autocomplete="off" required>
                        <?php
                        // sql statement untuk menampilkan data dari tabel "tbl_barang"
                        $query_barang_selected = mysqli_query($mysqli, "SELECT id_barang, nama_barang FROM tbl_barang WHERE id_barang = '$part_number' ")
                          or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                        // ambil data hasil query
                        $data_barang_selected = mysqli_fetch_assoc($query_barang_selected) ?>
                        <option selected disabled value="<?php $data_barang_selected['id_barang'] ?>"><?php echo $data_barang_selected['id_barang'] ?> - <?php echo $data_barang_selected['nama_barang'] ?></option>
                        <?php
                        // sql statement untuk menampilkan data dari tabel "tbl_barang"
                        $query_barang = mysqli_query($mysqli, "SELECT id_barang, nama_barang FROM tbl_barang WHERE id_barang = '$part_number' ")
                          or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                        // ambil data hasil query
                        while ($data_barang = mysqli_fetch_assoc($query_barang)) {
                          // tampilkan data
                          echo "<option value='$data_barang[id_barang]'>$data_barang[id_barang] - $data_barang[nama_barang]</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="invalid-feedback">Barang tidak boleh kosong.</div>
                  </div>
                <?php } ?>

                <div class="form-group">
                  <label>Stok <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                    </div>
                    <input type="text" id="data_stok" name="stok" class="form-control" readonly>
                    <div id="data_satuan" class="input-group-append"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-5 ml-auto">
                <div class="form-group">
                  <label>Jumlah Keluar <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                    </div>
                    <input type="text" id="jumlah" name="jumlah" class="form-control" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required placeholder="Jumlah Keluar">
                  </div>
                  <div class="invalid-feedback">Jumlah keluar tidak boleh kosong.</div>
                </div>

                <div class="form-group">
                  <label>Sisa Stok <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-archive"></i></span>
                    </div>
                    <input type="text" id="sisa" name="sisa" class="form-control" readonly>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="mx-2">
              <button type="button" class="btn btn-success btn-add-barang">+ Tambah</button>
            </div> -->
          </div>
          <div class="ml-2">
            <span class="badge badge-info"><i class="fa fa-info-circle"></i>Jika stok tidak muncul angka, silahkan pilih kembali barang</span>
          </div>

        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <button type="submit" name="simpan" class="btn btn-primary btn-round pl-4 pr-4 mr-2">
            <i class="fas fa-save"></i> Simpan
          </button>
          <!-- tombol kembali ke halaman data barang keluar -->
          <a href="?module=barang_keluar" class="btn btn-default btn-round pl-4 pr-4">
            <i class="fas fa-undo"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.js-example-basic-single').select2();
      // Menampilkan data barang dari select box ke textfield
      $('#data_barang').change(function() {
        // mengambil value dari "id_barang"
        var id_barang = $('#data_barang').val();

        $.ajax({
          type: "GET", // mengirim data dengan method GET
          url: "modules/barang-keluar/get_barang.php", // proses get data berdasarkan "id_barang"
          data: {
            id_barang: id_barang
          }, // data yang dikirim
          dataType: "JSON", // tipe data JSON
          success: function(result) { // ketika proses get data selesai
            // tampilkan data
            $('#data_stok').val(result.stok);
            $('#data_satuan').html('<span class="input-group-text">' + result.nama_satuan + '</span>');
            // set focus
            $('#jumlah').focus();
          }
        });
      });

      // menghitung sisa stok
      $('#jumlah').keyup(function() {
        // mengambil data dari form entri
        var stok = $('#data_stok').val();
        var jumlah = $('#jumlah').val();

        // mengecek input data
        // jika data barang belum diisi
        if (stok == "") {
          // tampilkan pesan info
          $('#pesan').html('<div class="alert alert-notify alert-info alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-info"></span><span data-notify="title" class="text-info">Info!</span> <span data-notify="message">Silahkan isi data barang terlebih dahulu.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input "jumlah"
          $('#jumlah').val('');
          // sisa stok kosong
          var sisa_stok = "";
        }
        // jika "jumlah" belum diisi
        else if (jumlah == "") {
          // sisa stok kosong
          var sisa_stok = "";
        }
        // jika "jumlah" diisi 0
        else if (jumlah == 0) {
          // tampilkan pesan peringatan
          $('#pesan').html('<div class="alert alert-notify alert-warning alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-exclamation"></span><span data-notify="title" class="text-warning">Peringatan!</span> <span data-notify="message">Jumlah keluar tidak boleh 0 (nol).</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input "jumlah"
          $('#jumlah').val('');
          // sisa stok kosong
          var sisa_stok = "";
        }
        // jika "jumlah" lebih dari "stok"
        else if (eval(jumlah) > eval(stok)) {
          // tampilkan pesan peringatan
          $('#pesan').html('<div class="alert alert-notify alert-warning alert-dismissible fade show" role="alert"><span data-notify="icon" class="fas fa-exclamation"></span><span data-notify="title" class="text-warning">Peringatan!</span> <span data-notify="message">Stok tidak memenuhi, kurangi jumlah keluar.</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          // reset input "jumlah"
          $('#jumlah').val('');
          // sisa stok kosong
          var sisa_stok = "";
        }
        // jika "jumlah" sudah diisi
        else {
          // hitung sisa stok
          var sisa_stok = eval(stok) - eval(jumlah);
        }

        // tampilkan sisa stok
        $('#sisa').val(sisa_stok);
      });
      $('#sisa').keyup(function() {
        var sisa = $('#sisa').val();

      })
    });
  </script>

  <script>
    $(document).ready(function() {
      // Tambah barang
      $(document).on('click', '.btn-add-barang', function() {
        let newRow = `
        <div class="card py-3">
            <div class="row" id="keluar-barang">
              <div class="col-md-7">
                <div class="form-group">
                  <label>Barang <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-box"></i></span>
                    </div>
                    <select id="data_barang" name="barang" class="form-control chosen-select" autocomplete="off" required>
                      <option selected disabled value="">-- Pilih --</option>
                      <?php
                      // sql statement untuk menampilkan data dari tabel "tbl_barang"
                      $query_barang = mysqli_query($mysqli, "SELECT id_barang, nama_barang FROM tbl_barang ORDER BY id_barang ASC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                      // ambil data hasil query
                      while ($data_barang = mysqli_fetch_assoc($query_barang)) {
                        // tampilkan data
                        echo "<option value='$data_barang[id_barang]'>$data_barang[id_barang] - $data_barang[nama_barang]</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="invalid-feedback">Barang tidak boleh kosong.</div>
                </div>

                <div class="form-group">
                  <label>Stok <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-cubes"></i></span>
                    </div>
                    <input type="text" id="data_stok" name="stok" class="form-control" readonly>
                    <div id="data_satuan" class="input-group-append"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-5 ml-auto">
                <div class="form-group">
                  <label>Jumlah Keluar <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-calculator"></i></span>
                    </div>
                    <input type="text" id="jumlah" name="jumlah" class="form-control" autocomplete="off" onKeyPress="return goodchars(event,'0123456789',this)" required placeholder="Jumlah Keluar">
                  </div>
                  <div class="invalid-feedback">Jumlah keluar tidak boleh kosong.</div>
                </div>

                <div class="form-group">
                  <label>Sisa Stok <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-archive"></i></span>
                    </div>
                    <input type="text" id="sisa" name="sisa" class="form-control" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="mx-2">
              <button type="button" class="btn btn-success btn-add-barang">+ Tambah</button>
            </div>
          </div>`;
        $('#keluar-barang').append(newRow);
        $(".select2").select2(); // Reinitialize Select2
      });

      // Hapus barang
      $(document).on('click', '.btn-remove-barang', function() {
        $(this).closest('.row').remove();
      });
    });
  </script>
<?php } ?>