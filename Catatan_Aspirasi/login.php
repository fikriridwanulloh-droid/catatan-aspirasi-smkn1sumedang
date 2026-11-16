<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}

$page_title = "Login Admin - SMKN 1 Sumedang";
$active_nav = "login";
include 'header.php';

$theme = $_SESSION['theme'] ?? 'light';
$lang  = $_SESSION['lang'] ?? 'id';
?>

<style>
    .login-card {
        background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#e2e8f0' ?>;
        border-radius: 1.5rem;
        box-shadow: 0 20px 25px -5px <?= $theme == 'dark' ? 'rgba(0,0,0,0.5)' : 'rgba(15, 23, 42, 0.08)' ?>;
    }
    .form-control {
        background-color: <?= $theme == 'dark' ? '#0f172a' : '#ffffff' ?>;
        border: 1px solid <?= $theme == 'dark' ? '#334155' : '#cbd5e1' ?>;
        color: <?= $theme == 'dark' ? '#f8fafc' : '#0f172a' ?>;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        background-color: <?= $theme == 'dark' ? '#0f172a' : '#ffffff' ?>;
        color: <?= $theme == 'dark' ? '#f8fafc' : '#0f172a' ?>;
    }
</style>

<div class="container d-flex flex-column justify-content-center align-items-center py-5 my-auto" style="min-height: 80vh;">
    <div class="col-md-5 col-lg-4">
        <div class="card login-card p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                    <i class="fas fa-user-shield fa-2x"></i>
                </div>
                <h3 class="fw-bold mb-1">Login Admin</h3>
                <p class="text-muted small mb-0">Portal Aspirasi SMKN 1 Sumedang</p>
            </div>

            <?php if (isset($_SESSION['error_login'])): ?>
                <div class="alert alert-danger rounded-3 small py-2 mb-3">
                    <i class="fas fa-exclamation-circle me-1"></i> <?= $_SESSION['error_login']; unset($_SESSION['error_login']); ?>
                </div>
            <?php endif; ?>

            <!-- Form login dengan proteksi autocomplete off -->
            <form action="proses_login.php" method="POST" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Username Admin</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" class="form-control border-start-0 ps-0" placeholder="Masukkan username..." autocomplete="off" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold small">Password</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-transparent text-muted"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Masukkan password..." autocomplete="new-password" required>
                    </div>
                </div>

                <button type="submit" name="login" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm">
                    <i class="fas fa-sign-in-alt me-2"></i> Masuk ke Dashboard
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="index.php" class="text-decoration-none small text-muted">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda Utama
                </a>
            </div>
        </div>
    </div>
</div>

<footer class="py-3 mt-auto border-top" style="background-color: <?= $theme == 'dark' ? '#1e293b' : '#ffffff' ?>;">
    <div class="container text-center text-muted small">
        &copy; <?= date('Y') ?> SMKN 1 Sumedang. Developed by <strong>Fikri Ridwanulloh</strong>.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>