<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <!-- Button to trigger Add Bidang Modal -->
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addBidangModal">
                Add New Bidang
            </button>
            <table class="table table-hover mt-3">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Bidang</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($bidang as $b) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $b['nama_bidang']; ?></td>
                            <td>
                                <a href="" class="badge badge-success" data-toggle="modal" data-target="#editBidangModal<?= $b['id']; ?>">edit</a>
                                <a href="<?= base_url('petugas/deleteBidang/' . $b['id']); ?>" class="badge badge-danger" onclick="return confirm('Are you sure you want to delete this bidang?');">delete</a>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- End of Main Content -->
<!-- Modal for Add Bidang -->
<div class="modal fade" id="addBidangModal" tabindex="-1" aria-labelledby="addBidangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBidangModalLabel">Add New Bidang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('petugas/bidang'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_bidang">Nama Bidang</label>
                        <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" placeholder="Nama Bidang">
                        <?= form_error('nama_bidang', '<small class="text-danger pl-3">', '</small>'); ?>
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
<!-- Modal for Edit Bidang -->
<?php foreach ($bidang as $b) : ?>
    <div class="modal fade" id="editBidangModal<?= $b['id']; ?>" tabindex="-1" aria-labelledby="editBidangModalLabel<?= $b['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBidangModalLabel<?= $b['id']; ?>">Edit Bidang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('petugas/editBidang'); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $b['id']; ?>">
                        <div class="form-group">
                            <label for="nama_bidang">Nama Bidang</label>
                            <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" value="<?= $b['nama_bidang']; ?>">
                            <?= form_error('nama_bidang', '<small class="text-danger pl-3">', '</small>'); ?>
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