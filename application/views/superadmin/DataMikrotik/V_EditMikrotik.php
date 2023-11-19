<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Edit Mikrotik</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" href="<?php echo base_url('superadmin/DataMikrotik/C_DataMikrotik') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Mikrotik
                </div>
                <div class="card-body">
                    <div class="container">
                        <?php foreach ($DataMikrotik as $data) : ?>
                            <form method="POST" action="<?php echo base_url('superadmin/DataMikrotik/C_EditMikrotik/EditMikrotikSave') ?>">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id_mikrotik" id="id_mikrotik" value="<?php echo $data['id_mikrotik'] ?>" readonly>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-4">
                                        <label for="ip_mikrotik" class="form-label" style="font-weight: bold;"> IP Mikrotik : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="ip_mikrotik" value="<?php echo $data['ip_mikrotik'] ?>" placeholder="Masukkan ip mikrotik...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('ip_mikrotik'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="username_mikrotik" class="form-label" style="font-weight: bold;"> Username Mikrotik: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="username_mikrotik" value="<?php echo $data['username_mikrotik'] ?>" placeholder="Masukkan username...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('username_mikrotik'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="password_mikrotik" class="form-label" style="font-weight: bold;"> Password Mikrotik: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="password_mikrotik" value="<?php echo $data['password_mikrotik'] ?>" placeholder="Masukkan password...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('password_mikrotik'); ?></small>
                                        </div>
                                    </div>

                                </div>


                                <div class="row mt-3">
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success mt-2 justify-content-end"><i class="bi bi-plus-circle"></i> Simpan</button>
                                    </div>
                                </div>

                            </form>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>

    </main>