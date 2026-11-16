<?php
session_start();
include 'koneksi.php';

$page_title = "Form Aspirasi - SMKN 1 Sumedang";
$active_nav = "aspirasi";

// Include Taskbar Header Modular
include 'header.php';

$theme = $_SESSION['theme'] ?? 'light';
$lang  = $_SESSION['lang'] ?? 'id';
$role  = $_GET['role'] ?? 'murid';

$config_role = [
    'murid' => [
        'title'       => 'Aspirasi Siswa / Murid',
        'badge'       => 'Siswa SMKN 1 Sumedang',
        'icon'        => 'fa-user-graduate',
        'color_class' => 'text-primary',
        'bg_gradient' => 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
        'desc'        => 'Suarakan masukan terkait fasilitas kelas, sarana praktikum, atau kegiatan ekstrakurikuler.'
    ],
    'guru' => [
        'title'       => 'Aspirasi Guru & Staf',
        'badge'       => 'Tenaga Pendidik',
        'icon'        => 'fa-chalkboard-teacher',
        'color_class' => 'text-success',
        'bg_gradient' => 'linear-gradient(135deg, #10b981 0%, #047857 100%)',
        'desc'        => 'Sampaikan usulan seputar sarana pembelajaran, fasilitas pengajaran, & manajemen sekolah.'
    ],
    'ortu' => [
        'title'       => 'Aspirasi Orang Tua / Wali',
        'badge'       => 'Wali Murid',
        'icon'        => 'fa-users',
        'color_class' => 'text-warning',
        'bg_gradient' => 'linear-gradient(135deg, #f59e0b 0%, #b45309 100%)',
        'desc'        => 'Wadah saran dan pandangan demi peningkatan mutu serta kenyamanan belajar putra/putri Anda.'
    ],
    'masyarakat' => [
        'title'       => 'Aspirasi Masyarakat Umum',
        'badge'       => 'Publik & Mitra',
        'icon'        => 'fa-building',
        'color_class' => 'text-info',
        'bg_gradient' => 'linear-gradient(135deg, #06b6d4 0%, #0e7490 100%)',
        'desc'        => 'Masukan lingkungan, laporan layanan publik, maupun sinergi kemitraan bersama SMKN 1 Sumedang.'
    ]
];

if (!array_key_exists($role, $config_role)) {
    $role = 'murid';
}

$active_role = $config_role[$role];
?>

