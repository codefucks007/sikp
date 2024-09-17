<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $data['title']; ?></h1>
    <div class="row">
        <div class="col-lg-8">
            <form action="<?= base_url('data_kegiatan/edit/' . $data['kegiatan']['id_kegiatan']); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="<?= $data['kegiatan']['nama_kegiatan']; ?>">
                    <?= form_error('nama_kegiatan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="waktu_pelaksanaan">Waktu Pelaksanaan</label>
                    <input type="date" class="form-control" id="waktu_pelaksanaan" name="waktu_pelaksanaan" value="<?= $data['kegiatan']['waktu_pelaksanaan']; ?>">
                    <?= form_error('waktu_pelaksanaan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_jeniskegiatan">Jenis Kegiatan</label>
                    <select class="form-control" id="id_jeniskegiatan" name="id_jeniskegiatan">
                        <?php foreach ($data['jeniskegiatan'] as $jk) : ?>
                            <option value="<?= $jk['id']; ?>" <?= $jk['id'] == $data['kegiatan']['id_jeniskegiatan'] ? 'selected' : ''; ?>><?= $jk['jeniskegiatan']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_jeniskegiatan', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_bidang">Bidang</label>
                    <select class="form-control" id="id_bidang" name="id_bidang">
                        <?php foreach ($data['bidang'] as $b) : ?>
                            <option value="<?= $b['id']; ?>" <?= $b['id'] == $data['kegiatan']['id_bidang'] ? 'selected' : ''; ?>><?= $b['nama_bidang']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_bidang', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_sifat">Sifat</label>
                    <select class="form-control" id="id_sifat" name="id_sifat">
                        <?php foreach ($data['sifat'] as $sf) : ?>
                            <option value="<?= $sf['id']; ?>" <?= $sf['id'] == $data['kegiatan']['id_sifat'] ? 'selected' : ''; ?>><?= $sf['sifat']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_sifat', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_partisipasi">Partisipasi</label>
                    <select class="form-control" id="id_partisipasi" name="id_partisipasi">
                        <?php foreach ($data['partisipasi'] as $p) : ?>
                            <option value="<?= $p['id']; ?>" <?= $p['id'] == $data['kegiatan']['id_partisipasi'] ? 'selected' : ''; ?>><?= $p['partisipasi']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_partisipasi', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="id_level">Level</label>
                    <select class="form-control" id="id_level" name="id_level">
                        <?php foreach ($data['level'] as $l) : ?>
                            <option value="<?= $l['id']; ?>" <?= $l['id'] == $data['kegiatan']['id_level'] ? 'selected' : ''; ?>><?= $l['level']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= form_error('id_level', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="filebukti">File Bukti</label>
                    <?php if ($data['kegiatan']['filebukti']) : ?>
                        <p>
                            File saat ini:
                            <a href="<?= base_url('assets/filebukti/' . $data['kegiatan']['filebukti']); ?>" target="_blank">
                                <?= $data['kegiatan']['filebukti']; ?>
                                <i class="far fa-file-pdf"></i> <!-- Ikon untuk file PDF -->
                            </a>
                        </p>
                    <?php endif; ?>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="filebukti" name="filebukti">
                        <label class="custom-file-label" for="filebukti">Pilih file</label>
                        <?= form_error('filebukti', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Kegiatan</button>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->