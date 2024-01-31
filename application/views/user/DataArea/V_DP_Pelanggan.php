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
                    <img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/list.svg" alt="Bootstrap" ...> <b class="textmenuatas fw-bold fs-5">Data Customer</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <!-- <a class="btn btn-warning fw-bold" href="<?php echo base_url('admin/DataPelanggan/C_ExportExcel') ?>">Export Excel
                        </a> -->
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row mt-3 mb-2">
                <form class="form-inline" action="<?php echo base_url('user/DataArea/C_DP_Pelanggan') ?>" method=" get">
                    <div class="row">

                        <div class="col-md-4">
                            <label class="form-label fw-bold fs-5 p-2">Pilih Kode DP : <span class="text-danger">*</span></label>
                            <div class="input-group p-2">
                                <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                <select id="nama_dp" name="nama_dp" class="form-control fw-bold fs-6">
                                    <option value="">Pilih Kode DP :</option>
                                    <?php foreach ($DataArea as $dataArea) : ?>
                                        <option value="<?php echo $dataArea['name'] ?>"><?php echo $dataArea['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <!-- Tambahkan tombol Kosongkan -->
                                <!-- <button type="button" class="btn btn-secondary" onclick="clearSelection()">Kosongkan</button> -->
                            </div>
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
                            <div class="col-6 col-lg-6 mb-2">
                                <h3>Kode DP</h3>
                            </div>
                            <div class="col-6 col-lg-6">
                                <h3>: <?php if ($this->session->userdata('NamaDP_GET') != NULL) {
                                            echo $this->session->userdata('NamaDP_GET');
                                        } else {
                                            echo 'All DP';
                                        } ?></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 col-lg-6">
                                <h3>Total Customer</h3>
                            </div>
                            <div class="col-6 col-lg-6">
                                <h3>: <?php echo $JumlahPelanggan; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <h5 class="text-center font-weight-light mt-2 mb-2 fw-bold">
                        <?php echo $this->session->flashdata('pesan'); ?>
                    </h5>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header fw-bold fs-5">
                            <i class="fas fa-table me-1"></i>
                            Data Customer
                        </div>
                        <div class="card-body table-responsive">
                            <table id="mytable" class="table table-bordered responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="20%">Name PPPOE</th>
                                        <th width="20%">Nama Customer</th>
                                        <th width="10%">Nama DP & Kode DP</th>
                                        <th width="20%">Alamat</th>
                                        <th width="20%">Paket</th>
                                        <th width="5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Your table body content goes here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </main>