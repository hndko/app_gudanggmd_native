<style>
  .increase-size {
    font-size: 0.8rem;
  }
</style>
<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // menampilkan pesan sesuai dengan proses yang dijalankan
  // jika pesan tersedia
  if (isset($_GET['pesan'])) {
    // jika pesan = 1
    if ($_GET['pesan'] == 1) {
      // tampilkan pesan sukses simpan data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data barang berhasil disimpan.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 2
    elseif ($_GET['pesan'] == 2) {
      // tampilkan pesan sukses ubah data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data barang berhasil diubah.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 3
    elseif ($_GET['pesan'] == 3) {
      // tampilkan pesan sukses hapus data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data barang berhasil dihapus.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 4
    elseif ($_GET['pesan'] == 4) {
      // tampilkan pesan gagal hapus data
      echo '<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-times"></span> 
              <span data-notify="title" class="text-danger">Gagal!</span> 
              <span data-notify="message">Data barang tidak bisa dihapus karena sudah tercatat pada Data Transaksi.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
  }
?>
  <div class="panel-header bg-primary-gradient">
    <div class="page-inner py-45">
      <div class="d-flex align-items-left align-items-md-top flex-column flex-md-row">
        <div class="page-header text-white">
          <!-- judul halaman -->
          <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> Data Barang</h4>
          <!-- breadcrumbs -->
          <ul class="breadcrumbs">
            <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="?module=barang" class="text-white">Barang</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Data</a></li>
          </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <!-- tombol entri data -->
          <a href="?module=form_entri_barang" class="btn btn-primary btn-round">
            <span class="btn-label"><i class="fa fa-plus mr-2"></i></span> Masukkan Data Barang
          </a>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5" id="table-show-pending">
    <div class="card">
      <div class="card-header">
        <!-- judul tabel -->
        <div class="card-title">Data Barang Gudang GMD/BMD</div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- tabel untuk menampilkan data dari database -->
          <table id="basic-datatables-show-pending" class="display table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">ID Barang</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Total Stok</th>
                <th class="text-center">Stok Minimum</th>
                <th class="text-center">Lokasi Gudang</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // variabel untuk nomor urut tabel
              $no = 1;
              // sql statement untuk menampilkan data dari tabel "tbl_barang" dan tabel "tbl_satuan"
              $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.stok, a.satuan, b.nama_satuan, c.lokasi_rak, a.stok_minimum, a.barang_pending, d.nama_jenis
                                              FROM tbl_barang as a INNER JOIN tbl_satuan as b INNER JOIN tbl_lokasi_rak as c INNER JOIN tbl_jenis as d
                                              ON a.satuan=b.id_satuan AND a.lokasi_rak=c.id_lokasi_rak AND a.jenis=d.id_jenis
                                              -- INNER JOIN tbl_lokasi_rak as c ON a.lokasi_rak=c.id_lokasi_rak
                                              ORDER BY a.id_barang ASC")
                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
              // ambil data hasil query
              while ($data = mysqli_fetch_assoc($query)) { ?>
                <!-- tampilkan data -->
                <tr>
                  <td width="50" class="text-center"><?php echo $no++; ?></td>
                  <td width="100" class="text-center"><?php echo $data['id_barang']; ?></td>
                  <td width="100"class="text-center"><?php echo $data['nama_barang']; ?></td>
                  <td width="100"class="text-center"><?php echo $data['nama_jenis']; ?></td>
                  <td width="80" class=" text-center"><?php if ($data['stok'] <= $data['stok_minimum']) {
                                                      ?><h4 class="badge badge-pill badge-danger increase-size"><?php echo number_format($data['stok'],2); ?> <?php echo $data['nama_satuan']; ?></h4><?php
                                                                                                                                                                                                              } else {
                                                                                                                                                                                                                ?><h4 class="badge badge-success increase-size"><?php echo number_format($data['stok'], 2); ?> <?php echo $data['nama_satuan']; ?></h4><?php
                                                                                                                                                                                                                                                                                                                                                              } ?></td>
                  
                  <td width="100" class="text-center"><?php echo number_format($data['stok_minimum'], 0, '', '.'); ?> <?php echo $data['nama_satuan']; ?></td>
                  <td width="100"class="text-center"><?php echo $data['lokasi_rak']; ?></td>
                  <td width="100" class="text-center">
                    <?php
                    if ($_SESSION['hak_akses'] != 'Admin Gudang' && $_SESSION['hak_akses'] != 'Marketing') { ?>
                      <div>
                        <!-- tombol detail data -->
                        <a href="?module=tampil_detail_barang&id=<?php echo $data['id_barang']; ?>" class="btn btn-icon btn-round btn-primary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Detail">
                          <i class="fas fa-clone fa-sm"></i>
                        </a>
                        <!-- tombol ubah data -->
                        <a href="?module=form_ubah_barang&id=<?php echo $data['id_barang']; ?>" class="btn btn-icon btn-round btn-secondary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Ubah">
                          <i class="fas fa-pencil-alt fa-sm"></i>
                        </a>
                        <!-- tombol hapus data -->
                        <a href="modules/barang/proses_hapus.php?id=<?php echo $data['id_barang']; ?>" onclick="return confirm('Anda yakin ingin menghapus data barang <?php echo $data['nama_barang']; ?>?')" class="btn btn-icon btn-round btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus">
                          <i class="fas fa-trash fa-sm"></i>
                        </a>
                      </div>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5" id="table-hide-pending" style="display: none;">
    <div class="card">
      <div class="card-header">
        <!-- judul tabel -->
        <div class="card-title">Data Barang</div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- tabel untuk menampilkan data dari database -->
          <table id="basic-datatables-hide-pending" class="display table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">ID Barang</th>
                <th class="text-center">Nama Barang</th>
                <th class="text-center">Kategori barang</th>
                <th class="text-center">Stok Gudang</th>
                <th class="text-center">Lokasi Gudang</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // variabel untuk nomor urut tabel
              $no = 1;
              // sql statement untuk menampilkan data dari tabel "tbl_barang" dan tabel "tbl_satuan"
              $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.stok, a.satuan, b.nama_satuan, c.lokasi_rak, a.stok_minimum, a.barang_pending, d.nama_jenis
                                              FROM tbl_barang as a INNER JOIN tbl_satuan as b INNER JOIN tbl_lokasi_rak as c INNER JOIN tbl_jenis as d
                                              ON a.satuan=b.id_satuan AND a.lokasi_rak=c.id_lokasi_rak AND a.jenis=d.id_jenis
                                              -- INNER JOIN tbl_lokasi_rak as c ON a.lokasi_rak=c.id_lokasi_rak
                                              ORDER BY a.id_barang ASC")
                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
              // ambil data hasil query
              while ($data = mysqli_fetch_assoc($query)) { ?>
                <!-- tampilkan data -->
                <tr>
                  <td width="30" class="text-center"><?php echo $no++; ?></td>
                  <td width="100" class="text-center"><?php echo $data['id_barang']; ?></td>
                  <td width="220"class="text-center"><?php echo $data['nama_barang']; ?></td>
                  <td width="100"class="text-center"><?php echo $data['nama_jenis']; ?></td>
                  <td width="80" class=" text-center"><?php if ($data['stok'] <= $data['stok_minimum']) {
                                                      ?><h4 class="badge badge-pill badge-danger increase-size"><?php echo number_format($data['stok'], 0, '', '.'); ?> <?php echo $data['nama_satuan']; ?></h4><?php
                                                                                                                                                                                                              } else {
                                                                                                                                                                                                                ?><h4 class="badge badge-success increase-size"><?php echo number_format($data['stok'], 0, '', '.'); ?> <?php echo $data['nama_satuan']; ?></h4><?php
                                                                                                                                                                                                                                                                                                                                                              } ?></td>
                  <td width="100"class="text-center"><?php echo $data['lokasi_rak']; ?></td>
                  <td width="100" class="text-center">
                    <?php
                    if ($_SESSION['hak_akses'] != 'Admin Gudang' && $_SESSION['hak_akses'] != 'Marketing') { ?>
                      <div>
                        <!-- tombol detail data -->
                        <a href="?module=tampil_detail_barang&id=<?php echo $data['id_barang']; ?>" class="btn btn-icon btn-round btn-primary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Detail">
                          <i class="fas fa-clone fa-sm"></i>
                        </a>
                        <!-- tombol ubah data -->
                        <a href="?module=form_ubah_barang&id=<?php echo $data['id_barang']; ?>" class="btn btn-icon btn-round btn-secondary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Ubah">
                          <i class="fas fa-pencil-alt fa-sm"></i>
                        </a>
                        <!-- tombol hapus data -->
                        <a href="modules/barang/proses_hapus.php?id=<?php echo $data['id_barang']; ?>" onclick="return confirm('Anda yakin ingin menghapus data barang <?php echo $data['nama_barang']; ?>?')" class="btn btn-icon btn-round btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus">
                          <i class="fas fa-trash fa-sm"></i>
                        </a>
                      </div>
                    <?php } ?>
                  </td>
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
    // hide stok pending
    $(document).on('click', '.btn-hide-pending', function() {
      document.getElementById("btn-hide-pending").style.display = "none";
      document.getElementById("btn-show-pending").style.display = "inline";
      document.getElementById("table-show-pending").style.display = "none";
      document.getElementById("table-hide-pending").style.display = "inline";
    });
    // show stok pending
    $(document).on('click', '.btn-show-pending', function() {
      document.getElementById("btn-hide-pending").style.display = "inline";
      document.getElementById("btn-show-pending").style.display = "none";
      document.getElementById("table-show-pending").style.display = "inline";
      document.getElementById("table-hide-pending").style.display = "none";
    });

  });

  
</script>