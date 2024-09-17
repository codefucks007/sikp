<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <!-- Main Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?></h6>
            <div>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#filterModal">Filter</button>
                <?php if ($this->session->flashdata('filter_applied')) : ?>
                    <a href="<?= base_url('petugas/clearfilter'); ?>" class="btn btn-warning">Clear Filter</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NRP</th>
                            <th>Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th>Jenis Kegiatan</th>
                            <th>Nama Kegiatan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kegiatan as $k) : ?>
                            <tr>
                                <td><?= $k['nrp']; ?></td>
                                <td><?= $k['nama']; ?></td>
                                <td><?= $k['program_studi']; ?></td>
                                <td><?= $k['jeniskegiatan']; ?></td>
                                <td><?= $k['nama_kegiatan']; ?></td>
                                <td>
                                    <?php
                                    switch ($k['id_status']) {
                                        case 1:
                                            echo '<span class="badge badge-secondary">Belum Diperiksa</span>';
                                            break;
                                        case 2:
                                            echo '<span class="badge badge-success">Valid</span>';
                                            break;
                                        case 3:
                                            echo '<span class="badge badge-danger">Tidak Valid</span>';
                                            break;
                                        default:
                                            echo '<span class="badge badge-secondary">Unknown</span>';
                                            break;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($k['id_status'] == 1 || $k['id_status'] == 4) : ?>
                                        <a href="<?= base_url('petugas/validasikegiatan/' . $k['id_kegiatan']); ?>" class="btn btn-info btn-sm">Validasi</a>
                                    <?php else : ?>
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailKegiatanModal" data-nrp="<?= $k['nrp']; ?>" data-nama="<?= $k['nama']; ?>" data-program_studi="<?= $k['program_studi']; ?>" data-nama_kegiatan="<?= $k['nama_kegiatan']; ?>" data-jeniskegiatan="<?= $k['jeniskegiatan']; ?>" data-bidang="<?= $k['nama_bidang']; ?>" data-waktu_pelaksanaan="<?= $k['waktu_pelaksanaan']; ?>" data-sifat="<?= $k['sifat']; ?>" data-partisipasi="<?= $k['partisipasi']; ?>" data-level="<?= $k['level']; ?>" data-bobot="<?= $k['bobot']; ?>" data-filebukti="<?= $k['filebukti']; ?>" data-status="<?= $k['id_status']; ?>" data-catatan_petugas="<?= $k['catatan']; ?>">
                                            Detail
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('petugas/daftarkegiatanmhs'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="program_studi">Program Studi</label>
                        <select class="form-control" id="program_studi" name="program_studi">
                            <option value="">Pilih Program Studi</option>
                            <?php foreach ($program_studi as $ps) : ?>
                                <option value="<?= $ps['id']; ?>" <?= set_select('program_studi', $ps['id']); ?>>
                                    <?= $ps['program_studi']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kegiatan">Jenis Kegiatan</label>
                        <select class="form-control" id="jeniskegiatan" name="jeniskegiatan">
                            <option value="">Pilih Jenis Kegiatan</option>
                            <?php foreach ($jeniskegiatan as $jk) : ?>
                                <option value="<?= $jk['id']; ?>" <?= set_select('jeniskegiatan', $jk['id']); ?>>
                                    <?= $jk['jeniskegiatan']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Pilih Status</option>
                            <?php foreach ($statuses as $st) : ?>
                                <option value="<?= $st['id']; ?>" <?= set_select('status', $st['id']); ?>>
                                    <?= $st['status']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Detail Kegiatan Modal -->
<div class="modal fade" id="detailKegiatanModal" tabindex="-1" role="dialog" aria-labelledby="detailKegiatanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKegiatanModalLabel">Detail Kegiatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NRP</label>
                                <input type="text" id="detail_nrp" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Mahasiswa</label>
                                <input type="text" id="detail_nama" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Program Studi</label>
                                <input type="text" id="detail_program_studi" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama Kegiatan</label>
                                <input type="text" id="detail_nama_kegiatan" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kegiatan</label>
                                <input type="text" id="detail_jenis_kegiatan" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Bidang</label>
                                <input type="text" id="detail_bidang" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Waktu Pelaksanaan</label>
                                <input type="text" id="detail_waktu_pelaksanaan" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sifat</label>
                                <input type="text" id="detail_sifat" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Partisipasi</label>
                                <input type="text" id="detail_partisipasi" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Level</label>
                                <input type="text" id="detail_level" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Bobot</label>
                                <input type="text" id="detail_bobot" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>File Bukti</label>
                                <div class="d-flex align-items-center">
                                    <p class="mb-0 mr-2"><a href="<?= base_url('./assets/filebukti/' . $k['filebukti']); ?>" target="_blank"><?= $k['filebukti']; ?></a></p>
                                    <a href="<?= base_url('./assets/filebukti/' . $k['filebukti']); ?>" target="_blank">
                                        <i class="far fa-file-pdf"></i> <!-- Ikon untuk file PDF -->
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <div id="detail_status_badge"></div>
                            </div>
                            <div class="form-group">
                                <label>Catatan Petugas</label>
                                <textarea id="detail_catatan_petugas" class="form-control" rows="4" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>