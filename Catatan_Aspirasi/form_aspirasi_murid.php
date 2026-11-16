<h4 class="fw-bold text-primary mb-3"><i class="fas fa-user-graduate me-2"></i>Aspirasi Murid</h4>
<form action="proses_simpan_aspirasi.php?role=murid" method="POST" enctype="multipart/form-data">
    <div class="mb-3"><label class="form-label fw-semibold">Nama Lengkap</label><input type="text" name="nama" class="form-control" required></div>
    <div class="row">
        <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Kelas</label><input type="text" name="kelas" class="form-control" required></div>
        <div class="col-md-6 mb-3"><label class="form-label fw-semibold">Jurusan</label><input type="text" name="jurusan" class="form-control" required></div>
    </div>
    <div class="mb-3">
        <label class="form-label fw-semibold">Kategori</label>
        <select name="kategori" class="form-select" required>
            <option value="Fasilitas Kelas">Fasilitas Kelas</option>
            <option value="Kegiatan Ekstrakurikuler">Kegiatan Ekstrakurikuler</option>
            <option value="Sistem Pembelajaran">Sistem Pembelajaran</option>
            <option value="Lainnya">Lainnya</option>
        </select>
    </div>
    <div class="mb-3"><label class="form-label fw-semibold">Isi Aspirasi</label><textarea name="keterangan" class="form-control" rows="4" required></textarea></div>
    <div class="mb-4"><label class="form-label fw-semibold">Lampiran (Opsional)</label><input type="file" name="lampiran" class="form-control"></div>
    <button type="submit" class="btn btn-primary rounded-pill w-100 py-2"><i class="fas fa-paper-plane me-2"></i>Kirim Aspirasi</button>
</form>