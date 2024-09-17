<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>



<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Pilih Kegiatan',
            allowClear: true
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#collapseCard').on('show.bs.collapse', function() {
            // Ketika card collapse ditampilkan
            $('.btn i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        });
        $('#collapseCard').on('hide.bs.collapse', function() {
            // Ketika card collapse disembunyikan
            $('.btn i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        });
    });
</script>



<!-- //mengambil kegiatantambah ke kegiatan -->
<script>
    $(document).ready(function() {
        $('#nama_kegiatantambah').change(function() {
            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: '<?= base_url('data_kegiatan/get_kegiatantambah_data'); ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            $('#nama_kegiatan').val(data.nama_kegiatantambah);
                            $("#nama_kegiatan").prop("readonly", true);
                            $('#id_sifat').val(data.id_sifat);
                            $('#id_sifat option:not(:selected)').attr('disabled', true);
                            $('#id_jeniskegiatan').val(data.id_jeniskegiatan);
                            $('#id_jeniskegiatan option:not(:selected)').attr('disabled', true);
                            $('#id_bidang').val(data.id_bidang);
                            $('#id_bidang option:not(:selected)').attr('disabled', true);
                            $('#id_level').val(data.id_level);
                            $('#id_level option:not(:selected)').attr('disabled', true);
                            $('#waktu_pelaksanaan').val(data.waktu);
                            $("#waktu_pelaksanaan").prop("readonly", true);
                        } else {
                            $('#nama_kegiatan').val('');
                            $('#id_sifat').val('');
                            $('#id_jeniskegiatan').val('');
                            $('#id_bidang').val('');
                            $('#id_level').val('');
                            $('#waktu_pelaksanaan').val('');
                        }
                    }
                });
            } else {
                $('#nama_kegiatan').val('');
                $('#id_sifat').val('');
                $('#id_jeniskegiatan').val('');
                $('#id_bidang').val('');
                $('#id_level').val('');
                $('#waktu_pelaksanaan').val('');

                // Mengatur ulang properti readonly menjadi false
                $("#nama_kegiatan").prop("readonly", false);
                $('#id_sifat option').attr('disabled', false);
                $('#id_jeniskegiatan option').attr('disabled', false);
                $('#id_bidang option').attr('disabled', false);
                $('#id_level option').attr('disabled', false);
                $("#waktu_pelaksanaan").prop("readonly", false);

                $('#nama_kegiatantambah').on('select2:unselecting', function(e) {
                    // Ketika opsi dropdown dihapus, mengatur ulang properti readonly menjadi false
                    $("#nama_kegiatan").prop("readonly", false);
                    $('#id_sifat option').attr('disabled', false);
                    $('#id_jeniskegiatan option').attr('disabled', false);
                    $('#id_bidang option').attr('disabled', false);
                    $('#id_level option').attr('disabled', false);
                    $("#waktu_pelaksanaan").prop("readonly", false);
                });
            }
        });
    });
</script>

<!-- //MODAL DETAIL KEGIATAN MHS// -->
<script>
    $('#detailKegiatanModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var nrp = button.data('nrp');
        var name = button.data('nama');
        var program_studi = button.data('program_studi');
        var nama_kegiatan = button.data('nama_kegiatan');
        var jeniskegiatan = button.data('jeniskegiatan');
        var bidang = button.data('bidang');
        var waktu_pelaksanaan = button.data('waktu_pelaksanaan');
        var sifat = button.data('sifat');
        var partisipasi = button.data('partisipasi');
        var level = button.data('level');
        var bobot = button.data('bobot');
        var filebukti = button.data('filebukti');
        var status = button.data('status');
        var catatan_petugas = button.data('catatan_petugas');

        var modal = $(this);
        modal.find('#detail_nrp').val(nrp);
        modal.find('#detail_nama').val(name);
        modal.find('#detail_program_studi').val(program_studi);
        modal.find('#detail_nama_kegiatan').val(nama_kegiatan);
        modal.find('#detail_jenis_kegiatan').val(jeniskegiatan);
        modal.find('#detail_bidang').val(bidang);
        modal.find('#detail_waktu_pelaksanaan').val(waktu_pelaksanaan);
        modal.find('#detail_sifat').val(sifat);
        modal.find('#detail_partisipasi').val(partisipasi);
        modal.find('#detail_level').val(level);
        modal.find('#detail_bobot').val(bobot);
        modal.find('#detail_filebukti_link').attr('href', '<?= base_url('./assets/filebukti/') ?>' + filebukti);
        modal.find('#detail_filebukti_icon').attr('href', '<?= base_url('./assets/filebukti/') ?>' + filebukti);
        modal.find('#detail_filebukti_icon i').addClass('far fa-file-pdf'); // Ganti dengan ikon yang sesuai untuk jenis file
        modal.find('#detail_status_badge').html(getBadge(status));
        modal.find('#detail_catatan_petugas').val(catatan_petugas);
    });

    function getBadge(status) {
        switch (status) {
            case 1:
                return '<span class="badge badge-secondary">Belum Diperiksa</span>';
            case 2:
                return '<span class="badge badge-success">Valid</span>';
            case 3:
                return '<span class="badge badge-danger">Tidak Valid</span>';
            default:
                return '<span class="badge badge-secondary">Unknown</span>';
        }
    }
</script>
<!-- //END MODAL DETAIL KEGIATAN MHS// -->
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });



    $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: "<?= base_url('admin/changeaccess'); ?>",
            type: 'post',
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
                document.location.href = "<?= base_url('admin/roleaccess/'); ?>" + roleId;
            }
        });

    });
</script>

</body>

</html>