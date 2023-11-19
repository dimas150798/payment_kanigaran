<div id="layoutSidenav_content">
    <main>

        <div class="container-fluid">
            <div class="row">
                <!-- customer new -->
                <div class="col-xl-3 col-sm-6 mt-3">
                    <div class="card bg-primary text-white mb-4">
                        <div class="row">
                            <div class="col-10">
                                <div class="card-body">Customer New</div>
                            </div>
                            <div class="col-2 d-flex align-items-end flex-column">
                                <div class="card-body"><i class="fa fa-user fa-1x" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo base_url('admin/DataPelanggan/C_DataPelanggan') ?>">
                                <h3><?php echo $JumlahPelangganBaru ?></h3>
                            </a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <!-- customer aktif -->
                <div class="col-xl-3 col-sm-6 mt-3">
                    <div class="card bg-success text-white mb-4">
                        <div class="row">
                            <div class="col-10">
                                <div class="card-body">Customer Aktif</div>
                            </div>
                            <div class="col-2 d-flex align-items-end flex-column">
                                <div class="card-body"><i class="fa fa-user fa-1x" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo base_url('admin/DataPelanggan/C_DataPelanggan') ?>">
                                <h3 id="jumlahpelanggan"><?php echo $JumlahPelanggan ?></h3>
                            </a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <!-- customer lunas -->
                <div class="col-xl-3 col-sm-6 mt-3">
                    <div class="card bg-info text-white mb-4">
                        <div class="row">
                            <div class="col-10">
                                <div class="card-body">Customer Lunas</div>
                            </div>
                            <div class="col-2 d-flex align-items-end flex-column">
                                <div class="card-body"><i class="fa fa-user fa-1x" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo base_url('admin/SudahLunas/C_SudahLunas') ?>">
                                <h3><?php echo $JumlahSudahLunas ?></h3>
                            </a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <!-- customer jatuh tempo -->
                <div class="col-xl-3 col-sm-6 mt-3">
                    <div class="card bg-danger text-white mb-4">
                        <div class="row">
                            <div class="col-10">
                                <div class="card-body">Customer Jatuh Tempo</div>
                            </div>
                            <div class="col-2 d-flex align-items-end flex-column">
                                <div class="card-body"><i class="fa fa-user fa-1x" aria-hidden="true"></i></div>
                            </div>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="<?php echo base_url('admin/JatuhTempo/C_DataJatuhTempo') ?>">
                                <h3><?php echo $JumlahJatuhTempo ?></h3>
                            </a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </main>