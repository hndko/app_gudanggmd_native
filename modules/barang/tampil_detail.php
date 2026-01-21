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
    // ambil data GET dari tombol detail
    $id_barang = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan" berdasarkan "id_barang"
    $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, a.foto, a.lokasi_rak, b.nama_jenis, c.nama_satuan, a.barang_pending, d.lokasi_rak
                                    FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c INNER JOIN tbl_lokasi_rak as d
                                    ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan AND a.lokasi_rak=d.id_lokasi_rak
                                    WHERE a.id_barang='$id_barang'")
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
  }
  $barangdetail = $data['id_barang'];
?>
  <div class="panel-header bg-primary-gradient">
    <div class="page-inner py-45">
      <div class="d-flex align-items-left align-items-md-top flex-column flex-md-row">
        <div class="page-header text-white">
          <!-- judul halaman -->
          <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> Barang</h4>
          <!-- breadcrumbs -->
          <?php
          if ($_SESSION['hak_akses'] != 'Admin Gudang' && $_SESSION['hak_akses'] != 'Marketing') { ?>
            <ul class="breadcrumbs">
              <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
              <li class="separator"><i class="flaticon-right-arrow"></i></li>
              <li class="nav-item"><a href="?module=barang" class="text-white">Barang</a></li>
              <li class="separator"><i class="flaticon-right-arrow"></i></li>
              <li class="nav-item"><a>Detail</a></li>
            </ul>
          <?php } ?>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <!-- tombol kembali ke halaman data barang -->
          <!-- <a href="?module=barang" class="btn btn-secondary btn-round">
            <span class="btn-label"><i class="far fa-arrow-alt-circle-left mr-1"></i></span> Kembali
          </a> -->
          <?php if ($_SESSION['hak_akses'] != 'Marketing') {
          ?>

            <a href="?module=form_entri_barang_masuk&id=<?php echo $data['id_barang'];?>" class="btn btn-success btn-round">
              <span class="btn-label"><i class="fas fa-plus-circle mr-1"></i></span> Barang Masuk
            </a>

            <a href="?module=form_entri_barang_keluar&id=<?php echo $data['id_barang'];?>" class="btn btn-danger btn-round">
              <span class="btn-label"><i class="fas fa-minus-circle mr-1"></i></span> Barang Keluar
            </a>
          <?php
          }
          ?>

        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <!-- judul form -->
            <div class="card-title">Detail Data Barang</div>
          </div>
          <!-- detail data -->
          <div class="card-body">
            <table class="table table-striped">
              <tr>
                <td width="120">Id Barang</td>
                <td width="10">:</td>
                <td><?php echo $data['id_barang']; ?></td>
              </tr>
              <tr>
                <td>Nama Barang</td>
                <td>:</td>
                <td><?php echo $data['nama_barang']; ?></td>
              </tr>
              <tr>
                <td>Jenis Barang</td>
                <td>:</td>
                <td><?php echo $data['nama_jenis']; ?></td>
              </tr>
              <tr>
                <td>Stok Minimum</td>
                <td>:</td>
                <td><?php echo $data['stok_minimum']; ?> <?php echo $data['nama_satuan']; ?></td>
              </tr>
              <tr>
                <td>Stok Gudang</td>
                <td>:</td>
                <td><?php echo number_format($data['stok'], 0, '', '.'); ?> <?php echo $data['nama_satuan']; ?></td>
              </tr>
              <tr>
                <td>Lokasi Gudang</td>
                <td>:</td>
                <td><?php echo $data['lokasi_rak']; ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <?php
            // mengecek data foto barang
            // jika data "foto" tidak ada di database
            if (is_null($data['foto'])) { ?>
              <!-- tampilkan foto default -->
              <img style="max-height:375px" src="uploads/no_image.png" class="img-fluid" alt="Foto Barang">
            <?php
            }
            // jika data "foto" ada di database
            else { ?>
              <!-- tampilkan foto barang dari database -->
              <img style="max-height:375px" src="uploads/<?php echo $data['foto']; ?>" class="img-fluid" alt="Foto Barang">
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header row">
        <!-- judul tabel -->
        <div class="col-9 card-title my-auto">Data Detail Barang Masuk Keluar</div>
        <div class="col-3 pl-0">
          <div class="form-group">
            <?php
            $id_barang = $data['id_barang']; 
            if(isset($id)){$id  = $_POST[$id_barang];}
            ?>
            <!-- tombol export laporan -->
            <a href="modules/barang/export.php?id=<?php echo $id_barang; ?>" target="_blank" class="btn btn-success btn-round btn-block">
              <span class="btn-label"><i class="fa fa-file-excel mr-2"></i></span> Export
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- tabel untuk menampilkan data dari database -->
          <table id="basic-datatables-masuk-keluar" class="display table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">ID Barang</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Jumlah Masuk</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Status</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Input</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // variabel untuk nomor urut tabel
              $no = 1;
              // sql statement untuk menampilkan data dari tabel "tbl_barang_masuk", tabel "tbl_barang", dan tabel "tbl_satuan"
              $query = mysqli_query($mysqli, "SELECT a.id_transaksi, a.tanggal, a.barang, a.jumlah, b.nama_barang, c.nama_satuan, a.keterangan, a.inputby, a.status
                                              FROM tbl_barang_masuk_keluar as a INNER JOIN tbl_barang as b INNER JOIN tbl_satuan as c
                                              ON a.barang=b.id_barang AND b.satuan=c.id_satuan 
                                              WHERE b.id_barang = '$barangdetail'
                                              ORDER BY a.tanggal DESC")
                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
              // ambil data hasil query
              while ($data = mysqli_fetch_assoc($query)) { ?>
                <!-- tampilkan data -->
                <tr>
                  <td width="30" class="text-center"><?php echo $no++; ?></td>
                  <td width="90" class="text-center"><?php echo $data['id_transaksi']; ?></td>
                  <td width="100" class="text-center"><?php echo date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                  <td width="100"><?php echo $data['barang']; ?></td>
                  <td width="100"><?php echo $data['nama_barang']; ?></td>
                  <td width="100" class="text-right"><?php echo number_format($data['jumlah'], 0, '', '.'); ?></td>
                  <td width="60"><?php echo $data['nama_satuan']; ?></td>
                  <td width="60"><?php echo $data['status']; ?></td>
                  <td width="100"><?php echo $data['keterangan']; ?></td>
                  <td width="100"><?php echo $data['inputby']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul tabel -->
        <div class="card-title">Data Detail Barang Pending</div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- tabel untuk menampilkan data dari database -->
          <table id="basic-datatables-pending" class="display table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">ID Transaksi</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Part Number</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Jumlah Masuk</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // variabel untuk nomor urut tabel
              $no = 1;
              // sql statement untuk menampilkan data dari tabel "tbl_barang_masuk", tabel "tbl_barang", dan tabel "tbl_satuan"
              $query = mysqli_query($mysqli, "SELECT a.id_transaksi, a.tanggal, a.barang, a.jumlah, b.nama_barang, c.nama_satuan, a.keterangan
                                              FROM tbl_barang_pending as a INNER JOIN tbl_barang as b INNER JOIN tbl_satuan as c
                                              ON a.barang=b.id_barang AND b.satuan=c.id_satuan 
                                              WHERE b.id_barang = '$barangdetail'
                                              ORDER BY a.tanggal DESC")
                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
              // ambil data hasil query
              while ($data = mysqli_fetch_assoc($query)) { ?>
                <!-- tampilkan data -->
                <tr>
                  <td width="50" class="text-center"><?php echo $no++; ?></td>
                  <td width="90" class="text-center"><?php echo $data['id_transaksi']; ?></td>
                  <td width="100" class="text-center"><?php echo date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                  <td width="100"><?php echo $data['barang']; ?></td>
                  <td width="100"><?php echo $data['nama_barang']; ?></td>
                  <td width="100" class="text-right"><?php echo number_format($data['jumlah'], 0, '', '.'); ?></td>
                  <td width="60"><?php echo $data['nama_satuan']; ?></td>
                  <td width="100"><?php echo $data['keterangan']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

<script>
  $(document).ready(function() {

  });
</script>