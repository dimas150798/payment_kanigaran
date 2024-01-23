<?php
$months = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');

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
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="fw-bold fs-5">Data Customer</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn btn-success fw-bold" href="<?php echo base_url('admin/DataPelanggan/C_TambahPelanggan') ?>"> Tambah Pelanggan
                    </a>
                    <!-- <a class="btn buttonmenuatas" href="<?php echo base_url('admin/DataPelanggan/C_ImportExcel') ?>"> Import Excel
                    </a> -->
                    <a class="btn btn-warning fw-bold" href="<?php echo base_url('admin/DataPelanggan/C_ExportExcel') ?>"> Export Excel
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-12 mt-3">
                    <div class="textPencarian">
                        <div class="row">
                            <div class="col-6">
                                <p class="fw-bold fs-5">Total Customer</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-bold fs-5">:
                                    <?php echo $JumlahPelanggan; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h5 class="text-center font-weight-light mt-2 mb-2">
                        <?php echo $this->session->flashdata('pesan'); ?>
                    </h5>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header fw-bold fs-5">
                            <i class="fas fa-table me-1"></i>
                            Data Pelanggan
                        </div>
                        <div class="card-body">
                            <table id="mytable" class="table table-bordered responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Nama Customer</th>
                                        <th width="15%">Name PPPOE</th>
                                        <th class="text-center" width="15%">Phone</th>
                                        <th class="text-center" width="10%">Nama Paket</th>
                                        <th class="text-center" width="10%">Date Registrasi</th>
                                        <th class="text-center" width="15%">sales</th>
                                        <th class="text-center" width="10%">Kode DP</th>
                                        <th class="text-center" width="10%">Status</th>
                                        <th class="text-center" width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </main>