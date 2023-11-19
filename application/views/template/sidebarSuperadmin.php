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
                    <!-- <li><a class="dropdown-item" href="#!">Akun</a></li>
                    <li>
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
                        <a class="nav-link" href="<?php echo base_url() ?>superadmin/C_DashboardSuperAdmin">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/houses.svg" alt="Bootstrap" ...></div>
                            Dashboard
                        </a>

                        <!-- Customer Menu -->
                        <div class="sb-sidenav-menu-heading">Data master</div>
                        <a class="nav-link" href="<?php echo base_url() ?>superadmin/DataAkun/C_DataAkun">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/people-fill.svg" alt="Bootstrap" ...></div>
                            Data Akun
                        </a>

                        <a class="nav-link" href="<?php echo base_url() ?>superadmin/DataMikrotik/C_DataMikrotik">
                            <div class="sb-nav-link-icon"><img src="<?php echo base_url(); ?>vendor/bootstrap-icons/icons/router.svg" alt="Bootstrap" ...></div>
                            Data Mikrotik
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