<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <!-- Button to trigger Add Jenis Kegiatan Modal -->
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addJenisKegiatanModal">
                Add New Jenis Kegiatan
            </button>
            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Jenis Kegiatan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($jeniskegiatan as $jk) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $jk['jeniskegiatan']; ?></td>
                            <td>
                                <a href="" class="badge badge-success" data-toggle="modal" data-target="#editJenisKegiatanModal<?= $jk['id']; ?>">edit</a>
                                <a href="<?= base_url('petugas/deleteJenisKegiatan/' . $jk['id']); ?>" class="badge badge-danger" onclick="return confirm('Are you sure you want to delete this jenis kegiatan?');">delete</a>
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
<!-- /.container-fluid -->
<!-- Modal for Add Jenis Kegiatan -->
<div class="modal fade" id="addJenisKegiatanModal" tabindex="-1" aria-labelledby="addJenisKegiatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJenisKegiatanModalLabel">Add New Jenis Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('petugas/jeniskegiatan'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jeniskegiatan">Jenis Kegiatan</label>
                        <input type="text" class="form-control" id="jeniskegiatan" name="jeniskegiatan" placeholder="Jenis Kegiatan">
                        <?= form_error('jeniskegiatan', '<small class="text-danger pl-3">', '</small>'); ?>
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
<!-- Modal for Edit Jenis Kegiatan -->
<?php foreach ($jeniskegiatan as $jk) : ?>
    <div class="modal fade" id="editJenisKegiatanModal<?= $jk['id']; ?>" tabindex="-1" aria-labelledby="editJenisKegiatanModalLabel<?= $jk['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJenisKegiatanModalLabel<?= $jk['id']; ?>">Edit Jenis Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('petugas/editJenisKegiatan'); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $jk['id']; ?>">
                        <div class="form-group">
                            <label for="jeniskegiatan">Jenis Kegiatan</label>
                            <input type="text" class="form-control" id="jeniskegiatan" name="jeniskegiatan" value="<?= $jk['jeniskegiatan']; ?>">
                            <?= form_error('jeniskegiatan', '<small class="text-danger pl-3">', '</small>'); ?>
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