<?php
session_start();
include 'koneksi.php';

$page_title = "Daftar Aspirasi Publik - SMKN 1 Sumedang";
$active_nav = "daftar";

// Include Taskbar Header Modular
include 'header.php';

$theme = $_SESSION['theme'] ?? 'light';
$lang  = $_SESSION['lang'] ?? 'id';
$tab   = $_GET['tab'] ?? 'murid';

$tabel_valid = ['murid', 'guru', 'ortu', 'masyarakat'];
if (!in_array($tab, $tabel_valid)) {
    $tab = 'murid';
}

$tabel_aktif = 'aspirasi_' . $tab;
$result = mysqli_query($koneksi, "SELECT * FROM $tabel_aktif ORDER BY id DESC");

// Kamus Bahasa Multi-Language
$text = [
    'id' => [
        'sub_title'      => 'Daftar Aspirasi & Pengaduan Publik',
        'desc'           => 'Transparansi riwayat aspirasi yang telah dikirimkan oleh civitas hospitalia & publik',
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
        'th_proof'       => 'Bukti',
        'th_status'      => 'Status',
        'no_response'    => 'Belum ada tanggapan',
        'empty'          => 'Belum ada data pengaduan untuk kategori ini.'
    ],
    'en' => [
        'sub_title'      => 'Public Aspirations & Complaints List',
        'desc'           => 'Transparency log of aspirations submitted by the school community and general public',
        'tab_murid'      => 'Student',
        'tab_guru'       => 'Teacher & Staff',
        'tab_ortu'       => 'Parents / Guardian',
        'tab_masyarakat' => 'General Public',
        'th_no'          => 'No',
        'th_date'        => 'Date',
        'th_sender'      => 'Sender Name',
        'th_category'    => 'Category',
        'th_content'     => 'Content',
        'th_feedback'    => 'Admin Feedback',
        'th_proof'       => 'Attachment',
        'th_status'      => 'Status',
        'no_response'    => 'No feedback yet',
        'empty'          => 'No aspiration data for this category yet.'
    ]
][$lang];
?>

<style>
    /* Styling Nav Tab Peran */
    .role-pills .nav-link {
        background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;
        color: <?= $theme == 'dark' ? '#94a3b8' : '#64748b' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
        border-radius: 9999px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.25s ease;
    }

    .role-pills .nav-link:hover {
        color: #3b82f6;
        border-color: #3b82f6;
    }

    .role-pills .nav-link.active {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    /* Styling Tabel & Card */
    .content-card {
        background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
        border-radius: 1.5rem;
        box-shadow: 0 10px 25px -5px <?= $theme == 'dark' ? 'rgba(0,0,0,0.4)' : 'rgba(15, 23, 42, 0.05)' ?>;
    }

    .table-custom-header th {
        background-color: <?= $theme == 'dark' ? '#0f172a' : '#f8fafc' ?> !important;
        color: <?= $theme == 'dark' ? '#cbd5e1' : '#475569' ?> !important;
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
    }

    .table td {
        color: <?= $theme == 'dark' ? '#f8fafc' : '#1e293b' ?>;
        border-color: <?= $theme == 'dark' ? '#334155' : '#f1f5f9' ?>;
    }
</style>

<!-- Main Container -->
<div class="container py-5 my-auto">
    
    <!-- Sub Header Judul -->
    <div class="text-center mb-4">
        <h3 class="fw-bold mb-1"><?= $text['sub_title'] ?></h3>
        <p class="text-muted small mb-0"><?= $text['desc'] ?></p>
    </div>

    <!-- Tab Filter Peran Pelapor -->
    <ul class="nav role-pills justify-content-center mb-4 gap-2 overflow-x-auto pb-2">
        <li class="nav-item">
            <a class="nav-link text-nowrap <?= $tab == 'murid' ? 'active' : '' ?>" href="daftar_pengaduan.php?tab=murid">
                <i class="fas fa-user-graduate me-1.5"></i> <?= $text['tab_murid'] ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-nowrap <?= $tab == 'guru' ? 'active' : '' ?>" href="daftar_pengaduan.php?tab=guru">
                <i class="fas fa-chalkboard-teacher me-1.5"></i> <?= $text['tab_guru'] ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-nowrap <?= $tab == 'ortu' ? 'active' : '' ?>" href="daftar_pengaduan.php?tab=ortu">
                <i class="fas fa-users me-1.5"></i> <?= $text['tab_ortu'] ?>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-nowrap <?= $tab == 'masyarakat' ? 'active' : '' ?>" href="daftar_pengaduan.php?tab=masyarakat">
                <i class="fas fa-building me-1.5"></i> <?= $text['tab_masyarakat'] ?>
            </a>
        </li>
    </ul>

    <!-- Kartu Wadah Tabel -->
    <div class="card content-card p-3 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr class="table-custom-header">
                        <th class="py-3"><?= $text['th_no'] ?></th>
                        <th class="py-3"><?= $text['th_date'] ?></th>
                        <th class="py-3"><?= $text['th_sender'] ?></th>
                        <th class="py-3"><?= $text['th_category'] ?></th>
                        <th class="py-3"><?= $text['th_content'] ?></th>
                        <th class="py-3"><?= $text['th_feedback'] ?></th>
                        <th class="py-3"><?= $text['th_proof'] ?></th>
                        <th class="py-3 text-center"><?= $text['th_status'] ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="fw-semibold"><?= $no++ ?></td>
                                <td class="small text-muted" style="white-space: nowrap;">
                                    <i class="far fa-clock me-1"></i><?= date('d/m/Y H:i', strtotime($row['tanggal'])) ?>
                                </td>
                                
                                <!-- Nama Pengirim / Kode Rahasia -->
                                <td>
                                    <?php if (!empty($row['is_rahasia']) && $row['is_rahasia'] == 1): ?>
                                        <span class="badge bg-dark text-warning border border-warning px-2.5 py-1.5 rounded-pill">
                                            <i class="fas fa-user-secret me-1"></i><?= htmlspecialchars($row['kode_rahasia']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="fw-bold"><?= htmlspecialchars($row['nama']) ?></span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 rounded-pill fw-semibold">
                                        <?= htmlspecialchars($row['kategori']) ?>
                                    </span>
                                </td>
                                <td class="small text-wrap" style="max-width: 250px;"><?= htmlspecialchars($row['keterangan']) ?></td>
                                <td class="small text-wrap" style="max-width: 250px;">
                                    <?php if (!empty($row['tanggapan'])): ?>
                                        <div class="p-2 rounded-3 bg-body-tertiary border border-start border-3 border-primary">
                                            <span class="text-primary fw-semibold"><i class="fas fa-comment-dots me-1"></i><?= htmlspecialchars($row['tanggapan']) ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic"><i class="far fa-hourglass me-1"></i><?= $text['no_response'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($row['foto'])): ?>
                                        <a href="uploads/<?= $row['foto'] ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1">
                                            <i class="fas fa-paperclip me-1"></i>File
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-<?= $row['status'] == 'Selesai' ? 'success' : ($row['status'] == 'Ditolak' ? 'danger' : 'warning text-dark') ?> px-3 py-1.5 rounded-pill fw-bold">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted fs-6">
                                <i class="fas fa-inbox fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                <?= $text['empty'] ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="py-3 mt-auto border-top" style="background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;">
    <div class="container text-center text-muted small">
        &copy; <?= date('Y') ?> SMKN 1 Sumedang. All Rights Reserved.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>