<?php
session_start();
include 'koneksi.php';

// Proteksi Halaman Admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$theme = $_SESSION['theme'] ?? 'light';
$lang  = $_SESSION['lang'] ?? 'id';

// Kamus Bahasa Dashboard Admin
$text = [
    'id' => [
        'page_title'     => 'Dashboard Administrator - SMKN 1 Sumedang',
        'brand_admin'    => 'SMKN 1 Sumedang',
        'badge_admin'    => 'Panel Kontrol',
        'nav_home'       => 'Beranda',
        'nav_list'       => 'Lihat Publik',
        'logout'         => 'Keluar',
        'heading'        => 'Kelola Pengaduan & Grafik Jurusan',
        'active_category'=> 'Kategori Aktif',
        'btn_print'      => 'Cetak Laporan (PDF)',
        'chart_bar'      => 'Grafik Aspirasi per Jurusan',
        'chart_pie'      => 'Persentase Jurusan',
        'tab_murid'      => 'Siswa / Murid',
        'tab_guru'       => 'Guru & Staf',
        'tab_ortu'       => 'Orang Tua / Wali',
        'tab_masyarakat' => 'Masyarakat Umum',
        'th_no'          => 'No',
        'th_date'        => 'Tanggal',
        'th_sender'      => 'Nama Pengirim',
        'th_category'    => 'Kategori',
        'th_content'     => 'Isi Aspirasi',
        'th_feedback'    => 'Tanggapan Admin',
        'th_proof'       => 'Lampiran',
        'th_status'      => 'Status',
        'th_action'      => 'Aksi',
        'btn_view_name'  => 'Lihat Nama',
        'btn_respond'    => 'Tanggapi',
        'no_response'    => 'Belum ada tanggapan',
        'empty'          => 'Belum ada data pengaduan untuk kategori ini.'
    ],
    'en' => [
        'page_title'     => 'Administrator Dashboard - SMKN 1 Sumedang',
        'brand_admin'    => 'SMKN 1 Sumedang',
        'badge_admin'    => 'Control Panel',
        'nav_home'       => 'Home',
        'nav_list'       => 'View Public',
        'logout'         => 'Logout',
        'heading'        => 'Manage Aspirations & Department Chart',
        'active_category'=> 'Active Category',
        'btn_print'      => 'Print Report (PDF)',
        'chart_bar'      => 'Aspirations Chart per Department',
        'chart_pie'      => 'Department Percentage',
        'tab_murid'      => 'Student',
        'tab_guru'       => 'Teacher & Staff',
        'tab_ortu'       => 'Parents',
        'tab_masyarakat' => 'Public',
        'th_no'          => 'No',
        'th_date'        => 'Date',
        'th_sender'      => 'Sender Name',
        'th_category'    => 'Category',
        'th_content'     => 'Content',
        'th_feedback'    => 'Admin Feedback',
        'th_proof'       => 'Attachment',
        'th_status'      => 'Status',
        'th_action'      => 'Action',
        'btn_view_name'  => 'View Name',
        'btn_respond'    => 'Respond',
        'no_response'    => 'No feedback yet',
        'empty'          => 'No aspiration data for this category yet.'
    ]
][$lang];

// Handling Update Status & Tanggapan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $id        = (int)$_POST['id'];
    $tabel     = mysqli_real_escape_string($koneksi, $_POST['tabel']);
    $status    = mysqli_real_escape_string($koneksi, $_POST['status']);
    $tanggapan = mysqli_real_escape_string($koneksi, trim($_POST['tanggapan']));

    $tabel_valid = ['aspirasi_murid', 'aspirasi_guru', 'aspirasi_ortu', 'aspirasi_masyarakat'];

    if (in_array($tabel, $tabel_valid)) {
        $query = "UPDATE $tabel SET status='$status', tanggapan='$tanggapan' WHERE id=$id";
        if (mysqli_query($koneksi, $query)) {
            $_SESSION['pesan'] = $lang == 'en' ? "Status & Feedback updated successfully!" : "Status & Tanggapan berhasil diperbarui!";
            $_SESSION['tipe_pesan'] = "success";
        } else {
            $_SESSION['pesan'] = "Error: " . mysqli_error($koneksi);
            $_SESSION['tipe_pesan'] = "danger";
        }
    }
    header("Location: dashboard.php?tab=" . str_replace('aspirasi_', '', $tabel));
    exit;
}

