<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" id="sidebarLogo" href="#" style="font-size: 18px;">
            <img src="<?php echo base_url(); ?>assets/img/logoSaja.png" alt="" height="40px"> <b>My Infly Networks</b></a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-6 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <!-- <li><a class="dropdown-item" href="#!">Akun</a></li> -->
                    <!-- <li>
                        <hr class="dropdown-divider" />
                    </li> -->
                    <li><a onclick="LogOut()" class="dropdown-item" href="#">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <!-- Dashboard Menu -->
                        <div class="sb-sidenav-menu-heading">Home page</div>
                        <a class="nav-link" href="<?php echo base_url('admin/C_DashboardAdmin') ?>">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/houses.svg" alt="Bootstrap" ...></div>
                            Dashboard
                        </a>

                        <!-- Customer Menu -->
                        <div class="sb-sidenav-menu-heading">Customer</div>

                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#dataCustomer" aria-expanded="false" aria-controls="dataCustomer">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/people-fill.svg" alt="Bootstrap" ...></div>
                            Customer
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="dataCustomer" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url('admin/DataPelanggan/C_DataPelanggan') ?>">
                                    <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/people-fill.svg" alt="Bootstrap" ...></div>
                                    Data Pelanggan
                                </a>
                                <a class="nav-link" href="<?php echo base_url('admin/TerminasiPelanggan/C_TerminasiPelanggan') ?>">
                                    <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/wifi-off.svg" alt="Bootstrap" ...></div>
                                    Pelanggan Terminasi
                                </a>

                            </nav>
                        </div>

                        <!-- Pembayaran Menu -->
                        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/cash-stack.svg" alt="Bootstrap" ...></div>
                            Pembayaran
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="<?php echo base_url('admin/SudahLunas/C_SudahLunas') ?>">
                                    <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/check-all.svg" alt="Bootstrap" ...></div>
                                    Sudah Lunas
                                </a>
                                <a class="nav-link" href="<?php echo base_url('admin/BelumLunas/C_BelumLunas') ?>">
                                    <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/hourglass.svg" alt="Bootstrap" ...></div>
                                    Belum Lunas
                                </a>
                                <a class="nav-link" href="<?php echo base_url('admin/JatuhTempo/C_DataJatuhTempo') ?>">
                                    <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/calendar-check-fill.svg" alt="Bootstrap" ...></div>
                                    Jatuh Tempo
                                </a>
                            </nav>
                        </div>


                        <div class="sb-sidenav-menu-heading">Data Master</div>
                        <!-- Paket Menu -->
                        <a class="nav-link" href="<?php echo base_url('admin/DataPaket/C_DataPaket') ?>">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/router.svg" alt="Bootstrap" ...></div>
                            Paket Internet
                        </a>
                        <!-- DP dan Area Menu -->
                        <a class="nav-link" href="<?php echo base_url('admin/DataArea/C_DataArea') ?>">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/globe.svg" alt="Bootstrap" ...></div>
                            DP Dan Area
                        </a>
                        <!-- Sales Menu -->
                        <a class="nav-link" href="<?php echo base_url('admin/DataSales/C_DataSales') ?>">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/people-fill.svg" alt="Bootstrap" ...></div>
                            Sales
                        </a>
                        <!-- Logout Menu -->
                        <a onclick="LogOut()" class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/box-arrow-right.svg" alt="Bootstrap" ...></div>
                            Log Out
                        </a>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="text-warning"><img src="<?php echo base_url(); ?>assets/img/welcomeCustomer.gif" alt="" width="30px"> Selamat Datang</div>
                    <div class="small">
                        <?php echo $this->session->userdata('email'); ?>
                    </div>

                </div>
            </nav>
        </div>