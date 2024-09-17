<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Diri</h5>
            <a href="<?= base_url('petugas/edit_petugas'); ?>" class="btn btn-primary">Edit Data Diri</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">NIP</dt>
                        <dd class="col-sm-8">: <?= $user['nip']; ?></dd>
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">: <?= $user['name']; ?></dd>
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">: <?= $user['email']; ?></dd>
                        <dt class="col-sm-4">No. Telp</dt>
                        <dd class="col-sm-8">: <?= $user['no_telepon']; ?></dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Jabatan</dt>
                        <dd class="col-sm-8">: <?= $data['user_role']; ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Kegiatan Mahasiswa</h5>
            <a href="<?= base_url('petugas/daftarkegiatanmhs'); ?>" class="btn btn-primary">Lihat Daftar Kegiatan</a>
        </div>
        <div class="card-body">
            <div class="row text-center credit-status">
                <div class="col-md-3 mb-3">
                    <p>Belum Diperiksa</p>
                    <span class="text-count"><?= $belum_diperiksa_count; ?></span>
                </div>
                <div class="col-md-3 mb-3">
                    <p>Valid</p>
                    <span class="text-count"><?= $valid_count; ?></span>
                </div>
                <div class="col-md-3 mb-3">
                    <p>Tidak Valid</p>
                    <span class="text-count"><?= $tidak_valid_count; ?></span>
                </div>
                <div class="col-md-3 mb-3">
                    <p>Total Kegiatan</p>
                    <span class="text-count"><?= $total_kegiatan; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->