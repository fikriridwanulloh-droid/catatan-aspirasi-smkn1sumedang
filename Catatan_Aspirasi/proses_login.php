<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, trim($_POST['username']));
    $password = trim($_POST['password']);

    // Pastikan tabel admin ada
    mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS admin (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Cari admin berdasarkan username
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$username' LIMIT 1");
    
    if ($query && mysqli_num_rows($query) > 0) {
        $admin = mysqli_fetch_assoc($query);
        $db_password = $admin['password'];

        // Cek apakah password cocok (Mendukung password ter-hash ATAU teks biasa/plain text)
        $is_match = false;
        
        // Cek jika password di DB berupa hash (biasanya diawali $2y$)
        if (password_get_info($db_password)['algo'] !== 0) {
            if (password_verify($password, $db_password)) {
                $is_match = true;
            }
        } 
        
        // Cek pencocokan langsung (jika password di DB tersimpan sebagai teks biasa/plain text)
        if ($password === $db_password) {
            $is_match = true;
        }

        if ($is_match) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username']  = $admin['username'];
            
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_login'] = "Password yang Anda masukkan salah!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error_login'] = "Username admin tidak ditemukan!";
            header("Location: login.php");
            exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>