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

<!-- Loading Infly -->
<script src="<?php echo base_url(); ?>assets/js/loadingInfly.js"></script>

<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/js/desaignTables.js"></script>

<!-- Date Pick -->
<script>
	document.getElementById('SelectOption').addEventListener('change', function() {
		val = $("#SelectOption").val();

		console.log(val)
		if (val === 'day') {
			window.open('<?php echo base_url('admin/BelumLunas/C_BelumLunasDate') ?>', '_self');
		}
		if (val === 'monthly') {
			window.open('<?php echo base_url('admin/BelumLunas/C_BelumLunas') ?>', '_self');
		}
		if (val === 'custom_date') {
			window.open('<?php echo base_url('admin/BelumLunas/C_BelumLunas_CustomDate') ?>', '_self');
		}
	});
</script>

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

<!-- Alert Payment -->
<script>
	<?php if ($this->session->flashdata('payment_icon')) { ?>
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
			title: '<?php echo $this->session->flashdata('payment_title') ?>'
		});

	<?php } ?>
</script>

<!-- Alert duplicate -->
<script>
	<?php if ($this->session->flashdata('DuplicatePay_icon')) { ?>
		Swal.fire("<?php echo $this->session->flashdata('DuplicatePay_title') ?>", "<?php echo $this->session->flashdata('DuplicatePay_text') ?>", "<?php echo $this->session->flashdata('DuplicatePay_icon') ?>");
	<?php } ?>
</script>

<!-- Ajax Show Data Pelanggan -->
<script>
	$(document).ready(function() {
		$('#mytable').DataTable({
			"autoFill": true,
			"pagingType": 'numbers',
			"searching": true,
			"paging": true,
			"stateSave": true,
			"ajax": {
				"url": "<?= base_url('admin/BelumLunas/C_BelumLunas/GetBelumLunas'); ?>",
			},

		})
	})
</script>

<!-- Ajax Show Data Pelanggan -->
<script>
	$(document).ready(function() {
		$('#mytableDate').DataTable({
			"autoFill": true,
			"pagingType": 'numbers',
			"searching": true,
			"paging": true,
			"stateSave": true,
			"ajax": {
				"url": "<?= base_url('admin/BelumLunas/C_BelumLunasDate/GetBelumLunas'); ?>",
			},

		})
	})
</script>

<!-- Ajax Show Data Pelanggan -->
<script>
	$(document).ready(function() {
		$('#mytableCustomDate').DataTable({
			"autoFill": true,
			"pagingType": 'numbers',
			"searching": true,
			"paging": true,
			"stateSave": true,
			"ajax": {
				"url": "<?= base_url('admin/BelumLunas/C_BelumLunas_CustomDate/GetBelumLunas'); ?>",
			},

		})
	})
</script>

<!-- Payment Pelanggan -->
<script>
	function Payment(parameter_id) {
		window.location.href = "<?php echo site_url('admin/BelumLunas/C_PayBelumLunas/Payment') ?>/" + parameter_id;
	}
</script>

<!-- Payment Bundling Pelanggan -->
<script>
	function PaymentBundling(parameter_id) {
		window.location.href = "<?php echo site_url('admin/BelumLunas/C_PayBundling/Payment') ?>/" + parameter_id;
	}
</script>

<!-- Kirim Tagihan-->
<script>
	function KirimWA(parameter_id) {
		window.location.href = "<?php echo site_url('admin/BelumLunas/C_WA_Tagihan/KirimWA') ?>/" + parameter_id;
	}
</script>

<!-- Payment Pelanggan Date-->
<script>
	function PaymentDate(parameter_id) {
		window.location.href = "<?php echo site_url('admin/BelumLunas/C_PayBelumLunasDate/Payment') ?>/" + parameter_id;
	}
</script>

<!-- Kirim Tagihan Date-->
<script>
	function KirimWADate(parameter_id) {
		window.location.href = "<?php echo site_url('admin/BelumLunas/C_WA_TagihanDate/KirimWA') ?>/" + parameter_id;
	}
</script>

</body>

</html>