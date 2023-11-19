<body class="bg-login">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>

                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">

                                <div class="card-header">
                                    <div class="logoLogin">
                                        <img src="<?php echo base_url(); ?>assets/img/logoSaja.png" alt="" width="60px">
                                        <h3>My Infly Networks</h3>
                                        <hr>
                                        <h4><b>Kanigaran</b></h4>
                                    </div>
                                    <!-- <div class="flash-data" data-flashdata="<?php echo $this->session->flashdata('pesangagal'); ?>"></div> -->
                                    <!-- <div class="notifikasiLogin">
                                        <p><?php echo $this->session->flashdata('success'); ?></p>
                                    </div> -->
                                </div>

                                <div class="card-body">
                                    <form id="form_login" class="user" method="POST" action="<?php echo base_url('C_FormLogin'); ?>">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email_login" type="email" placeholder="Masukkan email..." />
                                            <?php echo form_error('email_login', '<div class="text-small text-danger"></div>') ?>
                                            <label for="inputEmail"><i class="bi bi-person-circle"></i> Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password_login" type="password" placeholder="Masukkan password..." />
                                            <?php echo form_error('password_login', '<div class="text-small text-danger"></div>') ?>
                                            <label for="inputPassword"><i class="bi bi-lock"></i> Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button type="submit" class="button-login mat-primary second">Sign In</button>
                                            <!-- <button class="second">Animated Toast</button> -->
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>