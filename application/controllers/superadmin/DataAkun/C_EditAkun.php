<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_EditAkun extends CI_Controller
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

    public function EditAkun($id_login)
    {
        //memanggil mysql dari model 
        $data['DataAkun']       = $this->M_DataAkun->EditAkun($id_login);
        $data['DataAkses']      = $this->M_AksesLogin->DataAksesLogin();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarSuperadmin', $data);
        $this->load->view('superadmin/DataAkun/V_EditAkun', $data);
        $this->load->view('template/V_FooterAkun', $data);
    }

    public function EditAkunSave()
    {
        //mengambil data post pada view 
        $id_login           = $this->input->post('id_login');
        $email_login        = $this->input->post('email_login');
        $password_login     = $this->input->post('password_login');
        $id_akses           = $this->input->post('id_akses');

        //menyimpan data akun ke dalam array
        $dataAkun = array(
            'email_login'       => $email_login,
            'password_login'    => $password_login,
            'id_akses'          => $id_akses,
            'updated_at'        => date('Y-m-d H:i:s', time())
        );

        $idLogin = array(
            'id_login' => $id_login
        );
        //memanggil mysql dari model 
        $data['DataAkses']      = $this->M_AksesLogin->DataAksesLogin();

        // Rules form Validation
        $this->form_validation->set_rules('email_login', 'Email', 'required');
        $this->form_validation->set_rules('password_login', 'Password', 'required');
        $this->form_validation->set_rules('id_akses', 'id akses', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarSuperadmin', $data);
            $this->load->view('superadmin/DataAkun/V_EditAkun', $data);
            $this->load->view('template/footer', $data);
        } else {
            $this->M_CRUD->updateData('data_login', $dataAkun, $idLogin);

            // Notifikasi Edit Berhasil
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            redirect('superadmin/DataAkun/C_DataAkun');
        }
    }
}
