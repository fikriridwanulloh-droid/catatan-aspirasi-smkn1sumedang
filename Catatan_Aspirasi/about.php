<?php
session_start();
include 'koneksi.php';

$page_title = "Tentang Aplikasi & Pengembang - SMKN 1 Sumedang";
$active_nav = "about";

// Include Taskbar Header Modular
include 'header.php';

$theme = $_SESSION['theme'] ?? 'light';
$lang  = $_SESSION['lang'] ?? 'id';

// Kamus Bahasa
$text = [
    'id' => [
        'title'        => 'Tentang Portal Aspirasi',
        'subtitle'     => 'Informasi Resmi Sistem & Hak Cipta Pengembang',
        'dev_title'    => 'Pengembang Utama (Developer)',
        'dev_name'     => 'Fikri Ridwanulloh',
        'dev_role'     => 'Pencipta & Pengembang Sistem',
        'dev_copyright'=> 'Sistem ini dirancang, dibangun, dan dikembangkan secara eksklusif oleh Fikri Ridwanulloh. Dilarang keras menggandakan, mengubah hak cipta, atau mengklaim kepemilikan sistem ini tanpa izin tertulis.',
        'features_title' => 'Fitur-Fitur Unggulan Sistem',
        'f1_title'     => 'Multi-Peran (Role-Based)',
        'f1_desc'      => 'Formulir pengaduan khusus untuk Siswa, Guru & Staf, Orang Tua/Wali, dan Masyarakat Umum.',
        'f2_title'     => 'Aspirasi Rahasia / Anonim',
        'f2_desc'      => 'Fitur penyamaan identitas pelapor menggunakan Kode Unik dengan wajib melampirkan alasan kerahasiaan.',
        'f3_title'     => 'Tampilan Modern & Responsif',
        'f3_desc'      => 'Desain glassmorphism berbasis Bootstrap 5 dan Plus Jakarta Sans yang ramah pengguna komputer maupun ponsel.',
        'f4_title'     => 'Dua Bahasa (Bilingual ID/EN)',
        'f4_desc'      => 'Dukungan alih bahasa Indonesia dan Inggris secara instan berdasarkan sesi pengguna.',
        'f5_title'     => 'Mode Terang & Gelap',
        'f5_desc'      => 'Fitur switch Light/Dark mode yang fleksibel untuk kenyamanan visual penggunanya.',
        'f6_title'     => 'Dashboard & Grafik Analitik',
        'f6_desc'      => 'Panel admin interaktif dilengkapi grafik statistik jurusan, manajemen status, balasan, dan cetak laporan PDF.'
    ],
    'en' => [
        'title'        => 'About Aspiration Portal',
        'subtitle'     => 'Official System Information & Developer Copyright',
        'dev_title'    => 'Lead Developer',
        'dev_name'     => 'Fikri Ridwanulloh',
        'dev_role'     => 'System Creator & Developer',
        'dev_copyright'=> 'This system was exclusively designed, built, and developed by Fikri Ridwanulloh. It is strictly prohibited to duplicate, modify copyright, or claim ownership of this system without written permission.',
        'features_title' => 'Key System Features',
        'f1_title'     => 'Role-Based Submissions',
        'f1_desc'      => 'Dedicated aspiration forms for Students, Teachers & Staff, Parents/Guardians, and Public.',
        'f2_title'     => 'Secret / Anonymous Aspiration',
        'f2_desc'      => 'Identity concealment feature using unique codes with mandatory justification.',
        'f3_title'     => 'Modern & Responsive UI',
        'f3_desc'      => 'Glassmorphism interface powered by Bootstrap 5 and Plus Jakarta Sans for mobile and desktop.',
        'f4_title'     => 'Bilingual Support (ID/EN)',
        'f4_desc'      => 'Instant switching between Indonesian and English based on user session.',
        'f5_title'     => 'Light & Dark Mode',
        'f5_desc'      => 'Flexible theme switching for optimized visual comfort.',
        'f6_title'     => 'Dashboard & Analytics',
        'f6_desc'      => 'Interactive admin panel with department statistical charts, status management, responses, and PDF export.'
    ]
][$lang];
?>

<style>
    .card-about {
        background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
        border-radius: 1.5rem;
        box-shadow: 0 10px 25px -5px <?= $theme == 'dark' ? 'rgba(0,0,0,0.4)' : 'rgba(15, 23, 42, 0.05)' ?>;
    }

    .developer-box {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 1.25rem;
        color: #ffffff;
    }

    .feature-icon-box {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
</style>

<!-- Main Container -->
<div class="container py-5 my-auto" style="max-width: 900px;">

    <!-- Sub Header Judul -->
    <div class="text-center mb-5">
        <h3 class="fw-extrabold mb-1"><?= $text['title'] ?></h3>
        <p class="text-muted small mb-0"><?= $text['subtitle'] ?></p>
    </div>

    <!-- Kotak Pengembang (Hak Cipta Fikri Ridwanulloh) -->
    <div class="developer-box p-4 p-md-5 mb-5 shadow-lg position-relative overflow-hidden">
        <div class="d-flex align-items-center gap-4 flex-wrap flex-md-nowrap">
            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 85px; height: 85px;">
                <i class="fas fa-code fa-3x"></i>
            </div>
            <div>
                <span class="badge bg-white text-primary rounded-pill px-3 py-1 fw-bold mb-2 shadow-sm"><?= $text['dev_title'] ?></span>
                <h2 class="fw-bold mb-1"><?= $text['dev_name'] ?></h2>
                <p class="mb-2 opacity-90 fw-semibold"><?= $text['dev_role'] ?></p>
                <p class="mb-0 small opacity-80 leading-relaxed">
                    <i class="fas fa-shield-alt me-1"></i> <?= $text['dev_copyright'] ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Kartu Fitur-Fitur Aplikasi -->
    <div class="card card-about p-4 p-md-5">
        <h4 class="fw-bold mb-4 text-center">
            <i class="fas fa-cubes text-primary me-2"></i><?= $text['features_title'] ?>
        </h4>

        <div class="row g-4">
            <!-- Fitur 1 -->
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="feature-icon-box bg-primary text-white">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $text['f1_title'] ?></h6>
                        <p class="text-muted small mb-0"><?= $text['f1_desc'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Fitur 2 -->
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="feature-icon-box bg-danger text-white">
                        <i class="fas fa-user-secret"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $text['f2_title'] ?></h6>
                        <p class="text-muted small mb-0"><?= $text['f2_desc'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Fitur 3 -->
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="feature-icon-box bg-success text-white">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $text['f3_title'] ?></h6>
                        <p class="text-muted small mb-0"><?= $text['f3_desc'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Fitur 4 -->
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="feature-icon-box bg-info text-white">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $text['f4_title'] ?></h6>
                        <p class="text-muted small mb-0"><?= $text['f4_desc'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Fitur 5 -->
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="feature-icon-box bg-warning text-dark">
                        <i class="fas fa-moon"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $text['f5_title'] ?></h6>
                        <p class="text-muted small mb-0"><?= $text['f5_desc'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Fitur 6 -->
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="feature-icon-box bg-secondary text-white">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $text['f6_title'] ?></h6>
                        <p class="text-muted small mb-0"><?= $text['f6_desc'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Footer -->
<footer class="py-3 mt-auto border-top" style="background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;">
    <div class="container text-center text-muted small">
        &copy; <?= date('Y') ?> SMKN 1 Sumedang. Created & Developed by <strong>Fikri Ridwanulloh</strong>.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>