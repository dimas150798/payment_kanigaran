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
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="textmenuatas">Sudah Lunas</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn buttonmenuatas" href="<?php echo base_url('admin/SudahLunas/C_ExportExcel') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/file-excel-fill.svg" alt="Bootstrap" ...> Export Excel
                    </a>
                    <a class="btn buttonmenuatas" href="<?php echo base_url('admin/SudahLunas/C_ImportExcel') ?>"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/file-excel-fill.svg" alt="Bootstrap" ...> Import Excel
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row mt-3 mb-2">
                <form class="form-inline" action="<?php echo base_url('admin/SudahLunas/C_SudahLunas') ?>" method=" get">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="tahun">Tahun : </label>
                            <select class="form-control text-center" name="tahun" required>
                                <?php
                                if ($tahunGET == NULL) {
                                    echo '<option value="" disabled selected>-- Pilih Tahun --</option>';

                                    for ($i = 2022; $i <= 2025; $i++) {
                                        if ($tahun == $i) {
                                            echo '<option selected value=' . $i . '>' . date("Y", mktime(0, 0, 0, 1, 1, $i)) . '</option>' . "\n";
                                        } else {
                                            echo '<option value=' . $i . '>' . date("Y", mktime(0, 0, 0, 1, 1, $i)) . '</option>' . "\n";
                                        }
                                    }
                                } else {
                                    echo '<option value="" disabled>-- Pilih Tahun --</option>';

                                    for ($i = 2022; $i <= 2025; $i++) {
                                        if ($tahunGET == $i) {
                                            echo '<option selected value=' . $i . '>' . date("Y", mktime(0, 0, 0, 1, 1, $i)) . '</option>' . "\n";
                                        } else {
                                            echo '<option value=' . $i . '>' . date("Y", mktime(0, 0, 0, 1, 1, $i)) . '</option>' . "\n";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="bulan">Bulan : </label>
                            <select class="form-control text-center" name="bulan" required>
                                <?php
                                if ($bulanGET == NULL) {
                                    echo '<option value="" disabled>-- Pilih Bulan --</option>';

                                    for ($m = 1; $m <= 12; ++$m) {
                                        if ($bulan == $m) {
                                            echo '<option selected value=' . $m . '>' . date('F', mktime(0, 0, 0, $m, 1)) . '</option>' . "\n";
                                        } else {
                                            echo '<option  value=' . $m . '>' . date('F', mktime(0, 0, 0, $m, 1)) . '</option>' . "\n";
                                        }
                                    }
                                } else {
                                    echo '<option value="" disabled>-- Pilih Bulan --</option>';

                                    for ($m = 1; $m <= 12; ++$m) {
                                        if ($bulanGET == $m) {
                                            echo '<option selected value=' . $m . '>' . date('F', mktime(0, 0, 0, $m, 1)) . '</option>' . "\n";
                                        } else {
                                            echo '<option  value=' . $m . '>' . date('F', mktime(0, 0, 0, $m, 1)) . '</option>' . "\n";
                                        }
                                    }
                                }

                                ?>
                            </select>
                        </div>

                        <div class="col-md-8 mt-auto justify-content-end d-flex">
                            <button type="submit" class="btn btn-info mt-2 justify-content-start"> <i class="fas fa-eye"></i>
                                Tampilkan</button>
                        </div>
                    </div>

                </form>
            </div>

            <div class="row">
                <div class="col-12 mt-3">
                    <div class="textPencarian">

                        <div class="row">
                            <div class="col-6">
                                <p class="dataPencarian">Data</p>
                            </div>
                            <div class="col-6">
                                <p class="dataPencarian">:
                                    <?php
                                    if ($tahunGET == NULL && $bulanGET == NULL) {
                                        echo $months[$bulan] . ' / ' . $tahun;
                                    } else {
                                        echo $months[$bulanGET] . ' / ' . $tahunGET;
                                    }
                                    ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="dataPencarian">Sudah Lunas</p>
                            </div>
                            <div class="col-6">
                                <p class="dataPencarian">:
                                    <?php echo $JumlahSudahLunas; ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="dataPencarian">Nominal</p>
                            </div>
                            <div class="col-6">
                                <p class="dataPencarian">: Rp.
                                    <?php echo number_format($NominalSudahLunas, 0, ',', '.') ?></p>
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
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Data Pelanggan
                        </div>
                        <div class="card-body">
                            <table id="mytable" class="table table-bordered responsive nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">Nama Customer</th>
                                        <th width="10%">Tanggal</th>
                                        <th width="10%">Nama PPPOE</th>
                                        <th width="10%">Paket</th>
                                        <th width="10%">Payment By</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">Action</th>
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