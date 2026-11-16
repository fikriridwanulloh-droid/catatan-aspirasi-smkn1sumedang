<?php
// Konfigurasi Database untuk XAMPP Lokal
$host = "localhost";
$user = "root";       // Default XAMPP adalah 'root'
$pass = "";           // Default XAMPP passwordnya kosong
$db   = "sekolah_db"; // Sesuaikan dengan nama database di phpMyAdmin lokal kamu

// Membuat Koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek Koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set Charset UTF-8
mysqli_set_charset($koneksi, "utf8mb4");
?>