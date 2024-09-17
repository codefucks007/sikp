<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Validasi Kegiatan</h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('petugas/validasi/' . $kegiatan['id_kegiatan']); ?>">
                <div class="form-group">
                    <label>NRP</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['nrp']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Mahasiswa</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['nama']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Kegiatan</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['nama_kegiatan']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Jenis Kegiatan</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['jeniskegiatan']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Bidang</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['nama_bidang']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Waktu Pelaksanaan</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['waktu_pelaksanaan']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Sifat</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['sifat']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Partisipasi</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['partisipasi']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['level']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Bobot</label>
                    <input type="text" class="form-control" value="<?= $kegiatan['bobot']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>File Bukti</label>
                    <?php if (!empty($kegiatan['filebukti'])) : ?>
                        <div class="d-flex align-items-center">
                            <p class="mb-0 mr-2"><a href="<?= base_url('./assets/filebukti/' . $kegiatan['filebukti']); ?>" target="_blank"><?= $kegiatan['filebukti']; ?></a></p>
                            <a href="<?= base_url('./assets/filebukti/' . $kegiatan['filebukti']); ?>" target="_blank">
                                <i class="far fa-file-pdf"></i> <!-- Ikon untuk file PDF -->
                            </a>
                        </div>
                    <?php else : ?>
                        <p>Belum ada file bukti</p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="" disabled selected>-- Pilih Validasi --</option>
                        <?php foreach ($statuses as $status) : ?>
                            <?php if ($status['id'] == 2 || $status['id'] == 3) : ?>
                                <option value="<?= $status['id']; ?>" <?= $status['id'] == $kegiatan['id_status'] ? 'selected' : ''; ?>>
                                    <?= $status['status']; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('status', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label>Catatan Petugas</label>
                    <textarea class="form-control" name="catatan_petugas" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Validasi</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>