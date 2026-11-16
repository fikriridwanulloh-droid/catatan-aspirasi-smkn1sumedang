<?php
session_start();
include 'koneksi.php';

$page_title = "Lacak Aspirasi - SMKN 1 Sumedang";
$active_nav = "lacak";
include 'header.php';

$theme = $_SESSION['theme'] ?? 'light';
$lang  = $_SESSION['lang'] ?? 'id';
$hasil_pencarian = null;
$error_msg = '';

if (isset($_GET['kode']) && !empty(trim($_GET['kode']))) {
    $kode = mysqli_real_escape_string($koneksi, trim($_GET['kode']));
    
    // Cari di keempat tabel peran secara bergantian
    $tabel_list = ['aspirasi_murid', 'aspirasi_guru', 'aspirasi_ortu', 'aspirasi_masyarakat'];
    
    foreach ($tabel_list as $tabel) {
        $query = mysqli_query($koneksi, "SELECT *, '$tabel' as role_tabel FROM $tabel WHERE kode_tiket = '$kode'");
        if ($query && mysqli_num_rows($query) > 0) {
            $hasil_pencarian = mysqli_fetch_assoc($query);
            break;
        }
    }
    
    if (!$hasil_pencarian) {
        $error_msg = $lang == 'en' ? "Aspiration with ticket code '$kode' was not found." : "Aspirasi dengan kode tiket '$kode' tidak ditemukan.";
    }
}
?>

<style>
    .lacak-card {
        background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
        border-radius: 1.5rem;
        box-shadow: 0 10px 25px -5px <?= $theme == 'dark' ? 'rgba(0,0,0,0.4)' : 'rgba(15, 23, 42, 0.05)' ?>;
    }
    .form-control {
        background-color: <?= $theme == 'dark' ? '#0f172a' : '#ffffff' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#cbd5e1' ?>;
        color: <?= $theme == 'dark' ? '#f8fafc' : '#0f172a' ?>;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
    }
</style>

<div class="container py-5 my-auto" style="max-width: 650px;">
    <div class="text-center mb-4">
        <h3 class="fw-bold mb-1"><i class="fas fa-search me-2 text-primary"></i>Lacak Status Aspirasi</h3>
        <p class="text-muted small">Masukkan kode tiket unik yang Anda dapatkan saat mengirimkan aspirasi.</p>
    </div>

    <!-- Form Pencarian -->
    <div class="card lacak-card p-4 p-md-5 mb-4">
        <form action="lacak.php" method="GET">
            <div class="input-group mb-3">
                <input type="text" name="kode" class="form-control form-control-lg" placeholder="Contoh: ASP-8F29A" value="<?= htmlspecialchars($_GET['kode'] ?? '') ?>" required>
                <button type="submit" class="btn btn-primary px-4 fw-bold">
                    <i class="fas fa-search me-1"></i> Cek Status
                </button>
            </div>
        </form>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger rounded-3 small py-2 mb-0">
                <i class="fas fa-exclamation-circle me-1"></i> <?= $error_msg ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Hasil Pencarian -->
    <?php if ($hasil_pencarian): ?>
        <div class="card lacak-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                <span class="badge bg-dark text-warning px-3 py-1.5 rounded-pill fw-bold">
                    <i class="fas fa-ticket-alt me-1"></i> <?= htmlspecialchars($hasil_pencarian['kode_tiket']) ?>
                </span>
                <span class="badge bg-<?= $hasil_pencarian['status'] == 'Selesai' ? 'success' : ($hasil_pencarian['status'] == 'Ditolak' ? 'danger' : 'warning text-dark') ?> px-3 py-1.5 rounded-pill fw-bold">
                    <?= htmlspecialchars($hasil_pencarian['status']) ?>
                </span>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Tanggal Pengiriman</span>
                <span class="fw-semibold"><?= date('d/m/Y H:i', strtotime($hasil_pencarian['tanggal'])) ?></span>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Kategori Topik</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill">
                    <?= htmlspecialchars($hasil_pencarian['kategori']) ?>
                </span>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Rincian Aspirasi</span>
                <p class="p-3 bg-body-tertiary rounded-3 border mb-0 small"><?= htmlspecialchars($hasil_pencarian['keterangan']) ?></p>
            </div>

            <div class="mb-0">
                <span class="text-muted small d-block">Tanggapan Admin Sekolah</span>
                <?php if (!empty($hasil_pencarian['tanggapan'])): ?>
                    <div class="p-3 rounded-3 bg-primary-subtle text-primary border border-primary-subtle small fw-semibold">
                        <i class="fas fa-comment-dots me-1"></i> <?= htmlspecialchars($hasil_pencarian['tanggapan']) ?>
                    </div>
                <?php else: ?>
                    <span class="text-muted fst-italic small"><i class="far fa-hourglass me-1"></i> Belum ada tanggapan dari admin. Mohon menunggu.</span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<footer class="py-3 mt-auto border-top" style="background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;">
    <div class="container text-center text-muted small">
        &copy; <?= date('Y') ?> SMKN 1 Sumedang. All Rights Reserved.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>