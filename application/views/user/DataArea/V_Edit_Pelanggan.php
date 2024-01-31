<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="textmenuatas fs-4 fw-bold">Edit Customer</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" href="<?php echo base_url('user/DataArea/C_DP_Pelanggan') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header fs-5 fw-bold">
                    <i class="fas fa-table me-1"></i>
                    Data Customer
                </div>
                <div class="card-body">
                    <div class="container">

                        <?php foreach ($DataPelanggan as $data) : ?>
                            <form method="POST" action="<?php echo base_url('user/DataArea/C_Edit_Pelanggan/EditPelangganSave') ?>">

                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" class="form-control fw-bold fs-6 bg-warning" name="id" id="id" value="<?php echo $data['id'] ?>" readonly>
                                        <input type="hidden" class="form-control fw-bold fs-6 bg-warning" name="id_pppoe" id="id_pppoe" value="<?php echo $data['id_pppoe'] ?>" readonly>
                                        <input type="hidden" class="form-control fw-bold fs-6 bg-warning" name="name_pppoe_old" id="name_pppoe_old" value="<?php echo $data['name_pppoe'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="name" class="form-label fw-bold fs-5"> Nama Customer : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-person-bounding-box text-white"></i></span>
                                            <input type="text" class="form-control fw-bold fs-6" name="" id="" value="<?php echo $data['name'] ?>" placeholder="Masukkan Nama Customer..." readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="start_date" class="form-label fw-bold fs-5"> Tanggal Registrasi : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-calendar-check-fill text-white"></i></span>
                                            <input type="date" class="form-control fw-bold fs-6" name="" id="" value="<?php echo $data['start_date'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="code_client" class="form-label fw-bold fs-5"> Kode Customer : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                            <input type="text" class="form-control fw-bold fs-6" name="" id="" value="<?php echo $data['code_client'] ?>" placeholder="Masukkan Kode Customer..." readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="name_pppoe" class="form-label fw-bold fs-5"> Name PPPOE : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-person-bounding-box text-white"></i></span>
                                            <input type="text" class="form-control fw-bold fs-6" name="" id="" value="<?php echo $data['name_pppoe'] ?>" placeholder="Masukkan Name PPPOE..." readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="password_pppoe" class="form-label fw-bold fs-5"> Password PPPOE : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-eye-fill text-white"></i></span>
                                            <input type="text" class="form-control fw-bold fs-6" name="" id="" value="<?php echo $data['password_pppoe'] ?>" placeholder="Masukkan Password PPPOE..." readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="phone" class="form-label fw-bold fs-5"> No. Telepon : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-telephone-fill text-white"></i></span>
                                            <input type="text" class="form-control fw-bold fs-6" name="" id="" value="<?php echo $data['phone'] ?>" placeholder="Masukkan No Telepon..." readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="phone" class="form-label fw-bold fs-5"> Paket Internet : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-wifi text-white"></i></span>
                                            <input type="text" class="form-control fw-bold fs-6" name="" id="" value="<?php echo $data['nama_paket'] ?>" placeholder="Masukkan No Telepon..." readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="id_area" class="form-label fw-bold fs-5"> Kode DP dan Area : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill  text-white"></i></span>
                                            <select id="id_area" name="id_area" class="form-control fw-bold fs-6" required>
                                                <option value="">Pilih Area :</option>
                                                <?php foreach ($DataArea as $dataArea) : ?>
                                                    <option value="<?php echo $dataArea['id'] ?>" <?= $data['id_area'] == $dataArea['id'] ? "selected" : null ?>><?php echo  $dataArea['nama_dp'] . '/' . $dataArea['name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('id_area'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="id_sales" class="form-label fw-bold fs-5"> Sales : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-person-circle  text-white"></i></span>
                                            <select id="id_sales" name="id_sales" class="form-control fw-bold fs-6" required>
                                                <option value="">Pilih Sales :</option>
                                                <?php foreach ($DataSales as $dataSales) : ?>
                                                    <option value="<?php echo $dataSales['id'] ?>" <?= $data['id_sales'] == $dataSales['id'] ? "selected" : null ?>><?php echo $dataSales['name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('id_sales'); ?></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="email" class="form-label fw-bold fs-5"> Email Customer : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-envelope-at-fill text-white"></i></span>
                                            <input type="text" class="form-control fw-bold fs-6" name="email" id="email" value="<?php echo $data['email'] ?>" placeholder="Masukkan Email Customer...">
                                        </div>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('email'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="address" class="form-label fw-bold fs-5"> Alamat Customer : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                            <textarea class="form-control fw-bold fs-6" name="address" id="address" cols="10" rows="3" placeholder="Masukkan Alamat Customer..." required><?php echo $data['address'] ?></textarea>
                                        </div>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('address'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="description" class="form-label fw-bold fs-5"> Keterangan : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                            <textarea class="form-control fw-bold fs-6" name="description" id="description" cols="10" rows="3" placeholder="Masukkan Keterangan..."><?php echo $data['description'] ?></textarea>
                                        </div>
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('description'); ?></small>
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