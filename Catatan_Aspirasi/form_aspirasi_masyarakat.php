<h4 class="fw-bold text-info mb-3"><i class="fas fa-building me-2"></i>Aspirasi Masyarakat</h4>
<form action="proses_simpan_aspirasi.php?role=masyarakat" method="POST" enctype="multipart/form-data">
    <div class="mb-3"><label class="form-label fw-semibold">Nama / Instansi</label><input type="text" name="nama" class="form-control" required></div>
    <div class="mb-3"><label class="form-label fw-semibold">No. Kontak/WA</label><input type="text" name="kontak" class="form-control" required></div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Kategori</label>
        <select name="kategori" class="form-select" required>
            <option value="Lingkungan Sekitar">Lingkungan Sekitar</option>
            <option value="Kerjasama">Kerjasama</option>
        </select>
    </div>
    <div class="mb-3"><label class="form-label fw-semibold">Isi Aspirasi</label><textarea name="keterangan" class="form-control" rows="4" required></textarea></div>
    <div class="mb-4"><label class="form-label fw-semibold">Lampiran (Opsional)</label><input type="file" name="lampiran" class="form-control"></div>
    <button type="submit" class="btn btn-info text-white rounded-pill w-100 py-2"><i class="fas fa-paper-plane me-2"></i>Kirim Aspirasi</button>
</form>