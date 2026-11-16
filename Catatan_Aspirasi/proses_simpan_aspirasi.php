<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_POST['submit'])) {
    $role           = $_POST['role'] ?? 'murid';
    $nama           = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $kategori       = mysqli_real_escape_string($koneksi, trim($_POST['kategori']));
    $keterangan     = mysqli_real_escape_string($koneksi, trim($_POST['keterangan']));
    $is_rahasia     = isset($_POST['is_rahasia']) ? 1 : 0;
    $alasan_rahasia = $is_rahasia ? mysqli_real_escape_string($koneksi, trim($_POST['alasan_rahasia'])) : '';
    $kode_rahasia   = $is_rahasia ? '#RHS-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 6)) : '';
    
    // Generate Kode Tiket Unik untuk Pelacakan (Contoh: ASP-8F29A)
    $kode_tiket     = 'ASP-' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 5));
    $tanggal        = date('Y-m-d H:i:s');

    // Handling File Upload
    $foto_name = "";
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array(strtolower($ext), $allowed)) {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }
            $foto_name = time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $foto_name);
        }
    }

// Inisialisasi awal variabel query agar tidak undefined
    $query = "";

    // Insert Query berdasarkan Role
    if ($role == 'murid') {
        $kelas   = mysqli_real_escape_string($koneksi, trim($_POST['kelas']));
        $jurusan = mysqli_real_escape_string($koneksi, trim($_POST['jurusan']));

        $query = "INSERT INTO aspirasi_murid (kode_tiket, nama, kelas, jurusan, kategori, keterangan, is_rahasia, kode_rahasia, alasan_rahasia, foto, status, tanggal) 
                  VALUES ('$kode_tiket', '$nama', '$kelas', '$jurusan', '$kategori', '$keterangan', $is_rahasia, '$kode_rahasia', '$alasan_rahasia', '$foto_name', 'Proses', '$tanggal')";
    } 
    elseif ($role == 'guru') {
        $mapel = mysqli_real_escape_string($koneksi, trim($_POST['mapel']));

        $query = "INSERT INTO aspirasi_guru (kode_tiket, nama, mapel, kategori, keterangan, is_rahasia, kode_rahasia, alasan_rahasia, foto, status, tanggal) 
                  VALUES ('$kode_tiket', '$nama', '$mapel', '$kategori', '$keterangan', $is_rahasia, '$kode_rahasia', '$alasan_rahasia', '$foto_name', 'Proses', '$tanggal')";
    } 
    elseif ($role == 'ortu') {
        $nama_siswa  = mysqli_real_escape_string($koneksi, trim($_POST['nama_siswa']));
        $kelas_siswa = mysqli_real_escape_string($koneksi, trim($_POST['kelas_siswa']));

        $query = "INSERT INTO aspirasi_ortu (kode_tiket, nama, nama_siswa, kelas_siswa, kategori, keterangan, is_rahasia, kode_rahasia, alasan_rahasia, foto, status, tanggal) 
                  VALUES ('$kode_tiket', '$nama', '$nama_siswa', '$kelas_siswa', '$kategori', '$keterangan', $is_rahasia, '$kode_rahasia', '$alasan_rahasia', '$foto_name', 'Proses', '$tanggal')";
    } 
    elseif ($role == 'masyarakat') {
        $kontak = mysqli_real_escape_string($koneksi, trim($_POST['kontak']));

        $query = "INSERT INTO aspirasi_masyarakat (kode_tiket, nama, kontak, kategori, keterangan, is_rahasia, kode_rahasia, alasan_rahasia, foto, status, tanggal) 
                  VALUES ('$kode_tiket', '$nama', '$kontak', '$kategori', '$keterangan', $is_rahasia, '$kode_rahasia', '$alasan_rahasia', '$foto_name', 'Proses', '$tanggal')";
    }

    // Pastikan query tidak kosong sebelum dijalankan
    if (!empty($query)) {
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['pesan'] = "Aspirasi berhasil dikirim! Kode Tiket Anda: " . $kode_tiket;
            $_SESSION['tipe_pesan'] = "success";
        } else {
            $_SESSION['pesan'] = "Gagal mengirim aspirasi: " . mysqli_error($koneksi);
            $_SESSION['tipe_pesan'] = "danger";
        }
    } else {
        $_SESSION['pesan'] = "Role pengirim tidak valid!";
        $_SESSION['tipe_pesan'] = "danger";
    }

    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>