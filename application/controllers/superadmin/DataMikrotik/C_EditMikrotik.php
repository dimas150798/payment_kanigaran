<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_EditMikrotik extends CI_Controller
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

    public function EditMikrotik($id_login)
    {
        //memanggil mysql dari model 
        $data['DataMikrotik']   = $this->MikrotikModel->EditMikrotik($id_login);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarSuperadmin', $data);
        $this->load->view('superadmin/DataMikrotik/V_EditMikrotik', $data);
        $this->load->view('template/V_FooterMikrotik', $data);
    }

    public function EditMikrotikSave()
    {
        //mengambil data post pada view 
        $id_mikrotik        = $this->input->post('id_mikrotik');
        $ip_mikrotik        = $this->input->post('ip_mikrotik');
        $username_mikrotik  = $this->input->post('username_mikrotik');
        $password_mikrotik  = $this->input->post('password_mikrotik');

        //menyimpan data akun ke dalam array
        $dataMikrotik = array(
            'ip_mikrotik'       => $ip_mikrotik,
            'username_mikrotik' => $username_mikrotik,
            'password_mikrotik' => $password_mikrotik,
            'updated_at'        => date('Y-m-d H:i:s', time())
        );

        $idMikrotik = array(
            'id_mikrotik' => $id_mikrotik
        );
        //memanggil mysql dari model 
        $data['DataAkses']      = $this->M_AksesLogin->DataAksesLogin();

        // Rules form Validation
        $this->form_validation->set_rules('ip_mikrotik', 'Ip Mikrotik', 'required');
        $this->form_validation->set_rules('username_mikrotik', 'Username Mikrotik', 'required');
        $this->form_validation->set_rules('password_mikrotik', 'Password Mikrotik', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarSuperadmin', $data);
            $this->load->view('superadmin/DataMikrotik/V_EditMikrotik', $data);
            $this->load->view('template/V_FooterMikrotik', $data);
        } else {
            $this->M_CRUD->updateData('data_mikrotik', $dataMikrotik, $idMikrotik);

            // Notifikasi Edit Berhasil
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            redirect('superadmin/DataMikrotik/C_DataMikrotik');
        }
    }
}
