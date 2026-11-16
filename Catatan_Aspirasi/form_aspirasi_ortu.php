<h4 class="fw-bold text-warning mb-3"><i class="fas fa-users me-2"></i>Aspirasi Orang Tua</h4>
<form action="proses_simpan_aspirasi.php?role=ortu" method="POST" enctype="multipart/form-data">
    <div class="mb-3"><label class="form-label fw-semibold">Nama Orang Tua</label><input type="text" name="nama" class="form-control" required></div>
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Nama Anak</label><input type="text" name="nama_anak" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Kelas Anak</label><input type="text" name="kelas_anak" class="form-control" required></div>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Kategori</label>
        <select name="kategori" class="form-select" required>
            <option value="Keamanan">Keamanan</option>
            <option value="Fasilitas Sekolah">Fasilitas Sekolah</option>
            <option value="Administrasi">Administrasi</option>
        </select>
    </div>
    <div class="mb-3"><label class="form-label fw-semibold">Isi Aspirasi</label><textarea name="keterangan" class="form-control" rows="4" required></textarea></div>
    <div class="mb-4"><label class="form-label fw-semibold">Lampiran (Opsional)</label><input type="file" name="lampiran" class="form-control"></div>
    <button type="submit" class="btn btn-warning text-dark rounded-pill w-100 py-2"><i class="fas fa-paper-plane me-2"></i>Kirim Aspirasi</button>
</form>