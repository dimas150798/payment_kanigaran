<?php
if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}
?>

<div id="layoutSidenav_content">
    <main>

        <div class="menuatas">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="textmenuatas">Upload Pelanggan</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-warning text-white" href="<?php echo base_url() ?>assets/export/Excel_DataPelanggan.xlsx"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/file-earmark-excel-fill.svg" alt="Bootstrap" ...> Template Excel
                    </a>
                    <a class="btn bg-danger text-white" href="<?php echo base_url('admin/DataPelanggan/C_DataPelanggan') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card mb-3 mt-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Upload Dokumen
                </div>
                <div class="card-body">
                    <div class="container">

                        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url('admin/DataPelanggan/C_ImportExcel/ImportExcel') ?>">

                            <div class="row mt-2 justify-content-center">
                                <div class="col-sm-5">
                                    <label for="nama_customer" class="form-label" style="font-weight: bold;"> Import File : <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="upload_excel" id="nama_customer" value="" required>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" name="submit" value="Submit" class="btn btn-success mt-2 justify-content-end"><i class="bi bi-plus-circle"></i> Simpan</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Riwayat Import Excel
                </div>
                <div class="card-body">
                    <table id="datatablesdekstop" class="table table-bordered" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Nama</th>
                                <th width="30%">Tanggal Import</th>
                                <th width="5%" class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($DataExcel as $data) :
                            ?>

                                <tr>
                                    <td>
                                        <?php echo $no++ ?>
                                    </td>

                                    <td>
                                        <?php echo $data['file_name'] ?>
                                    </td>


                                    <td>
                                        <?php echo changeDateFormat('d-m-Y / H:i:s', $data['created_at']) ?>
                                    </td>


                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                                                Opsi
                                            </button>
                                            <div class="dropdown-menu text-black" style="background-color:aqua;">
                                                <a class="dropdown-item text-black" href="<?php echo base_url() ?>assets/uploads/imports/<?php echo $data['file_name'] ?>"><i class=" bi bi-pencil-square"></i> Download</a>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>