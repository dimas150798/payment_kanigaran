<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Edit Area</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" href="<?php echo base_url('admin/DataArea/C_DataArea') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Area
                </div>
                <div class="card-body">
                    <div class="container">
                        <?php foreach ($DataArea as $data) : ?>
                            <form method="POST" action="<?php echo base_url('admin/DataArea/C_EditArea/EditAreaSave') ?>">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id" value=" <?php echo $data['id'] ?>" readonly>
                                </div>
                                <div class="row mt-3 justify-content-center">
                                    <div class="col-sm-6">
                                        <label for="name" class="form-label" style="font-weight: bold;"> Nama Area : <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $data['name'] ?>" placeholder="Masukkan nama area...">
                                        <div class="bg-danger">
                                            <small class="text-white"><?php echo form_error('name'); ?></small>
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