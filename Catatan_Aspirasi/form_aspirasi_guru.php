<h4 class="fw-bold text-success mb-3"><i class="fas fa-chalkboard-teacher me-2"></i>Aspirasi Guru</h4>
<form action="proses_simpan_aspirasi.php?role=guru" method="POST" enctype="multipart/form-data">
    <div class="mb-3"><label class="form-label fw-semibold">Nama Lengkap</label><input type="text" name="nama" class="form-control" required></div>
    <div class="mb-3"><label class="form-label fw-semibold">NIP / ID Guru</label><input type="text" name="nip" class="form-control"></div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Kategori</label>
        <select name="kategori" class="form-select" required>
            <option value="Sarana Mengajar">Sarana Mengajar</option>
            <option value="Kurikulum">Kurikulum</option>
            <option value="Lingkungan Kerja">Lingkungan Kerja</option>
        </select>
    </div>
    <div class="mb-3"><label class="form-label fw-semibold">Isi Aspirasi</label><textarea name="keterangan" class="form-control" rows="4" required></textarea></div>
    <div class="mb-4"><label class="form-label fw-semibold">Lampiran (Opsional)</label><input type="file" name="lampiran" class="form-control"></div>
    <button type="submit" class="btn btn-success rounded-pill w-100 py-2"><i class="fas fa-paper-plane me-2"></i>Kirim Aspirasi</button>
</form>