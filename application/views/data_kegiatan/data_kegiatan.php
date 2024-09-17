<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $data['title']; ?></h1>
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-center w-100">Kredit Poin Kegiatan</h5>
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseCard" aria-expanded="true" aria-controls="collapseCard">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>
        <div class="collapse show" id="collapseCard">
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
    <br><br>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kegiatan</h6>
            <div>
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#filterModal">Filter</button>
                <?php if ($this->session->flashdata('filter_applied')) : ?>
                    <a href="<?= base_url('data_kegiatan/clearfilter'); ?>" class="btn btn-warning">Clear Filter</a>
                <?php endif; ?>
                <a href="<?= base_url('data_kegiatan/add'); ?>" class="btn btn-primary ml-3">Tambah Kegiatan</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Kegiatan</th>
                            <th>Bidang</th>
                            <th>Sifat</th>
                            <th>Nama Kegiatan</th>
                            <th>Waktu Pelaksanaan</th>
                            <th>Partisipasi</th>
                            <th>Level</th>
                            <th>Bobot</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($data['kegiatan'] as $kegiatan) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $kegiatan['jeniskegiatan']; ?></td>
                                <td><?= $kegiatan['nama_bidang']; ?></td>
                                <td><?= $kegiatan['sifat']; ?></td>
                                <td><?= $kegiatan['nama_kegiatan']; ?></td>
                                <td><?= $kegiatan['waktu_pelaksanaan']; ?></td>
                                <td><?= $kegiatan['partisipasi']; ?></td>
                                <td><?= $kegiatan['level']; ?></td>
                                <td><?= $kegiatan['bobot']; ?></td>
                                <td>
                                    <?php
                                    switch ($kegiatan['id_status']) {
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
                                    <?php if ($kegiatan['id_status'] == 2) : ?>
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailKegiatanModal" data-nrp="<?= $kegiatan['nrp']; ?>" data-nama="<?= $kegiatan['name']; ?>" data-program_studi="<?= $kegiatan['program_studi']; ?>" data-nama_kegiatan="<?= $kegiatan['nama_kegiatan']; ?>" data-jeniskegiatan="<?= $kegiatan['jeniskegiatan']; ?>" data-bidang="<?= $kegiatan['nama_bidang']; ?>" data-waktu_pelaksanaan="<?= $kegiatan['waktu_pelaksanaan']; ?>" data-sifat="<?= $kegiatan['sifat']; ?>" data-partisipasi="<?= $kegiatan['partisipasi']; ?>" data-level="<?= $kegiatan['level']; ?>" data-bobot="<?= $kegiatan['bobot']; ?>" data-filebukti="<?= $kegiatan['filebukti']; ?>" data-status="<?= $kegiatan['id_status']; ?>" data-catatan_petugas="<?= $kegiatan['catatan']; ?>">
                                            Detail
                                        </a>
                                    <?php elseif ($kegiatan['id_status'] == 3) : ?>
                                        <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#detailKegiatanModal" data-nrp="<?= $kegiatan['nrp']; ?>" data-nama="<?= $kegiatan['name']; ?>" data-program_studi="<?= $kegiatan['program_studi']; ?>" data-nama_kegiatan="<?= $kegiatan['nama_kegiatan']; ?>" data-jeniskegiatan="<?= $kegiatan['jeniskegiatan']; ?>" data-bidang="<?= $kegiatan['nama_bidang']; ?>" data-waktu_pelaksanaan="<?= $kegiatan['waktu_pelaksanaan']; ?>" data-sifat="<?= $kegiatan['sifat']; ?>" data-partisipasi="<?= $kegiatan['partisipasi']; ?>" data-level="<?= $kegiatan['level']; ?>" data-bobot="<?= $kegiatan['bobot']; ?>" data-filebukti="<?= $kegiatan['filebukti']; ?>" data-status="<?= $kegiatan['id_status']; ?>" data-catatan_petugas="<?= $kegiatan['catatan']; ?>">
                                            Detail
                                        </a>
                                        <a href="<?= base_url('data_kegiatan/delete/') . $kegiatan['id_kegiatan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                    <?php else : ?>
                                        <a href="<?= base_url('data_kegiatan/edit/') . $kegiatan['id_kegiatan']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="<?= base_url('data_kegiatan/delete/') . $kegiatan['id_kegiatan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Filter -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('data_kegiatan'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sifat">Sifat Kegiatan</label>
                            <select class="form-control" id="sifat" name="sifat">
                                <option value="">Pilih Sifat Kegiatan</option>
                                <?php foreach ($data['sifat'] as $sifat) : ?>
                                    <option value="<?= $sifat['id']; ?>" <?= set_select('sifat', $sifat['id']); ?>>
                                        <?= $sifat['sifat']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="level">Level Kegiatan</label>
                            <select class="form-control" id="level" name="level">
                                <option value="">Pilih Level Kegiatan</option>
                                <?php foreach ($data['level'] as $level) : ?>
                                    <option value="<?= $level['id']; ?>" <?= set_select('level', $level['id']); ?>>
                                        <?= $level['level']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="partisipasi">Partisipasi</label>
                            <select class="form-control" id="partisipasi" name="partisipasi">
                                <option value="">Pilih Partisipasi</option>
                                <?php foreach ($data['partisipasi'] as $partisipasi) : ?>
                                    <option value="<?= $partisipasi['id']; ?>" <?= set_select('partisipasi', $partisipasi['id']); ?>>
                                        <?= $partisipasi['partisipasi']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bidang">Bidang</label>
                            <select class="form-control" id="bidang" name="bidang">
                                <option value="">Pilih Bidang</option>
                                <?php foreach ($data['bidang'] as $bidang) : ?>
                                    <option value="<?= $bidang['id']; ?>" <?= set_select('bidang', $bidang['id']); ?>>
                                        <?= $bidang['nama_bidang']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Pilih Status</option>
                                <?php foreach ($data['statuses'] as $status) : ?>
                                    <option value="<?= $status['id']; ?>" <?= set_select('status', $status['id']); ?>>
                                        <?= $status['status']; ?>
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


    <!-- End Modal Filter -->

    <!-- Modal Detail Kegiatan -->
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
                                        <p class="mb-0 mr-2"><a href="<?= base_url('./assets/filebukti/' . $kegiatan['filebukti']); ?>" target="_blank"><?= $kegiatan['filebukti']; ?></a></p>
                                        <a href="<?= base_url('./assets/filebukti/' . $kegiatan['filebukti']); ?>" target="_blank">
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
    <!-- End of Modal Detail Kegiatan -->