<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  header('location: 404.html');
  exit;
}

// Data Menu Structure
$menus = [
  [
    'title' => 'Dashboard',
    'icon' => 'fas fa-home',
    'link' => '?module=dashboard',
    'modules' => ['dashboard'],
    'access' => ['Administrator', 'Admin Gudang', 'Kepala Gudang', 'Marketing']
  ],
  [
    'title' => 'Peminjaman Alat',
    'icon' => 'fa fa-tasks',
    'link' => '?module=peminjaman-alat',
    'modules' => ['peminjaman-alat'],
    'access' => ['Administrator']
  ],
  [
    'title' => 'Scan Barcode',
    'icon' => 'fa fa-qrcode',
    'link' => '?module=scan_barcode',
    'modules' => ['scan_barcode'],
    'access' => ['Administrator', 'Admin Gudang', 'Kepala Gudang', 'Marketing']
  ],
  [
    'header' => 'Master',
    'access' => ['Administrator', 'Kepala Gudang']
  ],
  [
    'title' => 'Barang',
    'icon' => 'fas fa-clone',
    'link' => '#barang',
    'modules' => ['barang', 'tampil_detail_barang', 'form_entri_barang', 'form_ubah_barang', 'jenis', 'form_entri_jenis', 'form_ubah_jenis', 'satuan', 'form_entri_satuan', 'form_ubah_satuan', 'lokasi_rak'],
    'access' => ['Administrator', 'Kepala Gudang'],
    'submenu' => [
      [
        'title' => 'Data Barang',
        'link' => '?module=barang',
        'modules' => ['barang', 'tampil_detail_barang', 'form_entri_barang', 'form_ubah_barang']
      ],
      [
        'title' => 'Kategori Barang',
        'link' => '?module=jenis',
        'modules' => ['jenis', 'form_entri_jenis', 'form_ubah_jenis']
      ],
      [
        'title' => 'Satuan',
        'link' => '?module=satuan',
        'modules' => ['satuan', 'form_entri_satuan', 'form_ubah_satuan']
      ],
      [
        'title' => 'Lokasi Gudang',
        'link' => '?module=lokasi_rak',
        'modules' => ['lokasi_rak']
      ]
    ]
  ],
  [
    'header' => 'Transaksi',
    'access' => ['Administrator', 'Admin Gudang', 'Kepala Gudang']
  ],
  [
    'title' => 'Barang Masuk',
    'icon' => 'fas fa-sign-in-alt',
    'link' => '?module=barang_masuk',
    'modules' => ['barang_masuk', 'form_entri_barang_masuk'],
    'access' => ['Administrator', 'Admin Gudang', 'Kepala Gudang']
  ],
  [
    'title' => 'Barang Keluar',
    'icon' => 'fas fa-sign-out-alt',
    'link' => '?module=barang_keluar',
    'modules' => ['barang_keluar', 'form_entri_barang_keluar'],
    'access' => ['Administrator', 'Admin Gudang', 'Kepala Gudang']
  ],
  [
    'title' => 'Barang Pending',
    'icon' => 'fas fa-pause',
    'link' => '?module=barang_pending',
    'modules' => ['barang_pending', 'form_entri_barang_pending'],
    'access' => ['Administrator']
  ],
  [
    'header' => 'Laporan',
    'access' => ['Administrator', 'Admin Gudang', 'Kepala Gudang', 'Marketing']
  ],
  [
    'title' => 'Laporan Stok',
    'icon' => 'fas fa-file-signature',
    'link' => '?module=laporan_stok',
    'modules' => ['laporan_stok'],
    'access' => ['Administrator', 'Admin Gudang', 'Kepala Gudang', 'Marketing']
  ],
  [
    'title' => 'Laporan Barang Masuk',
    'icon' => 'fas fa-file-import',
    'link' => '?module=laporan_barang_masuk',
    'modules' => ['laporan_barang_masuk'],
    'access' => ['Administrator', 'Admin Gudang', 'Kepala Gudang']
  ],
  [
    'title' => 'Laporan Barang Keluar',
    'icon' => 'fas fa-file-export',
    'link' => '?module=laporan_barang_keluar',
    'modules' => ['laporan_barang_keluar'],
    'access' => ['Administrator', 'Admin Gudang', 'Kepala Gudang']
  ],
  [
    'title' => 'Laporan Barang Pending',
    'icon' => 'fas fa-file',
    'link' => '?module=laporan_barang_pending',
    'modules' => ['laporan_barang_pending'],
    'access' => ['Administrator']
  ],
  [
    'header' => 'Pengaturan',
    'access' => ['Administrator']
  ],
  [
    'title' => 'Manajemen User',
    'icon' => 'fas fa-user',
    'link' => '?module=user',
    'modules' => ['user', 'form_entri_user', 'form_ubah_user'],
    'access' => ['Administrator']
  ]
];

// Helper function to check if menu is active
function isMenuActive($menuModules)
{
  if (isset($_GET['module']) && in_array($_GET['module'], $menuModules)) {
    return 'active';
  }
  return '';
}

// Render Menu
foreach ($menus as $menu) {
  // Check user access
  if (isset($menu['access']) && !in_array($_SESSION['hak_akses'], $menu['access'])) {
    continue;
  }

  // Render Section Header
  if (isset($menu['header'])) {
    echo '<li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">' . $menu['header'] . '</h4>
              </li>';
    continue;
  }

  // Determine active state
  $activeClass = isMenuActive($menu['modules']);

  // Check for submenu
  if (isset($menu['submenu'])) {
    // Maintain 'submenu' class for items with dropdowns, add active if child is active
    $submenuClass = ($activeClass === 'active') ? 'active submenu' : 'submenu';
    // Logic for collapse state
    $collapseClass = ($activeClass === 'active') ? 'show' : '';
    // Use unique ID for collapse based on logic or a slug
    $collapseId = strtolower(str_replace(' ', '', $menu['title']));

    echo '<li class="nav-item ' . $submenuClass . '">';
    echo '<a data-toggle="collapse" href="#' . $collapseId . '">';
    echo '<i class="' . $menu['icon'] . '"></i>';
    echo '<p>' . $menu['title'] . '</p>';
    echo '<span class="caret"></span>';
    echo '</a>';

    echo '<div class="collapse ' . $collapseClass . '" id="' . $collapseId . '">';
    echo '<ul class="nav nav-collapse">';

    foreach ($menu['submenu'] as $submenu) {
      $subActiveClass = isMenuActive($submenu['modules']);
      echo '<li class="' . $subActiveClass . '">';
      echo '<a href="' . $submenu['link'] . '">';
      echo '<span class="sub-item">' . $submenu['title'] . '</span>';
      echo '</a>';
      echo '</li>';
    }

    echo '</ul>';
    echo '</div>';
    echo '</li>';
  } else {
    // Regular menu item
    echo '<li class="nav-item ' . $activeClass . '">';
    echo '<a href="' . $menu['link'] . '">';
    echo '<i class="' . $menu['icon'] . '"></i>';
    echo '<p>' . $menu['title'] . '</p>';
    echo '</a>';
    echo '</li>';
  }
}
