<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="textmenuatas">Terminasi Pelanggan</b>
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

                        <?php foreach ($DataPelanggan as $data) : ?>
                            <form method="POST" action="<?php echo base_url('admin/DataPelanggan/C_TambahTerminated/TerminatedPelangganSave') ?>">

                                <div class="row">
                                    <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $data['id'] ?>" readonly>
                                    <input type="hidden" class="form-control" name="id_pppoe" id="id_pppoe" value="<?php echo $data['id_pppoe'] ?>" readonly>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4 mt-3">
                                        <label for="name" class="form-label" style="font-weight: bold;"> Nama : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $data['name'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <label for="name_pppoe" class="form-label" style="font-weight: bold;"> Name PPPOE : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_pppoe" id="name_pppoe" value="<?php echo $data['name_pppoe'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <label for="start_date" class="form-label" style="font-weight: bold;"> Tanggal Registrasi : <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $data['start_date'] ?>" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4 mt-3">
                                        <label for="nama_paket" class="form-label" style="font-weight: bold;"> Nama Paket : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_paket" value="<?php echo $data['nama_paket'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <label for="nama_sales" class="form-label" style="font-weight: bold;"> Nama Sales : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_sales" value="<?php echo $data['nama_sales'] ?>" readonly>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <label for="stop_date" class="form-label" style="font-weight: bold;"> Tanggal Terminasi : <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="stop_date" id="stop_date" value="">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('stop_date'); ?></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 mt-3">
                                        <label for="nama_paket" class="form-label" style="font-weight: bold;"> Keterangan : <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" name="keterangan" id="keterangan" placeholder="Masukkan keterangan..." rows="3"></textarea>
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