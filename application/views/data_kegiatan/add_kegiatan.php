<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Kegiatan</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('data_kegiatan/add'); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama_kegiatantambah">Pilih Kegiatan</label>
                    <select class="form-control select2" id="nama_kegiatantambah" name="nama_kegiatantambah">
                        <option value="" disabled selected>Pilih Kegiatan</option>
                        <?php foreach ($data['kegiatantambah'] as $kt) : ?>
                            <option value="<?= $kt['id']; ?>" data-sifat="<?= $kt['sifat']; ?>" data-nama_kegiatan="<?= $kt['nama_kegiatantambah']; ?>" data-waktu="<?= $kt['waktu']; ?>" data-jeniskegiatan="<?= $kt['jeniskegiatan']; ?>" data-bidang="<?= $kt['id_bidang']; ?>" data-level="<?= $kt['id_level']; ?>">
                                <?= $kt['nama_kegiatantambah']; ?> / <?= $kt['jeniskegiatan']; ?> / <?= $kt['waktu']; ?> / <?= $kt['sifat']; ?> / <?= $kt['level']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('nama_kegiatantambah', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" required>
                    <?= form_error('nama_kegiatan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="waktu_pelaksanaan">Waktu Pelaksanaan <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="waktu_pelaksanaan" name="waktu_pelaksanaan" required>
                    <?= form_error('waktu_pelaksanaan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_jeniskegiatan">Jenis Kegiatan <span class="text-danger">*</span></label>
                    <select class="form-control" id="id_jeniskegiatan" name="id_jeniskegiatan" required>
                        <option value="" disabled selected>-- Pilih Jenis Kegiatan --</option>
                        <?php foreach ($data['jeniskegiatan'] as $jk) : ?>
                            <option value="<?= $jk['id']; ?>"><?= $jk['jeniskegiatan']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_jeniskegiatan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_bidang">Bidang <span class="text-danger">*</span></label>
                    <select class="form-control" id="id_bidang" name="id_bidang" required>
                        <option value="" disabled selected>-- Pilih Bidang Kegiatan --</option>
                        <?php foreach ($data['bidang'] as $b) : ?>
                            <option value="<?= $b['id']; ?>"><?= $b['nama_bidang']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_bidang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_sifat">Sifat <span class="text-danger">*</span></label>
                    <select class="form-control" id="id_sifat" name="id_sifat" required>
                        <option value="" disabled selected>-- Pilih Sifat Kegiatan (Wajib/Pilihan) --</option>
                        <?php foreach ($data['sifat'] as $sf) : ?>
                            <option value="<?= $sf['id']; ?>"><?= $sf['sifat']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_sifat', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_level">Level <span class="text-danger">*</span></label>
                    <select class="form-control" id="id_level" name="id_level" required>
                        <option value="" disabled selected>-- Pilih Level Kegiatan --</option>
                        <?php foreach ($data['level'] as $l) : ?>
                            <option value="<?= $l['id']; ?>"><?= $l['level']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_level', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_partisipasi">Partisipasi <span class="text-danger">*</span></label>
                    <select class="form-control" id="id_partisipasi" name="id_partisipasi" required>
                        <option value="" disabled selected>-- Pilih Partisipasi Kegiatan --</option>
                        <?php foreach ($data['partisipasi'] as $p) : ?>
                            <option value="<?= $p['id']; ?>"><?= $p['partisipasi']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_partisipasi', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <label for="filebukti">Upload File Bukti Keikutsertaan (Sertifikat) <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="filebukti" name="filebukti" accept=".pdf" required>
                            <label class="custom-file-label" for="filebukti">Pilih file</label>
                            <small class="form-text text-muted">Maksimal ukuran file: 5MB. Format yang diterima: PDF.</small>
                            <?= form_error('filebukti', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Kegiatan</button>
            </form>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- End of Main Content -->