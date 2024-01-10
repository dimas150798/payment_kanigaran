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
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="fw-bold fs-4">Belum Lunas</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <a class="btn btn-warning fw-bold" href="<?php echo base_url('admin/BelumLunas/C_ExportExcel') ?>"> Export Excel
                                </a>
                            </div>
                            <div class="col-6">
                                <select name="forma" id='SelectOption' class="form-control">
                                    <option value="monthly"><a href="#">Monthly</a></option>
                                    <option value="day"><a href="#">Day</a></option>
                                    <option value="custom_date"><a href="#">Custom Date</a></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row mt-3 mb-2">
                <form class="form-inline" action="<?php echo base_url('admin/BelumLunas/C_BelumLunas') ?>" method=" get">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="tahun" class="fw-bold fs-5 mt-2 mb-2">Tahun : </label>
                            <select class="form-control text-center fw-bold fs-6" name="tahun" required>
                                <?php
                                $selectedYear = $this->session->userdata('tahunGET') ?: $this->session->userdata('tahun');

                                echo '<option value="" disabled>-- Pilih Tahun --</option>';

                                for ($i = 2022; $i <= 2025; $i++) {
                                    $selected = ($selectedYear == $i) ? 'selected' : '';
                                    echo '<option ' . $selected . ' value=' . $i . '>' . date("Y", mktime(0, 0, 0, 1, 1, $i)) . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="bulan" class="fw-bold fs-5 mt-2 mb-2">Bulan : </label>
                            <select class="form-control text-center fw-bold fs-6" name="bulan" required>
                                <?php
                                $selectedMonth = $this->session->userdata('bulanGET') ?: $this->session->userdata('bulan');

                                echo '<option value="" disabled>-- Pilih Bulan --</option>';

                                for ($m = 1; $m <= 12; ++$m) {
                                    $selected = ($selectedMonth == $m) ? 'selected' : '';
                                    echo '<option ' . $selected . ' value=' . $m . '>' . date('F', mktime(0, 0, 0, $m, 1)) . '</option>';
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
                                <p class="fw-bold fs-5">Data</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-bold fs-5">:
                                    <?php
                                    echo $months[$bulan] . ' / ' . $tahun;
                                    ?>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="fw-bold fs-5">Belum Lunas</p>
                            </div>
                            <div class="col-6">
                                <p class="fw-bold fs-5">:
                                    <?php echo $JumlahBelumLunas; ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="fw-bold fs-5">Nominal</p>
                            </div>
                            <div class="col-6">

                                <p class="fw-bold fs-5">: Rp.
                                    <?php echo number_format($NominalBelumLunas, 0, ',', '.') ?></p>
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
                            <h3><i class="fas fa-table me-1"></i>
                                Data Pelanggan
                            </h3>
                        </div>
                        <div class="card-body">
                            <table id="mytable" class="table table-bordered responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="5%" class="text-center">Tanggal</th>
                                        <th width="20%">Nama PPPOE</th>
                                        <th width="20%">Nama Customer</th>
                                        <th width="10%" class="text-center">Paket</th>
                                        <th width="10%" class="text-center">Tarif</th>
                                        <th width="10%" class="text-center">Status</th>
                                        <th width="5%" class="text-center">Opsi</th>
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