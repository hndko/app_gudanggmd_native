<?php
// Function to load .env file
function loadEnv($path)
{
  if (!file_exists($path)) {
    return;
  }

  $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) {
      continue;
    }

    list($name, $value) = explode('=', $line, 2);
    $name = trim($name);
    $value = trim($value);

    if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
      putenv(sprintf('%s=%s', $name, $value));
      $_ENV[$name] = $value;
      $_SERVER[$name] = $value;
    }
  }
}

// Load .env from root directory (assuming config/database.php is 1 level deep/referenced from root,
// BUT this file is usually included. Let's make sure we find the .env relative to THIS file)
// config/database.php -> ../.env
loadEnv(__DIR__ . '/../.env');

// deklarasi parameter koneksi database
$host     = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USERNAME') ?: "root";
$password = getenv('DB_PASSWORD') ?: "";
$database = getenv('DB_DATABASE') ?: "gudang";

// buat koneksi database
$mysqli = mysqli_connect($host, $username, $password, $database);

// cek koneksi
// jika koneksi gagal
if (!$mysqli) {
  // tampilkan pesan gagal koneksi
  die('Koneksi Database Gagal : ' . mysqli_connect_error());
}
