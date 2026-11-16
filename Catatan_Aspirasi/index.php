<?php
session_start();
include 'koneksi.php';

$page_title = "Portal Aspirasi - SMKN 1 Sumedang";
$active_nav = "home";

// Include Taskbar Header Modular
include 'header.php';

$lang = $_SESSION['lang'] ?? 'id';

// Kamus Konten Multi-Bahasa
$text = [
    'id' => [
        'badge_official' => 'Sistem Pengaduan Resmi',
        'hero_title'     => 'Suarakan Aspirasi Anda untuk SMKN 1 Sumedang',
        'hero_desc'      => 'Wadah penyampaian saran, kritik, dan keluhan secara transparan, cepat, dan terintegrasi.',
        'btn_admin'      => 'Akses Admin',
        'choose_role'    => 'Pilih Peran Anda',
        'choose_desc'    => 'Silakan pilih kategori entitas Anda untuk mulai menyampaikan aspirasi',
        'role_murid'     => 'Siswa / Murid',
        'desc_murid'     => 'Aspirasi terkait fasilitas kelas, jurusan, & kegiatan siswa.',
        'role_guru'      => 'Guru & Staf',
        'desc_guru'      => 'Masukan seputar kurikulum, sarana pengajaran, & manajemen.',
        'role_ortu'      => 'Orang Tua / Wali',
        'desc_ortu'      => 'Saran dan masukan terkait perkembangan & layanan siswa.',
        'role_masyarakat' => 'Masyarakat Umum',
        'desc_masyarakat'=> 'Laporan umum atau masukan lingkungan dari publik.',
        'btn_send'       => 'Kirim Aspirasi'
    ],
    'en' => [
        'badge_official' => 'Official Reporting System',
        'hero_title'     => 'Voice Your Aspirations for SMKN 1 Sumedang',
        'hero_desc'      => 'A transparent, fast, and integrated platform for suggestions, feedback, and complaints.',
        'btn_admin'      => 'Admin Access',
        'choose_role'    => 'Choose Your Role',
        'choose_desc'    => 'Please select your entity category to start submitting your aspiration',
        'role_murid'     => 'Student',
        'desc_murid'     => 'Aspirations regarding class facilities, departments, & student activities.',
        'role_guru'      => 'Teacher & Staff',
        'desc_guru'      => 'Feedback on curriculum, teaching facilities, & management.',
        'role_ortu'      => 'Parents / Guardian',
        'desc_ortu'      => 'Suggestions related to student development & school services.',
        'role_masyarakat' => 'General Public',
        'desc_masyarakat'=> 'General reports or environmental feedback from the public.',
        'btn_send'       => 'Submit Aspiration'
    ]
][$lang];

$pesan = $_SESSION['pesan'] ?? '';
$tipe_pesan = $_SESSION['tipe_pesan'] ?? '';
unset($_SESSION['pesan'], $_SESSION['tipe_pesan']);
?>

