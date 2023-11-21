<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="textmenuatas">Tambah Pelanggan</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" href="<?php echo base_url('admin/DataPelanggan/C_DataPelanggan') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Pelanggan
                </div>
                <div class="card-body">
                    <div class="container">

                        <form method="POST" action="<?php echo base_url('admin/DataPelanggan/C_TambahPelanggan/TambahPelangganSave') ?>">

                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="hidden" class="form-control" name="order_id" id="order_id" value="<?php echo $this->M_BelumLunas->invoice() ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 mt-3">
                                    <label for="name" class="form-label" style="font-weight: bold;"> Nama : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" value="" placeholder="Masukkan nama pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('name'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="start_date" class="form-label" style="font-weight: bold;"> Tanggal Registrasi : <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('start_date'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="code_client" class="form-label" style="font-weight: bold;"> Kode Pelanggan : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="code_client" id="code_client" value="<?php echo $this->M_Pelanggan->KodePelangganNew() ?>" placeholder="Masukkan kode pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('code_client'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2 mt-3">
                                    <label for="name_pppoe" class="form-label" style="font-weight: bold;"> Kode Name PPPOE : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kode_name" id="kode_name" value="<?php echo $this->M_Pelanggan->KodeNamePppoe() ?>" placeholder="Masukkan nama pelanggan..." readonly>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('name_pppoe'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-2 mt-3">
                                    <label for="name_pppoe" class="form-label" style="font-weight: bold;"> Name PPPOE : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name_pppoe" id="name_pppoe" value="" placeholder="Masukkan nama pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('name_pppoe'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="password_pppoe" class="form-label" style="font-weight: bold;"> Password PPPOE : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="password_pppoe" id="password_pppoe" value="" placeholder="Masukkan nama pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('password_pppoe'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="phone" class="form-label" style="font-weight: bold;"> No. Telephone : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="" placeholder="Masukkan nama pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('phone'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-2 mt-3">
                                    <label for="id_paket" class="form-label" style="font-weight: bold;"> Paket : <span class="text-danger">*</span></label>
                                    <select id="id_paket" name="id_paket" class="form-control" required>
                                        <option value="">Pilih Paket :</option>
                                        <?php foreach ($DataPaket as $dataPaket) : ?>
                                            <option value="<?php echo $dataPaket['id']; ?>">
                                                <?php echo $dataPaket['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_paket'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-2 mt-3">
                                    <label for="biaya_instalasi" class="form-label" style="font-weight: bold;"> Biaya Instalasi : <span class="text-danger">*</span></label>
                                    <select id="biaya_instalasi" name="biaya_instalasi" class="form-control" required>
                                        <option value="">--- Pilih Biaya ---</optxion>
                                        <option value="0">Rp. 0</option>
                                        <option value="100000">Rp. 100.000</option>
                                        <option value="200000">Rp. 200.000</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="id_area" class="form-label" style="font-weight: bold;"> Kode DP dan Area : <span class="text-danger">*</span></label>
                                    <select id="id_area" name="id_area" class="form-control" required>
                                        <option value="">Pilih Area :</option>
                                        <?php foreach ($DataArea as $dataArea) : ?>
                                            <option value="<?php echo $dataArea['id']; ?>">
                                                <?php echo $dataArea['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_area'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="id_sales" class="form-label" style="font-weight: bold;"> Sales : <span class="text-danger">*</span></label>
                                    <select id="id_sales" name="id_sales" class="form-control" required>
                                        <option value="">Pilih Sales :</option>
                                        <?php foreach ($DataSales as $dataSales) : ?>
                                            <option value="<?php echo $dataSales['id']; ?>">
                                                <?php echo $dataSales['name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('id_sales'); ?></small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 mt-3">
                                    <label for="email" class="form-label" style="font-weight: bold;"> Email : <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email" value="" placeholder="Masukkan email pelanggan...">
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('email'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="address" class="form-label" style="font-weight: bold;">Alamat : <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address" id="address" cols="10" rows="4"></textarea>
                                    <div class="bg-danger">
                                        <small class="text-white"><?php echo form_error('address'); ?></small>
                                    </div>
                                </div>
                                <div class="col-sm-4 mt-3">
                                    <label for="description" class="form-label" style="font-weight: bold;">Keterangan : <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="10" rows="4"></textarea>
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

                    </div>
                </div>
            </div>
        </div>

    </main>