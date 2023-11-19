<footer class="py-4 bg-light mt-auto" id="footer">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-center small">
            <div>Copyright &copy; My Infly Networks 2022</div>
        </div>
    </div>
</footer>
</div>
</div>

<!-- JS dataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/af-2.5.1/r-2.4.0/datatables.min.js">
</script>

<!-- JS Website -->
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>

<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>vendor/SweetAlert2/sweetalert2.all.min.js"></script>

<!-- Button Pencarian -->
<script src="<?php echo base_url(); ?>assets/js/buttonPencarian.js"></script>

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/js/desaignTables.js"></script>

<!-- Alert Login -->
<script>
    <?php if ($this->session->flashdata('LoginBerhasil_icon')) { ?>
        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        toastMixin.fire({
            animation: true,
            title: '<?php echo $this->session->flashdata('LoginBerhasil_title') ?>'
        });
    <?php } ?>
</script>

<!-- Ajax Logout -->
<script>
    function LogOut() {
        Swal.fire({
            title: 'Yakin Anda Ingin Logout ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo site_url('C_FormLogin/logout') ?>";
            }
        })
    }
</script>

<!-- Alert Edit Data -->
<script>
    <?php if ($this->session->flashdata('Edit_icon')) { ?>
        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        toastMixin.fire({
            animation: true,
            title: '<?php echo $this->session->flashdata('Edit_title') ?>'
        });

    <?php } ?>
</script>

<!-- Alert Delete Data -->
<script>
    <?php if ($this->session->flashdata('Delete_icon')) { ?>
        var toastMixin = Swal.mixin({
            toast: true,
            icon: 'success',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        toastMixin.fire({
            animation: true,
            title: '<?php echo $this->session->flashdata('Delete_title') ?>'
        });

    <?php } ?>
</script>

<!-- Alert Tambah Data -->
<script>
    <?php if ($this->session->flashdata('Tambah_icon')) { ?>
        var toastMixin = Swal.mixin({
            toast: true,
            icon: '<?php echo $this->session->flashdata('Tambah_icon') ?>',
            title: 'General Title',
            animation: false,
            position: 'top-right',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        toastMixin.fire({
            animation: true,
            title: '<?php echo $this->session->flashdata('Tambah_title') ?>'
        });

    <?php } ?>
</script>

<!-- Alert Duplicate Name (Tambah Data) -->
<script>
    <?php if ($this->session->flashdata('DuplicateName_icon')) { ?>
        Swal.fire(
            "<?php echo $this->session->flashdata('DuplicateName_title') ?>",
            "<?php echo $this->session->flashdata('DuplicateName_text') ?>",
            "<?php echo $this->session->flashdata('DuplicateName_icon') ?>");
    <?php } ?>
</script>

<!-- Ajax Show Data Mikrotik -->
<script>
    $(document).ready(function() {
        $('#mytable').DataTable({
            "autoFill": true,
            "pagingType": 'numbers',
            "ajax": {
                "url": "<?= base_url('superadmin/DataMikrotik/C_DataMikrotik/GetDataAjax'); ?>",
            },
        })
    })
</script>

<!-- Delete Data Mikrotik -->
<script>
    function DeleteMikrotik(parameter_id) {
        Swal.fire({
            title: 'Yakin Melakukan Delete Data ?',
            text: "Data yang dihapus tidak akan kembali",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo site_url('superadmin/DataMikrotik/C_DeleteMikrotik/DeleteMikrotik') ?>/" + parameter_id;
            }
        })
    }
</script>

<!-- Edit Data Mikrotik -->
<script>
    function EditMikrotik(parameter_id) {
        Swal.fire({
            title: 'Yakin Melakukan Edit Data ?',
            text: "Data yang diedit tidak akan kembali",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Edit Data!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo site_url('superadmin/DataMikrotik/C_EditMikrotik/EditMikrotik') ?>/" + parameter_id;
            }
        })
    }
</script>

<!-- Enable Mikrotik -->
<script>
    function EnableMikrotik(parameter_id) {
        Swal.fire({
            title: 'Yakin Melakukan Enable ?',
            text: "Data yang dienable, maka akan aktif",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Enable!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo site_url('superadmin/DataMikrotik/C_EnableMikrotik/EnableMikrotik') ?>/" + parameter_id;
            }
        })
    }
</script>

<!-- Disable Mikrotik -->
<script>
    function DisableMikrotik(parameter_id) {
        Swal.fire({
            title: 'Yakin Melakukan Disable ?',
            text: "Data yang disable, maka akan tidak aktif",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Disable!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?php echo site_url('superadmin/DataMikrotik/C_DisableMikrotik/DisableMikrotik') ?>/" + parameter_id;
            }
        })
    }
</script>

</body>

</html>