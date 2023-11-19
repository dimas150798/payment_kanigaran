<div id="layoutAuthentication_footer">
	<footer class="py-4 bg-dark mt-auto text-white">
		<div class="container-fluid px-4">
			<div class="d-flex align-items-center justify-content-center small">
				<div>Copyright &copy; My Infly Networks 2022 <b>V.1.1</b></div>
			</div>
		</div>
	</footer>
</div>
</div>

<!-- SweetAlert 2 -->
<script src="<?php echo base_url(); ?>vendor/SweetAlert2/sweetalert2.all.min.js"></script>

<!-- Alert Gagal -->
<script>
	<?php if ($this->session->flashdata('LoginGagal_icon')) { ?>
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
			title: '<?php echo $this->session->flashdata('LoginGagal_title') ?>',
			icon: '<?php echo $this->session->flashdata('LoginGagal_icon') ?>'
		});

	<?php } ?>
</script>

<!-- Login Terlebih Dahulu -->
<script>
	<?php if ($this->session->flashdata('BelumLogin_icon')) { ?>
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
			title: '<?php echo $this->session->flashdata('BelumLogin_title') ?>',
			icon: '<?php echo $this->session->flashdata('BelumLogin_icon') ?>'
		});

	<?php } ?>
</script>

<!-- Alert Login -->
<script>
	<?php if ($this->session->flashdata('CheckMikrotik_icon')) { ?>
		Swal.fire("<?php echo $this->session->flashdata('CheckMikrotik_title') ?>", "<?php echo $this->session->flashdata('CheckMikrotik_text') ?>", "<?php echo $this->session->flashdata('CheckMikrotik_icon') ?>");
	<?php } ?>
</script>

</body>

</html>