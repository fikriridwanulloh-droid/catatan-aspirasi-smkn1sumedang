-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Okt 2026 pada 04.43
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'admin123', '2026-10-26 02:28:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspirasi_guru`
--

CREATE TABLE `aspirasi_guru` (
  `id` int(11) NOT NULL,
  `kode_tiket` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `mapel` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `is_rahasia` tinyint(1) DEFAULT 0,
  `kode_rahasia` varchar(50) DEFAULT NULL,
  `alasan_rahasia` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Proses','Selesai','Ditolak') DEFAULT 'Proses',
  `tanggapan` text DEFAULT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aspirasi_guru`
--

INSERT INTO `aspirasi_guru` (`id`, `kode_tiket`, `nama`, `mapel`, `kategori`, `keterangan`, `is_rahasia`, `kode_rahasia`, `alasan_rahasia`, `foto`, `status`, `tanggapan`, `tanggal`) VALUES
(2, 'ASP-63AC5', 'f', 'f', 'Lainnya', 'f', 0, '', '', '', 'Proses', NULL, '2026-10-26 04:13:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspirasi_masyarakat`
--

CREATE TABLE `aspirasi_masyarakat` (
  `id` int(11) NOT NULL,
  `kode_tiket` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `kontak` varchar(100) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `is_rahasia` tinyint(1) DEFAULT 0,
  `kode_rahasia` varchar(50) DEFAULT NULL,
  `alasan_rahasia` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Proses','Selesai','Ditolak') DEFAULT 'Proses',
  `tanggapan` text DEFAULT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aspirasi_masyarakat`
--

INSERT INTO `aspirasi_masyarakat` (`id`, `kode_tiket`, `nama`, `kontak`, `kategori`, `keterangan`, `is_rahasia`, `kode_rahasia`, `alasan_rahasia`, `foto`, `status`, `tanggapan`, `tanggal`) VALUES
(2, 'ASP-F4309', 'f', 'f', 'Lainnya', 'f', 0, '', '', '', 'Proses', NULL, '2026-10-26 04:13:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspirasi_murid`
--

CREATE TABLE `aspirasi_murid` (
  `id` int(11) NOT NULL,
  `kode_tiket` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `is_rahasia` tinyint(1) DEFAULT 0,
  `kode_rahasia` varchar(50) DEFAULT NULL,
  `alasan_rahasia` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Proses','Selesai','Ditolak') DEFAULT 'Proses',
  `tanggapan` text DEFAULT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aspirasi_murid`
--

INSERT INTO `aspirasi_murid` (`id`, `kode_tiket`, `nama`, `kelas`, `jurusan`, `kategori`, `keterangan`, `is_rahasia`, `kode_rahasia`, `alasan_rahasia`, `foto`, `status`, `tanggapan`, `tanggal`) VALUES
(4, 'ASP-7012E', 'f', 'X', 'RPL', 'Lainnya', 'f', 1, '#RHS-48FE7B', 'f', '1792984390_6adec54694730.png', 'Selesai', 'f', '2026-10-26 04:13:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspirasi_ortu`
--

CREATE TABLE `aspirasi_ortu` (
  `id` int(11) NOT NULL,
  `kode_tiket` varchar(20) DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `kelas_siswa` varchar(20) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `is_rahasia` tinyint(1) DEFAULT 0,
  `kode_rahasia` varchar(50) DEFAULT NULL,
  `alasan_rahasia` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('Proses','Selesai','Ditolak') DEFAULT 'Proses',
  `tanggapan` text DEFAULT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `aspirasi_ortu`
--

INSERT INTO `aspirasi_ortu` (`id`, `kode_tiket`, `nama`, `nama_siswa`, `kelas_siswa`, `kategori`, `keterangan`, `is_rahasia`, `kode_rahasia`, `alasan_rahasia`, `foto`, `status`, `tanggapan`, `tanggal`) VALUES
(2, 'ASP-0717C', 'f', 'f', 'X', 'Lainnya', 'f', 0, '', '', '', 'Proses', NULL, '2026-10-26 04:13:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', 'admin123', 'Administrator SMKN 1 Sumedang');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aspirasi_guru`
--
ALTER TABLE `aspirasi_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aspirasi_masyarakat`
--
ALTER TABLE `aspirasi_masyarakat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aspirasi_murid`
--
ALTER TABLE `aspirasi_murid`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `aspirasi_ortu`
--
ALTER TABLE `aspirasi_ortu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `aspirasi_guru`
--
ALTER TABLE `aspirasi_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `aspirasi_masyarakat`
--
ALTER TABLE `aspirasi_masyarakat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `aspirasi_murid`
--
ALTER TABLE `aspirasi_murid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `aspirasi_ortu`
--
ALTER TABLE `aspirasi_ortu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
