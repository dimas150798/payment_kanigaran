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

        <div class="menuatas" id="cetakKwitansi">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-6">
                    <i class="fa fa-list"></i> <b class="textmenuatas">Kwitansi</b>
                </div>
                <div class="col-12 col-xl-auto mt-2">
                    <a class="btn bg-danger text-white" onclick="history.back()"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/backspace-fill.svg" alt="Bootstrap" ...> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4">
            <div class="card mb-3 mt-3 mx-auto">

                <div class="card-body">
                    <div class="container">
                        <?php foreach ($DataPelanggan as $data) : ?>
                            <div class="row">
                                <div class="col-12 .col-md-8">
                                    <h2 class="kwitansiJudul">INFLY NETWORKS</h2>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <p class="kwitansiAlamat">Jl. Raya Bromo No.86 A, RT 10 / RW 03, <br>
                                        Triwung Lor, Kec. Kademangan, Kota Probolinggo,
                                        Jawa Timur - 67223, Indonesia
                                    </p>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <p class="kwitansiGaris">=========================</p>
                                </div>
                                <div class="col-sm-12 mt-4">
                                    <p class="kwitansiBody">Yth Bapak / Ibu</p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody"><?php echo $data['name'] ?></p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody"><?php echo $data['phone'] ?></p>
                                </div>

                                <div class="col-sm-12 mt-4">
                                    <p class="kwitansiPembayaran">PEMBAYARAN</p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody">Transaksi : <?php echo date('d-m-Y H:i:s', strtotime($data['created_at'])); ?>
                                    </p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody">Telepon : <?php echo $data['phone'] ?></p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody">Paket : <?php echo $data['nama_paket'] ?></p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody">Harga : Rp. <?php echo number_format($data['harga_paket'], 0, ',', '.') ?></p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody">Biaya Admin : Rp. <?php echo number_format($data['biaya_admin'], 0, ',', '.') ?></p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody">Total : Rp. <?php echo number_format($data['harga_paket'] + $data['biaya_admin'], 0, ',', '.') ?> + PPN</p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody">Keterangan : <b>Sudah Lunas</b></p>
                                </div>

                                <div class="col-sm-12 mt-4">
                                    <p class="kwitansiBody">Simpan struk ini sebagai bukti telah melakukan pembayaran</p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody">Info dan Keluhan</p>
                                </div>
                                <div class="col-sm-12">
                                    <p class="kwitansiBody">WA 083-849-268-666</p>
                                </div>

                                <div class="col-sm-12 mt-4">
                                    <p class="kwitansiGaris">=========================</p>
                                </div>
                                <div class="col-sm-12">
                                    <h2 class="kwitansiPenutup">TERIMA KASIH</h2>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-12 d-flex justify-content-center">
                                    <button onclick="window.print();" type="submit" id="cetakKwitansi" class="btn btn-warning mt-2 btn-lg justify-content-end"> PRINT</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

    </main>