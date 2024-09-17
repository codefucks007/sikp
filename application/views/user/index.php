<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Diri</h5>
            <a href="<?= base_url('user/edit'); ?>" class="btn btn-primary">Edit Data Diri</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">NRP</dt>
                        <dd class="col-sm-8">: <?= $user['nrp']; ?></dd>

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
                        <dt class="col-sm-4">Program Studi</dt>
                        <dd class="col-sm-8">: <?= $user['program_studi']; ?></dd>

                        <dt class="col-sm-4">Angkatan</dt>
                        <dd class="col-sm-8">: <?= $user['angkatan']; ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Kredit Poin Kegiatan</h5>
            <a href="<?= base_url('data_kegiatan'); ?>" class="btn btn-primary">Lihat Daftar Kegiatan</a>
        </div>
        <div class="card-body">
            <div class="row text-center credit-status">
                <div class="col-md-3 mb-4">
                    <p>Belum Diperiksa / Total Kegiatan</p>
                    <p class="font-weight-bold"><?= $belum_diperiksa_count; ?>/ <?= $total_kegiatan_count; ?></p>
                </div>
                <div class="col-md-3 mb-4">
                    <p>Valid / Total Kegiatan</p>
                    <p class="font-weight-bold"><?= $valid_count; ?> / <?= $total_kegiatan_count; ?></p>
                </div>
                <div class="col-md-3 mb-4">
                    <p>Tidak Valid / Total Kegiatan</p>
                    <p class="font-weight-bold"><?= $tidak_valid_count; ?>/ <?= $total_kegiatan_count; ?></p>
                </div>
                <div class="col-md-3 mb-4">
                    <p>Kegiatan Wajib Diikuti</p>
                    <p class="font-weight-bold"><?= $wajib_count; ?> / 2</p>
                </div>
                <div class="col-md-12 mb-4 text-center">
                    <hr>
                    <p>Total Poin / Beban Poin</p>
                    <p class="font-weight-bold"><?= $data['total_poin']; ?> / <?= $data['bobot_user']; ?></p>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->