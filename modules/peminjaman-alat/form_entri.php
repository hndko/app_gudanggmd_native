<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { ?>
  <!-- menampilkan pesan kesalahan unggah file -->
  <div id="pesan"></div>

  <div class="panel-header bg-primary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> Peminjaman Alat</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=barang" class="text-white">Peminjaman</a></li>
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
        <div class="card-title">Isi Data Alat</div>
      </div>
      <!-- form entri data -->
      <form action="modules/peminjaman-alat/proses_entri.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>PIC <span class="text-danger">*yang bertanggung jawab dalam peminjaman alat</span></label>
                <!-- tampilkan "pic" -->
                <input type="text" name="pic" class="form-control">
              </div>
              <div class="form-group">
                <label>Nama Barang/alat <span class="text-danger">*</span></label>
                <input type="text" name="nama_barang" class="form-control" autocomplete="off" required>
                <div class="invalid-feedback">Nama barang tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Jumlah Peminjaman <span class="text-danger">*</span></label>
                <input type="number" name="jumlah_peminjaman" class="form-control" autocomplete="off" required>
              </div>

              <div class="form-group">
                <label>Tanggal Pinjam <span class="text-danger">*</span></label>
                <input type="datetime-local" name="tanggal_pinjam" class="form-control" autocomplete="off" required>
              </div>

              <div class="form-group">
                <label>Tanggal Kembali <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_kembali" class="form-control" autocomplete="off" required>
              </div>

              <div class="form-group">
                <label>Keterangan <span class="text-danger">*</span></label>
                <input type="text" name="keterangan" class="form-control" autocomplete="off" required>
              </div>
            </div>


            <div class="col-md-5 ml-auto">
              <div class="form-group">
                <label>Foto Barang <span class="text-danger">*tidak wajib diisi</span></label>
                <input type="file" id="foto" name="foto" class="form-control" autocomplete="off">
                <div class="card mt-3 mb-3">
                  <div class="card-body text-center">
                    <img style="max-height:200px" src="uploads/no_image.png" class="img-fluid foto-preview" name="gambar" alt="Foto Barang">
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
          <input type="submit" name="simpan_peminjaman" value="Simpan" class="btn btn-primary btn-round pl-4 pr-4 mr-2">
          <!-- tombol kembali ke halaman data barang -->
          <a href="?module=peminjaman_alat" class="btn btn-default btn-round pl-4 pr-4">Batal</a>
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

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('tanpa-rupiah');
    tanpa_rupiah.addEventListener('keyup', function(e) {
      tanpa_rupiah.value = formatRupiah(this.value);
    });

    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('dengan-rupiah');
    dengan_rupiah.addEventListener('keyup', function(e) {
      dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    /* Fungsi */
    function formatRupiah(angka, prefix) {
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
  </script>
<?php } ?>