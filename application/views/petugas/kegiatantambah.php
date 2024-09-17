<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <!-- Button to trigger Add Kegiatan Modal -->
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addKegiatanModal">
                Add New Kegiatan
            </button>
            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Kegiatan</th>
                        <th scope="col">Waktu Pelaksanaan</th>
                        <th scope="col">Jenis Kegiatan</th>
                        <th scope="col">Bidang</th>
                        <th scope="col">Level</th>
                        <th scope="col">Sifat</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($kegiatantambah as $k) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $k['nama_kegiatantambah']; ?></td>
                            <td><?= $k['waktu']; ?></td>
                            <td><?= $k['jeniskegiatan']; ?></td>
                            <td><?= $k['nama_bidang']; ?></td>
                            <td><?= $k['level']; ?></td>
                            <td><?= $k['sifat']; ?></td>
                            <td>
                                <a href="" class="badge badge-success" data-toggle="modal" data-target="#editKegiatanModal<?= $k['id']; ?>">edit</a>
                                <a href="<?= base_url('petugas/deleteKegiatan/' . $k['id']); ?>" class="badge badge-danger" onclick="return confirm('Are you sure you want to delete this kegiatan?');">delete</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End of Main Content -->
</div>
<!-- Modal for Add Kegiatan -->
<div class="modal fade" id="addKegiatanModal" tabindex="-1" aria-labelledby="addKegiatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKegiatanModalLabel">Add New Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('petugas/kegiatantambah'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kegiatantambah">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="nama_kegiatantambah" name="nama_kegiatantambah" placeholder="Nama Kegiatan">
                        <?= form_error('nama_kegiatantambah', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="waktu">Waktu Pelaksanaan</label>
                        <input type="date" class="form-control" id="waktu" name="waktu" placeholder="Waktu Pelaksanaan">
                        <?= form_error('waktu', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="id_jeniskegiatan">Jenis Kegiatan</label>
                        <select class="form-control" id="id_jeniskegiatan" name="id_jeniskegiatan">
                            <?php foreach ($jeniskegiatan as $jk) : ?>
                                <option value="<?= $jk['id']; ?>"><?= $jk['jeniskegiatan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_jeniskegiatan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="id_bidang">Bidang</label>
                        <select class="form-control" id="id_bidang" name="id_bidang">
                            <?php foreach ($bidang as $b) : ?>
                                <option value="<?= $b['id']; ?>"><?= $b['nama_bidang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_bidang', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="id_level">Level</label>
                        <select class="form-control" id="id_level" name="id_level">
                            <?php foreach ($level as $l) : ?>
                                <option value="<?= $l['id']; ?>"><?= $l['level']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_sifat', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="id_sifat">Sifat</label>
                        <select class="form-control" id="id_sifat" name="id_sifat">
                            <?php foreach ($sifat as $s) : ?>
                                <option value="<?= $s['id']; ?>"><?= $s['sifat']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_sifat', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal for Edit Kegiatan -->
<?php foreach ($kegiatantambah as $k) : ?>
    <div class="modal fade" id="editKegiatanModal<?= $k['id']; ?>" tabindex="-1" aria-labelledby="editKegiatanModalLabel<?= $k['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKegiatanModalLabel<?= $k['id']; ?>">Edit Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('petugas/editKegiatan'); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $k['id']; ?>">
                        <div class="form-group">
                            <label for="nama_kegiatantambah">Nama Kegiatan</label>
                            <input type="text" class="form-control" id="nama_kegiatantambah" name="nama_kegiatantambah" value="<?= $k['nama_kegiatantambah']; ?>" placeholder="Nama Kegiatan">
                            <?= form_error('nama_kegiatantambah', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="waktu">Waktu Pelaksanaan</label>
                            <input type="date" class="form-control" id="waktu" name="waktu" value="<?= $k['waktu']; ?>" placeholder="Waktu Pelaksanaan">
                            <?= form_error('waktu', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="id_jeniskegiatan">Jenis Kegiatan</label>
                            <select class="form-control" id="id_jeniskegiatan" name="id_jeniskegiatan">
                                <?php foreach ($jeniskegiatan as $jk) : ?>
                                    <option value="<?= $jk['id']; ?>" <?= $jk['id'] == $k['id_jeniskegiatan'] ? 'selected' : ''; ?>><?= $jk['jeniskegiatan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_jeniskegiatan', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="id_bidang">Bidang</label>
                            <select class="form-control" id="id_bidang" name="id_bidang">
                                <?php foreach ($bidang as $b) : ?>
                                    <option value="<?= $b['id']; ?>" <?= $b['id'] == $k['id_bidang'] ? 'selected' : ''; ?>><?= $b['nama_bidang']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_bidang', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="id_level">Level</label>
                            <select class="form-control" id="id_level" name="id_level">
                                <?php foreach ($level as $l) : ?>
                                    <option value="<?= $l['id']; ?>"><?= $l['level']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_sifat', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="id_sifat">Sifat</label>
                            <select class="form-control" id="id_sifat" name="id_sifat">
                                <?php foreach ($sifat as $s) : ?>
                                    <option value="<?= $s['id']; ?>" <?= $s['id'] == $k['id_sifat'] ? 'selected' : ''; ?>><?= $s['sifat']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('id_sifat', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>