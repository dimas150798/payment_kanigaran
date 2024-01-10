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
                    <i class="fa fa-list"></i> <b class="fw-bold fs-5">Kirim WA Lunas</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" onclick="history.back()"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="card mb-3 mt-3">
                <div class="card-header bg-primary text-white fw-bold fs-5">
                    <i class="fas fa-table me-1"></i>
                    Data Pelanggan
                </div>
                <div class="card-body">
                    <div class="container">
                        <?php foreach ($DataPelanggan as $data) : ?>
                            <form method="POST" action="<?php echo base_url('admin/SudahLunas/C_WA_Lunas/KirimWAAksi') ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" class="form-control bg-warning fw-bold" name="id" value=" <?php echo $data['id'] ?>" readonly>
                                        <input type="hidden" class="form-control bg-warning fw-bold" name="code_client" value=" <?php echo $data['code_client'] ?>" readonly>
                                        <input type="hidden" class="form-control bg-warning fw-bold" name="nama_paket" value=" <?php echo $data['nama_paket'] ?>" readonly>
                                        <input type="hidden" class="form-control bg-warning fw-bold" name="harga_paket" value=" <?php echo $data['harga_paket'] ?>" readonly>
                                        <input type="hidden" class="form-control bg-warning fw-bold" name="tanggal_transaksi" value=" <?php echo $data['tanggal'] ?>" readonly>
                                        <input type="hidden" class="form-control bg-warning fw-bold" name="tahun_transaksi" value=" <?php echo $data['tahun_transaksi']; ?>" readonly>
                                        <input type="hidden" class="form-control bg-warning fw-bold" name="biaya_admin" value=" <?php echo $data['biaya_admin']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="name" class="form-label fw-bold fs-5"> Nama Customer : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-person-bounding-box text-white"></i></span>
                                            <input type="text" class="form-control bg-warning fw-bold" name="name" value="<?php echo $data['name'] ?>" placeholder="Data Kosong" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="nama_pppoe" class="form-label fw-bold fs-5"> Name PPPOE : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-person-bounding-box text-white"></i></span>
                                            <input type="text" class="form-control bg-warning fw-bold" name="name_pppoe" value="<?php echo $data['name_pppoe'] ?>" placeholder="Data Kosong" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="code_client" class="form-label fw-bold fs-5"> Kode Customer : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-bookmarks-fill text-white"></i></span>
                                            <input type="text" class="form-control bg-warning fw-bold" name="code_client" value="<?php echo $data['code_client'] ?>" placeholder="Data Kosong" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="bulan_penagihan" class="form-label fw-bold fs-5"> Penagihan Bulan : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary text-white"><i class="bi bi-bookmarks-fill"></i></span>
                                            <input type="text" class="form-control bg-warning fw-bold" name="bulan_transaksi" value="<?php echo $months[$data['bulan_transaksi']] ?>" placeholder="Data Kosong" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="phone" class="form-label fw-bold fs-5"> No. Telepon: <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary text-white"><i class="bi bi-telephone-fill"></i></span>
                                            <input type="text" class="form-control bg-warning fw-bold" name="phone" value="<?php echo $data['phone'] ?>" placeholder="Data Kosong" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-4">
                                        <label for="" class="form-label fw-bold fs-5"> Paket Internet : <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-secondary"><i class="bi bi-wifi text-white"></i></span>
                                            <input type="text" class="form-control bg-warning fw-bold" name="" value="<?php echo $data['nama_paket'] ?> / Rp.  <?php echo number_format($data['harga_paket'], 0, ',', '.') ?>" placeholder="Data Kosong" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success mt-2 justify-content-end"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/whatsapp.svg" alt="Bootstrap" ...> Kirim</button>
                                    </div>
                                </div>

                            </form>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>

    </main>