<style>
    /* Styling Tombol Kembali Modern */
    .btn-back-custom {
        background-color: <?= $theme == 'dark' ? 'rgba(51, 65, 85, 0.6)' : '#ffffff' ?>;
        color: <?= $theme == 'dark' ? '#cbd5e1' : '#475569' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
        border-radius: 9999px;
        padding: 0.5rem 1.25rem;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-back-custom:hover {
        background-color: #3b82f6;
        color: #ffffff;
        border-color: #3b82f6;
        transform: translateX(-3px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-back-custom i {
        transition: transform 0.25s ease;
    }

    .btn-back-custom:hover i {
        transform: translateX(-2px);
    }

    .form-card {
        background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
        border-radius: 1.5rem;
        box-shadow: 0 20px 25px -5px <?= $theme == 'dark' ? 'rgba(0,0,0,0.5)' : 'rgba(15, 23, 42, 0.08)' ?>;
    }

    .role-header-banner {
        background: <?= $active_role['bg_gradient'] ?>;
        border-radius: 1.25rem;
        color: #ffffff;
        padding: 2.25rem 1.75rem;
        position: relative;
        overflow: hidden;
    }

    .role-nav-pill {
        background-color: <?= $theme == 'dark' ? '#0f172a' : '#f1f5f9' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
        color: <?= $theme == 'dark' ? '#94a3b8' : '#64748b' ?>;
        border-radius: 9999px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .role-nav-pill:hover, .role-nav-pill.active {
        background-color: #3b82f6;
        color: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
    }

    .form-control, .form-select {
        background-color: <?= $theme == 'dark' ? '#0f172a' : '#ffffff' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#cbd5e1' ?>;
        color: <?= $theme == 'dark' ? '#f8fafc' : '#0f172a' ?>;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        background-color: <?= $theme == 'dark' ? '#0f172a' : '#ffffff' ?>;
        color: <?= $theme == 'dark' ? '#f8fafc' : '#0f172a' ?>;
    }

    .rahasia-box {
        background-color: <?= $theme == 'dark' ? 'rgba(239, 68, 68, 0.1)' : '#fef2f2' ?>;
        border: 1px solid <?= $theme == 'dark' ? 'rgba(239, 68, 68, 0.3)' : '#fecaca' ?>;
        border-radius: 1rem;
    }

    .file-upload-box {
        background-color: <?= $theme == 'dark' ? '#0f172a' : '#f8fafc' ?>;
        border: 2px dashed <?= $theme == 'dark' ? '#334155' : '#cbd5e1' ?>;
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
    }
</style>

<div class="container py-4 py-md-5" style="max-width: 780px;">
    
    <!-- Header Navigasi -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="index.php" class="btn-back-custom">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Beranda</span>
        </a>
        
        <a href="daftar_pengaduan.php" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-2 fw-semibold shadow-sm">
            <i class="fas fa-list-alt me-1.5"></i> Lihat Daftar Aspirasi
        </a>
    </div>

    <!-- Tab Navigasi Peran -->
    <div class="d-flex gap-2 overflow-x-auto pb-3 mb-3 no-scrollbar">
        <a href="aspirasi.php?role=murid" class="role-nav-pill text-nowrap <?= $role == 'murid' ? 'active' : '' ?>">
            <i class="fas fa-user-graduate me-1"></i> Siswa
        </a>
        <a href="aspirasi.php?role=guru" class="role-nav-pill text-nowrap <?= $role == 'guru' ? 'active' : '' ?>">
            <i class="fas fa-chalkboard-teacher me-1"></i> Guru & Staf
        </a>
        <a href="aspirasi.php?role=ortu" class="role-nav-pill text-nowrap <?= $role == 'ortu' ? 'active' : '' ?>">
            <i class="fas fa-users me-1"></i> Orang Tua
        </a>
        <a href="aspirasi.php?role=masyarakat" class="role-nav-pill text-nowrap <?= $role == 'masyarakat' ? 'active' : '' ?>">
            <i class="fas fa-building me-1"></i> Masyarakat
        </a>
    </div>

    <!-- Kartu Form Utama -->
    <div class="card form-card p-3 p-md-4">
        
        <!-- Banner Peran -->
        <div class="role-header-banner mb-4">
            <span class="badge bg-white text-dark rounded-pill px-3 py-1 fw-bold mb-2 shadow-sm">
                <?= $active_role['badge'] ?>
            </span>
            <h3 class="fw-bold mb-1 d-flex align-items-center gap-2">
                <i class="fas <?= $active_role['icon'] ?>"></i> <?= $active_role['title'] ?>
            </h3>
            <p class="mb-0 opacity-90 small"><?= $active_role['desc'] ?></p>
        </div>

        <!-- Form Pengiriman -->
        <form action="proses_simpan_aspirasi.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="role" value="<?= $role ?>">

            <!-- Input Nama Pelapor -->
            <div class="mb-3">
                <label class="form-label">
                    Nama Lengkap Pelapor <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-user"></i></span>
                    <input type="text" name="nama" class="form-control border-start-0 ps-0" placeholder="Masukkan nama lengkap Anda..." required>
                </div>
            </div>

            <!-- DYNAMIC FIELD: Siswa / Murid -->
            <?php if ($role == 'murid'): ?>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kelas <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-school"></i></span>
                            <input type="text" name="kelas" class="form-control border-start-0 ps-0" placeholder="Contoh: XII RPL 1" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jurusan <span class="text-danger">*</span></label>
                        <select name="jurusan" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Jurusan --</option>
                            <option value="DPIB">DPIB</option>
                            <option value="TITL">TITL</option>
                            <option value="TEI">TEI</option>
                            <option value="TAV">TAV</option>
                            <option value="TPM">TPM</option>
                            <option value="TPL">TPL</option>
                            <option value="TKR">TKR</option>
                            <option value="TKJ">TKJ</option>
                            <option value="RPL">RPL</option>
                            <option value="SK">SK</option>
                        </select>
                    </div>
                </div>
            <?php endif; ?>

            <!-- DYNAMIC FIELD: Guru & Staf (Jabatan Bebas Diisi tapi Wajib) -->
            <?php if ($role == 'guru'): ?>
                <div class="mb-3">
                    <label class="form-label">Jabatan / Unit Kerja / Mata Pelajaran <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-briefcase"></i></span>
                        <input type="text" name="mapel" class="form-control border-start-0 ps-0" placeholder="Ketik bebas jabatan/posisi Anda (Contoh: Guru Produktif, Wali Kelas, Staf TU, dll)" required>
                    </div>
                </div>
            <?php endif; ?>

            <!-- DYNAMIC FIELD: Orang Tua / Wali (Nama Anak Bebas Diisi tapi Wajib) -->
            <?php if ($role == 'ortu'): ?>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Siswa / Putra / Putri <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-child"></i></span>
                            <input type="text" name="nama_siswa" class="form-control border-start-0 ps-0" placeholder="Ketik bebas nama lengkap putra/putri Anda" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kelas Siswa <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-graduation-cap"></i></span>
                            <input type="text" name="kelas_siswa" class="form-control border-start-0 ps-0" placeholder="Contoh: XI TKJ 2" required>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- DYNAMIC FIELD: Masyarakat Umum -->
            <?php if ($role == 'masyarakat'): ?>
                <div class="mb-3">
                    <label class="form-label">Nomor WhatsApp / Kontak Aktif <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fab fa-whatsapp"></i></span>
                        <input type="text" name="kontak" class="form-control border-start-0 ps-0" placeholder="Contoh: 081234567890" required>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Kategori Pengaduan -->
            <div class="mb-3">
                <label class="form-label">Kategori Topik Aspirasi <span class="text-danger">*</span></label>
                <select name="kategori" class="form-select" required>
                    <option value="" selected disabled>-- Pilih Kategori Pengaduan --</option>
                    <option value="Fasilitas & Sarana">Fasilitas, Gedung & Sarana Sekolah</option>
                    <option value="Sistem Pembelajaran">Sistem Kurikulum & Pembelajaran</option>
                    <option value="Kebersihan & Lingkungan">Kebersihan, Lingkungan & Keamanan</option>
                    <option value="Pelayanan & Manajemen">Pelayanan Administrasi & Manajemen</option>
                    <option value="Kegiatan Kesiswaan">Kegiatan Kesiswaan & Ekstrakurikuler</option>
                    <option value="Lainnya">Lainnya / Masukan Umum</option>
                </select>
            </div>

            <!-- Detail Isian Aspirasi -->
            <div class="mb-4">
                <label class="form-label">Rincian Isi Aspirasi / Pengaduan <span class="text-danger">*</span></label>
                <textarea name="keterangan" class="form-control" rows="4" placeholder="Jelaskan aspirasi, keluhan, atau usulan Anda secara rinci, sopan, dan jelas..." required></textarea>
            </div>

            <!-- OPSI ASPIRASI RAHASIA / ANONIM -->
            <div class="mb-4 p-3 rahasia-box">
                <div class="form-check form-switch d-flex align-items-center gap-2">
                    <input class="form-check-input mt-0" type="checkbox" name="is_rahasia" id="checkRahasia" value="1" onchange="toggleAlasanRahasia(this)">
                    <label class="form-check-label fw-bold text-danger cursor-pointer mb-0" for="checkRahasia">
                        <i class="fas fa-user-secret me-1"></i> Kirim sebagai Aspirasi Rahasia (Sembunyikan Nama)
                    </label>
                </div>
                <div id="boxAlasanRahasia" class="mt-3 d-none">
                    <label class="form-label small fw-semibold text-danger">Wajib Isi Alasan Meminta Dirahasiakan <span class="text-danger">*</span></label>
                    <textarea name="alasan_rahasia" id="alasan_rahasia" class="form-control form-control-sm" rows="2" placeholder="Tuliskan alasan mengapa identitas Anda perlu disamarkan dari publik..."></textarea>
                </div>
            </div>

            <!-- Upload Lampiran -->
            <div class="mb-4">
                <label class="form-label">Lampiran Bukti Pendukung (Opsional)</label>
                <div class="file-upload-box">
                    <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                    <p class="small mb-2 fw-medium">Pilih file foto atau dokumen PDF bukti pengaduan</p>
                    <input type="file" name="foto" class="form-control form-control-sm mx-auto" style="max-width: 320px;" accept="image/*,.pdf">
                    <span class="d-block small text-muted mt-2">Format: JPG, PNG, atau PDF (Maksimal 2 MB)</span>
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" name="submit" class="btn btn-primary btn-lg rounded-pill w-100 fw-bold shadow-sm py-3">
                <i class="fas fa-paper-plane me-2"></i> Kirimkan Aspirasi Sekarang
            </button>
        </form>
    </div>
</div>

<script>
    function toggleAlasanRahasia(checkbox) {
        const box = document.getElementById('boxAlasanRahasia');
        const inputAlasan = document.getElementById('alasan_rahasia');
        if (checkbox.checked) {
            box.classList.remove('d-none');
            inputAlasan.required = true;
        } else {
            box.classList.add('d-none');
            inputAlasan.required = false;
            inputAlasan.value = '';
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>