// Handling Hapus Data
if (isset($_GET['action']) && $_GET['action'] == 'hapus' && isset($_GET['id']) && isset($_GET['tabel'])) {
    $id    = (int)$_GET['id'];
    $tabel = mysqli_real_escape_string($koneksi, $_GET['tabel']);
    $tabel_valid = ['aspirasi_murid', 'aspirasi_guru', 'aspirasi_ortu', 'aspirasi_masyarakat'];

    if (in_array($tabel, $tabel_valid)) {
        mysqli_query($koneksi, "DELETE FROM $tabel WHERE id=$id");
        $_SESSION['pesan'] = $lang == 'en' ? "Data deleted successfully." : "Data pengaduan berhasil dihapus.";
        $_SESSION['tipe_pesan'] = "warning";
    }
    header("Location: dashboard.php?tab=" . str_replace('aspirasi_', '', $tabel));
    exit;
}

$tab = $_GET['tab'] ?? 'murid';
$tabel_aktif = 'aspirasi_' . $tab;
$result = mysqli_query($koneksi, "SELECT * FROM $tabel_aktif ORDER BY id DESC");

$label_tab = [
    'murid'      => $text['tab_murid'],
    'guru'       => $text['tab_guru'],
    'ortu'       => $text['tab_ortu'],
    'masyarakat' => $text['tab_masyarakat']
];

// Data Grafik Jurusan SMKN 1 Sumedang
$jurusan_labels = ['DPIB', 'TITL', 'TEI', 'TAV', 'TPM', 'TPL', 'TKR', 'TKJ', 'RPL', 'SK'];
$jurusan_data   = [];

