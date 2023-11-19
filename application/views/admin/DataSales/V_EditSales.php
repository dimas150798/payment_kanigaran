<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Edit Sales</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" href="<?php echo base_url('admin/DataSales/C_DataSales') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Sales
                </div>
                <div class="card-body">
                    <div class="container">
                        <?php foreach ($DataSales as $data) : ?>
                            <form method="POST" action="<?php echo base_url('admin/DataSales/C_EditSales/EditSalesSave') ?>">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id" value=" <?php echo $data['id'] ?>" readonly>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4 mt-3">
                                        <label for="name" class="form-label" style="font-weight: bold;"> Nama : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $data['name'] ?>" placeholder="Masukkan nama...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('name'); ?></small>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mt-3">
                                        <label for="phone" class="form-label" style="font-weight: bold;"> Telephone : <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="phone" id="phone" value="<?php echo $data['phone'] ?>" placeholder="Masukkan phone...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('phone'); ?></small>
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