<style>
    /* Styling Banner Hero */
    .hero-banner {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        box-shadow: 0 12px 24px -10px rgba(59, 130, 246, 0.4);
    }

    /* Styling Kartu Peran Modern */
    .role-card-home {
        background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
        border-radius: 1.25rem;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
    }

    .role-card-home:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 28px -12px <?= $theme == 'dark' ? 'rgba(0,0,0,0.6)' : 'rgba(15, 23, 42, 0.12)' ?>;
    }

    /* Gradien Ikon Peran */
    .icon-murid { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
    .icon-guru { background: linear-gradient(135deg, #10b981 0%, #047857 100%); }
    .icon-ortu { background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%); }
    .icon-masyarakat { background: linear-gradient(135deg, #06b6d4 0%, #0e7490 100%); }
</style>

<!-- Main Container -->
<div class="container py-5 my-auto">

    <!-- Flash Message Notifikasi -->
    <?php if (!empty($pesan)): ?>
        <div class="alert alert-<?= $tipe_pesan ?> alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= htmlspecialchars($pesan) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Banner Hero Section -->
    <div class="hero-banner p-4 p-md-5 rounded-4 text-white mb-5 d-flex align-items-center justify-content-between flex-wrap gap-4">
        <div>
            <span class="badge bg-white text-primary px-3 py-2 rounded-pill fw-bold mb-3 shadow-sm"><?= $text['badge_official'] ?></span>
            <h1 class="fw-extrabold display-6 mb-2"><?= $text['hero_title'] ?></h1>
            <p class="mb-0 opacity-90 lead fs-6"><?= $text['hero_desc'] ?></p>
        </div>
        <div>
            <a href="login.php" class="btn btn-light text-primary btn-lg rounded-pill px-4 fw-bold shadow-sm">
                <i class="fas fa-user-shield me-2"></i><?= $text['btn_admin'] ?>
            </a>
        </div>
    </div>

    <!-- Sub Judul Pilih Peran -->
    <div class="text-center mb-4">
        <h4 class="fw-bold mb-1"><?= $text['choose_role'] ?></h4>
        <p class="text-muted small mb-0"><?= $text['choose_desc'] ?></p>
    </div>

    <!-- Grid Kartu Peran (4 Role) -->
    <div class="row g-4 justify-content-center">
        
        <!-- Role: Murid / Siswa -->
        <div class="col-6 col-md-3">
            <div class="card role-card-home h-100 p-3 text-center">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="p-3 rounded-circle text-white icon-murid mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 65px; height: 65px;">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-1"><?= $text['role_murid'] ?></h5>
                    <p class="text-muted small mb-3"><?= $text['desc_murid'] ?></p>
                    <a href="aspirasi.php?role=murid" class="btn btn-primary btn-sm rounded-pill w-100 mt-auto fw-semibold shadow-sm">
                        <?= $text['btn_send'] ?> <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Role: Guru & Staf -->
        <div class="col-6 col-md-3">
            <div class="card role-card-home h-100 p-3 text-center">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="p-3 rounded-circle text-white icon-guru mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 65px; height: 65px;">
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-1"><?= $text['role_guru'] ?></h5>
                    <p class="text-muted small mb-3"><?= $text['desc_guru'] ?></p>
                    <a href="aspirasi.php?role=guru" class="btn btn-success btn-sm rounded-pill w-100 mt-auto fw-semibold shadow-sm">
                        <?= $text['btn_send'] ?> <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Role: Orang Tua / Wali -->
        <div class="col-6 col-md-3">
            <div class="card role-card-home h-100 p-3 text-center">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="p-3 rounded-circle text-white icon-ortu mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 65px; height: 65px;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-1"><?= $text['role_ortu'] ?></h5>
                    <p class="text-muted small mb-3"><?= $text['desc_ortu'] ?></p>
                    <a href="aspirasi.php?role=ortu" class="btn btn-warning text-dark btn-sm rounded-pill w-100 mt-auto fw-semibold shadow-sm">
                        <?= $text['btn_send'] ?> <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Role: Masyarakat Umum -->
        <div class="col-6 col-md-3">
            <div class="card role-card-home h-100 p-3 text-center">
                <div class="card-body d-flex flex-column align-items-center">
                    <div class="p-3 rounded-circle text-white icon-masyarakat mb-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 65px; height: 65px;">
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                    <h5 class="fw-bold fs-6 mb-1"><?= $text['role_masyarakat'] ?></h5>
                    <p class="text-muted small mb-3"><?= $text['desc_masyarakat'] ?></p>
                    <a href="aspirasi.php?role=masyarakat" class="btn btn-info text-white btn-sm rounded-pill w-100 mt-auto fw-semibold shadow-sm">
                        <?= $text['btn_send'] ?> <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Footer Aplikasi -->
<footer class="py-3 mt-auto border-top" style="background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;">
    <div class="container text-center text-muted small">
        &copy; <?= date('Y') ?> SMKN 1 Sumedang. All Rights Reserved.
    </div>
</footer>

<!-- JS Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>