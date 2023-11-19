<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahMikrotik extends CI_Controller
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
        // clear session login
        $this->session->unset_userdata('LoginBerhasil_icon');

        //memanggil mysql dari model 
        $data['DataMikrotik']      = $this->MikrotikModel->DataMikrotik();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarSuperadmin', $data);
        $this->load->view('superadmin/DataMikrotik/V_TambahMikrotik', $data);
        $this->load->view('template/V_FooterAkun', $data);
    }

    public function TambahMikrotikSave()
    {
        //mengambil data post pada view 
        $ip_mikrotik            = $this->input->post('ip_mikrotik');
        $username_mikrotik      = $this->input->post('username_mikrotik');
        $password_mikrotik      = $this->input->post('password_mikrotik');

        //menyimpan data akun ke dalam array
        $dataMikrotik = array(
            'ip_mikrotik'       => $ip_mikrotik,
            'username_mikrotik' => $password_mikrotik,
            'password_mikrotik' => $password_mikrotik,
            'status_mikrotik'   => 'enable',
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        //memanggil mysql dari model 
        $data['DataMikrotik']   = $this->MikrotikModel->DataMikrotik();

        $checkJumlah            = $this->MikrotikModel->jumlahMikrotik();

        // Rules form Validation
        $this->form_validation->set_rules('ip_mikrotik', 'IP Mikrotik', 'required');
        $this->form_validation->set_rules('username_mikrotik', 'Username Mikrotik', 'required');
        $this->form_validation->set_rules('password_mikrotik', 'Password Mikrotik', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarSuperadmin', $data);
            $this->load->view('superadmin/DataMikrotik/V_TambahMikrotik', $data);
            $this->load->view('template/V_FooterAkun', $data);
        } else {
            if ($checkJumlah == 1) {
                // Notifikasi Check Jumlah
                $this->session->set_flashdata('CheckJumlah_icon', 'error');
                $this->session->set_flashdata('CheckJumlah_title', 'Gagal Tambah Mikrotik');
                $this->session->set_flashdata('CheckJumlah_text', 'IP hanya boleh 1 data');

                redirect('superadmin/DataMikrotik/C_TambahMikrotik');
            } else {
                $this->M_CRUD->insertData($dataMikrotik, 'data_mikrotik');

                // Notifikasi Tambah Berhasil
                $this->session->set_flashdata('Tambah_icon', 'success');
                $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                redirect('superadmin/DataMikrotik/C_DataMikrotik');
            }
        }
    }
}
