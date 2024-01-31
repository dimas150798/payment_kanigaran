<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DashboardUser extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('email') == null) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>Login Terlebih Dahulu</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('C_FormLogin');
        }
    }

    public function index()
    {
        // Notifikasi Login Berhasil
        $this->session->set_flashdata('LoginBerhasil_icon', 'success');
        $this->session->set_flashdata('LoginBerhasil_title', 'Selamat Datang <br>' . $this->session->userdata('email'));

        $this->load->view('template/user/V_Header');
        $this->load->view('template/user/V_Sidebar');
        $this->load->view('user/V_DashboardUser');
        $this->load->view('template/user/V_Footer');
    }
}