foreach ($jurusan_labels as $jrs) {
    $q_jrs = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM aspirasi_murid WHERE jurusan = '$jrs'");
    $row_jrs = mysqli_fetch_assoc($q_jrs);
    $jurusan_data[] = $row_jrs['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" data-bs-theme="<?= $theme ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $text['page_title'] ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: <?= $theme == 'dark' ? '#0f172a' : '#f8fafc' ?>; 
            color: <?= $theme == 'dark' ? '#f8fafc' : '#0f172a' ?>;
            min-height: 100vh;
        }

        /* Taskbar Admin Modern Styling */
        .admin-taskbar {
            background-color: <?= $theme == 'dark' ? 'rgba(30, 41, 59, 0.95)' : 'rgba(255, 255, 255, 0.95)' ?>;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .admin-brand {
            font-weight: 800;
            font-size: 1.15rem;
            color: <?= $theme == 'dark' ? '#ffffff' : '#0f172a' ?> !important;
        }

        .admin-badge {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            font-size: 0.725rem;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .admin-user-pill {
            background-color: <?= $theme == 'dark' ? '#0f172a' : '#f1f5f9' ?>;
            border: 1px solid <?= $theme == 'dark' ? '#334155' : '#cbd5e1' ?>;
            color: <?= $theme == 'dark' ? '#f8fafc' : '#1e293b' ?>;
            border-radius: 9999px;
            padding: 0.4rem 0.9rem;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .btn-theme-toggle {
            background-color: <?= $theme == 'dark' ? '#334155' : '#f1f5f9' ?>;
            color: <?= $theme == 'dark' ? '#f59e0b' : '#334155' ?>;
            border: 1px solid <?= $theme == 'dark' ? '#475569' : '#cbd5e1' ?>;
        }

        .nav-link-custom {
            font-weight: 600;
            font-size: 0.875rem;
            color: <?= $theme == 'dark' ? '#cbd5e1' : '#475569' ?>;
            padding: 0.45rem 0.9rem;
            border-radius: 9999px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .nav-link-custom:hover {
            color: #3b82f6;
            background-color: <?= $theme == 'dark' ? '#334155' : '#f1f5f9' ?>;
        }

        .kop-surat { display: none; }

        @media print {
            .no-print, navbar, .nav-pills, .btn, .chart-section { display: none !important; }
            body { background-color: #ffffff !important; color: #000000 !important; }
            .card { border: none !important; box-shadow: none !important; padding: 0 !important; }
            .kop-surat {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                border-bottom: 3px double #000;
                padding-bottom: 15px;
                margin-bottom: 20px;
            }
            .table { width: 100% !important; border-collapse: collapse !important; }
            .table th, .table td { border: 1px solid #000 !important; color: #000 !important; padding: 8px !important; }
        }
    </style>
</head>
<body class="d-flex flex-column">

    <!-- TASKBAR ADMIN UTAMA -->
    <nav class="navbar navbar-expand-lg admin-taskbar sticky-top py-2.5 no-print">
        <div class="container-fluid px-4">
            
            <!-- Brand Logo & Nama Sekolah -->
            <a class="navbar-brand admin-brand d-flex align-items-center gap-3" href="dashboard.php">
                <img src="LogoSmk1.jpg" alt="Logo SMKN 1 Sumedang" width="38" height="38" class="rounded-circle border border-2 border-primary me-1">
                <div class="d-flex align-items-center gap-2">
                    <span><?= $text['brand_admin'] ?></span>
                    <span class="admin-badge d-none d-sm-inline-block"><i class="fas fa-user-shield me-1"></i><?= $text['badge_admin'] ?></span>
                </div>
            </a>

            <!-- Toggle Mobile Menu -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminTaskbarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navigasi Admin -->
            <div class="collapse navbar-collapse" id="adminTaskbarMenu">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1 text-center">
                    <li class="nav-item">
                        <a class="nav-link-custom d-inline-block" href="index.php" target="_blank">
                            <i class="fas fa-external-link-alt me-1.5"></i> <?= $text['nav_home'] ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-custom d-inline-block" href="daftar_pengaduan.php" target="_blank">
                            <i class="fas fa-list-alt me-1.5"></i> <?= $text['nav_list'] ?>
                        </a>
                    </li>
                </ul>

                <!-- Sisi Kanan: Profile Admin, Switch Mode & Logout -->
                <div class="d-flex align-items-center justify-content-center gap-2 mt-3 mt-lg-0">
                    
                    <!-- Username Admin Active -->
                    <div class="admin-user-pill d-flex align-items-center gap-2">
                        <i class="fas fa-user-circle text-primary fs-6"></i>
                        <span><?= htmlspecialchars($_SESSION['admin_nama'] ?? $_SESSION['admin_username'] ?? 'Admin') ?></span>
                    </div>

                    <!-- Mode Gelap/Terang Toggle -->
                    <a class="btn btn-theme-toggle btn-sm rounded-circle p-2" href="mode_terang_gelap.php" title="Ubah Mode Tampilan">
                        <i class="fas <?= $theme == 'dark' ? 'fa-sun text-warning' : 'fa-moon' ?> fa-fw"></i>
                    </a>

                    <!-- Bahasa ID / EN Toggle -->
                    <a class="btn btn-theme-toggle btn-sm rounded-pill px-3 fw-bold" href="mode_inggris.php" title="Change Language">
                        <i class="fas fa-globe me-1"></i><?= strtoupper($lang) ?>
                    </a>

                    <!-- Tombol Keluar -->
                    <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-semibold ms-1">
                        <i class="fas fa-sign-out-alt me-1"></i> <?= $text['logout'] ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- KONTEN DASHBOARD -->
    <div class="container-fluid px-4 py-4">
        
        <!-- Flash Message Notifikasi -->
        <?php if (isset($_SESSION['pesan'])): ?>
            <div class="alert alert-<?= $_SESSION['tipe_pesan'] ?? 'info' ?> alert-dismissible fade show rounded-4 shadow-sm no-print mb-4">
                <i class="fas fa-info-circle me-2"></i><?= $_SESSION['pesan'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['pesan'], $_SESSION['tipe_pesan']); ?>
        <?php endif; ?>

        <!-- KOP SURAT PRINT OFFICIAL -->
        <div class="kop-surat">
            <img src="LogoSmk1.jpg" alt="Logo SMKN 1 Sumedang" width="80" height="80">
            <div class="text-center flex-grow-1 px-3">
                <h4 class="fw-bold mb-0">PEMERINTAH PROVINSI JAWA BARAT</h4>
                <h5 class="fw-bold mb-0">DINAS PENDIDIKAN</h5>
                <h3 class="fw-bold mb-1">SMK NEGERI 1 SUMEDANG</h3>
                <p class="small mb-0">Jl. Mayor Abdurrahman No. 209, Telp/Fax: (0261) 201531, Sumedang 45322</p>
            </div>
            <div style="width: 80px;"></div>
        </div>

        <!-- Header Dashboard & Tombol Cetak -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 no-print">
            <div>
                <h4 class="fw-bold mb-1"><?= $text['heading'] ?></h4>
                <p class="text-muted small mb-0"><?= $text['active_category'] ?>: <strong class="text-primary"><?= $label_tab[$tab] ?></strong></p>
            </div>
            <button onclick="window.print()" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                <i class="fas fa-print me-2"></i> <?= $text['btn_print'] ?>
            </button>
        </div>

        <!-- SEKSI GRAFIK -->
        <div class="row g-4 mb-4 no-print chart-section">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h5 class="fw-bold mb-3"><i class="fas fa-chart-bar text-primary me-2"></i><?= $text['chart_bar'] ?></h5>
                    <div style="position: relative; height: 250px;">
                        <canvas id="chartJurusan"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h5 class="fw-bold mb-3"><i class="fas fa-chart-pie text-info me-2"></i><?= $text['chart_pie'] ?></h5>
                    <div style="position: relative; height: 250px;" class="d-flex align-items-center justify-content-center">
                        <canvas id="chartPieJurusan"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB NAVIGASI KATEGORI PERAN -->
        <ul class="nav nav-pills mb-4 gap-2 no-print">
            <li class="nav-item"><a class="nav-link <?= $tab == 'murid' ? 'active' : '' ?>" href="dashboard.php?tab=murid"><i class="fas fa-user-graduate me-1.5"></i> <?= $text['tab_murid'] ?></a></li>
            <li class="nav-item"><a class="nav-link <?= $tab == 'guru' ? 'active' : '' ?>" href="dashboard.php?tab=guru"><i class="fas fa-chalkboard-teacher me-1.5"></i> <?= $text['tab_guru'] ?></a></li>
            <li class="nav-item"><a class="nav-link <?= $tab == 'ortu' ? 'active' : '' ?>" href="dashboard.php?tab=ortu"><i class="fas fa-users me-1.5"></i> <?= $text['tab_ortu'] ?></a></li>
            <li class="nav-item"><a class="nav-link <?= $tab == 'masyarakat' ? 'active' : '' ?>" href="dashboard.php?tab=masyarakat"><i class="fas fa-building me-1.5"></i> <?= $text['tab_masyarakat'] ?></a></li>
        </ul>

        <!-- TABEL DATA ASPIRASI -->
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th><?= $text['th_no'] ?></th>
                            <th><?= $text['th_date'] ?></th>
                            <th><?= $text['th_sender'] ?></th>
                            <th><?= $text['th_category'] ?></th>
                            <th><?= $text['th_content'] ?></th>
                            <th><?= $text['th_feedback'] ?></th>
                            <th class="no-print"><?= $text['th_proof'] ?></th>
                            <th><?= $text['th_status'] ?></th>
                            <th class="text-center no-print"><?= $text['th_action'] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && mysqli_num_rows($result) > 0): $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="small text-muted" style="white-space: nowrap;"><?= date('d/m/Y H:i', strtotime($row['tanggal'])) ?></td>
                                    
                                    <!-- SENDER NAME & RAHASIA MODAL -->
                                    <td>
                                        <?php if (!empty($row['is_rahasia']) && $row['is_rahasia'] == 1): ?>
                                            <span class="badge bg-dark text-warning border border-warning px-2 py-1 me-1">
                                                <i class="fas fa-user-secret me-1"></i><?= htmlspecialchars($row['kode_rahasia']) ?>
                                            </span>
                                            <button type="button" class="btn btn-xs btn-outline-warning rounded-pill py-0 px-2 small no-print" data-bs-toggle="modal" data-bs-target="#modalRahasia<?= $row['id'] ?>">
                                                <?= $text['btn_view_name'] ?>
                                            </button>

                                            <!-- Modal Buka Identitas Rahasia -->
                                            <div class="modal fade" id="modalRahasia<?= $row['id'] ?>" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content rounded-4 border-0 shadow">
                                                        <div class="modal-header bg-dark text-warning">
                                                            <h6 class="modal-title fw-bold"><i class="fas fa-user-shield me-2"></i>Detail Identitas Rahasia</h6>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <label class="small text-muted mb-1">Kode Anonim</label>
                                                                <p class="fw-bold text-warning bg-dark p-2 rounded mb-0"><?= htmlspecialchars($row['kode_rahasia']) ?></p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="small text-muted mb-1">Nama Asli Pengirim</label>
                                                                <p class="fw-bold fs-5 mb-0 text-primary"><?= htmlspecialchars($row['nama']) ?></p>
                                                            </div>
                                                            <div>
                                                                <label class="small text-muted mb-1">Alasan Kerahasiaan</label>
                                                                <div class="p-2 bg-body-tertiary rounded border small"><?= htmlspecialchars($row['alasan_rahasia']) ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <span class="fw-bold"><?= htmlspecialchars($row['nama']) ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['kategori']) ?></span></td>
                                    <td class="small text-wrap" style="max-width: 220px;"><?= htmlspecialchars($row['keterangan']) ?></td>
                                    <td class="small text-wrap" style="max-width: 220px;">
                                        <?php if (!empty($row['tanggapan'])): ?>
                                            <span class="text-primary fw-semibold"><i class="fas fa-comment-dots me-1"></i><?= htmlspecialchars($row['tanggapan']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic small"><?= $text['no_response'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="no-print">
                                        <?php if (!empty($row['foto'])): ?>
                                            <a href="uploads/<?= $row['foto'] ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-2"><i class="fas fa-paperclip me-1"></i>File</a>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $row['status'] == 'Selesai' ? 'success' : ($row['status'] == 'Ditolak' ? 'danger' : 'warning text-dark') ?> px-3 py-1.5 rounded-pill">
                                            <?= htmlspecialchars($row['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center no-print">
                                        <button type="button" class="btn btn-sm btn-primary rounded-pill px-2.5 me-1" data-bs-toggle="modal" data-bs-target="#modalTanggapan<?= $row['id'] ?>">
                                            <i class="fas fa-reply me-1"></i> <?= $text['btn_respond'] ?>
                                        </button>
                                        <a href="dashboard.php?action=hapus&id=<?= $row['id'] ?>&tabel=<?= $tabel_aktif ?>" class="btn btn-sm btn-danger rounded-pill px-2" onclick="return confirm('Hapus data pengaduan ini?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- MODAL TANGGAPAN -->
                                <div class="modal fade" id="modalTanggapan<?= $row['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title fw-bold"><i class="fas fa-reply me-2"></i><?= $text['btn_respond'] ?></h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="dashboard.php" method="POST">
                                                <div class="modal-body text-start">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                    <input type="hidden" name="tabel" value="<?= $tabel_aktif ?>">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Ubah Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="Proses" <?= $row['status'] == 'Proses' ? 'selected' : '' ?>>Proses</option>
                                                            <option value="Selesai" <?= $row['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                                            <option value="Ditolak" <?= $row['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">Isi Tanggapan / Balasan</label>
                                                        <textarea name="tanggapan" class="form-control" rows="4" required><?= htmlspecialchars($row['tanggapan'] ?? '') ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="update_status" class="btn btn-primary rounded-pill px-4 fw-bold">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="9" class="text-center py-4 text-muted"><?= $text['empty'] ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-3 mt-auto border-top no-print">
        <div class="container text-center text-muted small">
            &copy; <?= date('Y') ?> SMKN 1 Sumedang. All Rights Reserved.
        </div>
    </footer>

    <!-- Bootstrap & Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const labelsJurusan = <?= json_encode($jurusan_labels) ?>;
        const dataJurusan   = <?= json_encode($jurusan_data) ?>;
        const colorsJurusan = ['#3b82f6', '#10b981', '#f59e0b', '#06b6d4', '#ef4444', '#8b5cf6', '#ec4899', '#64748b', '#14b8a6', '#f97316'];

        new Chart(document.getElementById('chartJurusan'), {
            type: 'bar',
            data: { labels: labelsJurusan, datasets: [{ label: 'Jumlah Aspirasi', data: dataJurusan, backgroundColor: colorsJurusan, borderRadius: 6 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('chartPieJurusan'), {
            type: 'doughnut',
            data: { labels: labelsJurusan, datasets: [{ data: dataJurusan, backgroundColor: colorsJurusan }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right', labels: { boxWidth: 10 } } } }
        });
    </script>
</body>
</html>