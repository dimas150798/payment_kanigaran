<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Edit Akun</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" href="<?php echo base_url('superadmin/DataAkun/C_DataAkun') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Akun
                </div>
                <div class="card-body">
                    <div class="container">
                        <?php foreach ($DataAkun as $data) : ?>
                            <form method="POST" action="<?php echo base_url('superadmin/DataAkun/C_EditAkun/EditAkunSave') ?>">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id_login" id="id_login" value="<?php echo $data['id_login'] ?>" readonly>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-4">
                                        <label for="email_login" class="form-label" style="font-weight: bold;"> Email : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="email_login" id="email_login" value="<?php echo $data['email_login'] ?>" placeholder="Masukkan email...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('email_login'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="password_login" class="form-label" style="font-weight: bold;"> Password : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="password_login" id="password_login" value="<?php echo $data['password_login'] ?>" placeholder="Masukkan password...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('password_login'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="id_akses" class="form-label" style="font-weight: bold;"> Nama Akses : <span class="text-danger">*</span></label>
                                        <select id="id_akses" name="id_akses" class="form-control" required>
                                            <option value="">Pilih Akses :</option>
                                            <?php foreach ($DataAkses as $dataAkses) : ?>
                                                <option value="<?php echo $dataAkses['id_akses'] ?>" <?= $data['id_akses'] == $dataAkses['id_akses'] ? "selected" : null ?>>
                                                    <?php echo $dataAkses['nama_akses'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('id_akses'); ?></small>
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