<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$theme = $_SESSION['theme'] ?? 'light';
$lang  = $_SESSION['lang'] ?? 'id';

// Kamus Bahasa Navigasi / Taskbar
$nav_text = [
    'id' => [
        'brand'    => 'SMKN 1 Sumedang',
        'home'     => 'Beranda',
        'list'     => 'Daftar Aspirasi',
        'send'     => 'Kirim Aspirasi',
        'about'    => 'Tentang',
        'dashboard'=> 'Dashboard Admin',
        'logout'   => 'Keluar'
    ],
    'en' => [
        'brand'    => 'SMKN 1 Sumedang',
        'home'     => 'Home',
        'list'     => 'Aspiration List',
        'send'     => 'Submit Aspiration',
        'about'    => 'About',
        'dashboard'=> 'Admin Dashboard',
        'logout'   => 'Logout'
    ]
][$lang];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" data-bs-theme="<?= $theme ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $page_title ?? 'Portal Aspirasi SMKN 1 Sumedang' ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: <?= $theme == 'dark' ? '#0f172a' : '#f8fafc' ?>;
            color: <?= $theme == 'dark' ? '#f8fafc' : '#1e293b' ?>;
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
            overflow-x: hidden;
        }

        /* Taskbar Navbar Styling */
        .taskbar-navbar {
            background-color: <?= $theme == 'dark' ? 'rgba(30, 41, 59, 0.95)' : 'rgba(255, 255, 255, 0.95)' ?>;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
            transition: all 0.3s ease;
        }

        .taskbar-brand {
            font-weight: 800;
            font-size: 1.1rem;
            color: <?= $theme == 'dark' ? '#ffffff' : '#0f172a' ?> !important;
        }

        .nav-link-custom {
            font-weight: 600;
            font-size: 0.9rem;
            color: <?= $theme == 'dark' ? '#cbd5e1' : '#475569' ?>;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            transition: all 0.2s ease;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            color: #3b82f6;
            background-color: <?= $theme == 'dark' ? '#334155' : '#f1f5f9' ?>;
        }

        .btn-theme-toggle {
            background-color: <?= $theme == 'dark' ? '#334155' : '#f1f5f9' ?>;
            color: <?= $theme == 'dark' ? '#f59e0b' : '#334155' ?>;
            border: 1px solid <?= $theme == 'dark' ? '#475569' : '#cbd5e1' ?>;
        }

        .btn-theme-toggle:hover {
            background-color: <?= $theme == 'dark' ? '#475569' : '#e2e8f0' ?>;
        }
    </style>
</head>
<body class="d-flex flex-column">

    <!-- TASKBAR / NAVBAR UTAMA -->
    <nav class="navbar navbar-expand-lg taskbar-navbar sticky-top py-2.5">
        <div class="container">
            <!-- Brand / Logo dengan Spasi Jelas -->
            <a class="navbar-brand taskbar-brand d-flex align-items-center gap-3" href="index.php">
                <img src="LogoSmk1.jpg" alt="Logo SMKN 1 Sumedang" width="38" height="38" class="rounded-circle border border-2 border-primary me-1">
                <span><?= $nav_text['brand'] ?></span>
            </a>

            <!-- Toggle Mobile Menu -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#taskbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Taskbar -->
            <div class="collapse navbar-collapse" id="taskbarMenu">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1 text-center">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom <?= ($active_nav ?? '') == 'home' ? 'active' : '' ?>" href="index.php">
                            <i class="fas fa-home me-2"></i><?= $nav_text['home'] ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom <?= ($active_nav ?? '') == 'aspirasi' ? 'active' : '' ?>" href="aspirasi.php">
                            <i class="fas fa-paper-plane me-2"></i><?= $nav_text['send'] ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom <?= ($active_nav ?? '') == 'daftar' ? 'active' : '' ?>" href="daftar_pengaduan.php">
                            <i class="fas fa-list-alt me-2"></i><?= $nav_text['list'] ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom <?= ($active_nav ?? '') == 'about' ? 'active' : '' ?>" href="about.php">
                            <i class="fas fa-info-circle me-2"></i><?= $nav_text['about'] ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom <?= ($active_nav ?? '') == 'lacak' ? 'active' : '' ?>" href="lacak.php">
                            <i class="fas fa-search me-2"></i>Lacak Aspirasi
                        </a>
                    </li>
                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom text-primary <?= ($active_nav ?? '') == 'dashboard' ? 'active' : '' ?>" href="dashboard.php">
                                <i class="fas fa-chart-pie me-2"></i><?= $nav_text['dashboard'] ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Sisi Kanan: Kontrol Mode, Bahasa & Admin -->
                <div class="d-flex align-items-center justify-content-center gap-2 mt-3 mt-lg-0">
                    <a class="btn btn-theme-toggle btn-sm rounded-circle p-2" href="mode_terang_gelap.php" title="Ubah Mode Tampilan">
                        <i class="fas <?= $theme == 'dark' ? 'fa-sun text-warning' : 'fa-moon' ?> fa-fw"></i>
                    </a>

                    <a class="btn btn-theme-toggle btn-sm rounded-pill px-3 fw-bold" href="mode_inggris.php" title="Change Language">
                        <i class="fas fa-globe me-1"></i><?= strtoupper($lang) ?>
                    </a>

                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                        <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-semibold ms-1">
                            <i class="fas fa-sign-out-alt me-1"></i><?= $nav_text['logout'] ?>
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold ms-1 shadow-sm">
                            <i class="fas fa-user-shield me-1"></i> Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>