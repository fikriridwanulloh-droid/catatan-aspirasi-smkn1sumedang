<!-- Tombol Kembali (kiri atas) -->
<style>
    .btn-back-top {
        position: fixed;
        top: 75px;
        left: 30px;
        z-index: 9999;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: #FFC107;
        color: #0A2540;
        border: 2px solid #0A2540;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 13px;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
    }
    .btn-back-top:hover {
        transform: translateY(2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    body.dark-mode .btn-back-top {
        background-color: #1E1E1E;
        color: #FFC107;
        border-color: #FFC107;
    }
    @media (max-width: 600px) {
        .btn-back-top { left: 12px; padding: 6px 12px; }
    }
</style>
<a href="<?php echo isset($url_kembali) ? htmlspecialchars($url_kembali) : 'beranda.php'; ?>" class="btn-back-top" data-lang="btn_back">&larr; Kembali</a>