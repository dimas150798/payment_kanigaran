<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahAkun extends CI_Controller
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
        $data['DataAkses']      = $this->M_AksesLogin->DataAksesLogin();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarSuperadmin', $data);
        $this->load->view('superadmin/DataAkun/V_TambahAkun', $data);
        $this->load->view('template/V_FooterAkun', $data);
    }

    public function TambahAkunSave()
    {
        //mengambil data post pada view 
        $email_login        = $this->input->post('email_login');
        $password_login     = $this->input->post('password_login');
        $id_akses           = $this->input->post('id_akses');

        //menyimpan data akun ke dalam array
        $dataAkun = array(
            'email_login'       => $email_login,
            'password_login'    => $password_login,
            'id_akses'          => $id_akses,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        //memanggil mysql dari model 
        $data['DataAkses']      = $this->M_AksesLogin->DataAksesLogin();
        $checkDuplicate         = $this->M_DataAkun->CheckDuplicateakun($email_login);

        // Rules form Validation
        $this->form_validation->set_rules('email_login', 'Email', 'required');
        $this->form_validation->set_rules('password_login', 'Password', 'required');
        $this->form_validation->set_rules('id_akses', 'id akses', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarSuperadmin', $data);
            $this->load->view('superadmin/DataAkun/V_TambahAkun', $data);
            $this->load->view('template/V_FooterAkun', $data);
        } else {
            if ($email_login == $checkDuplicate->email_login) {

                // Notifikasi Duplicate Name 
                $this->session->set_flashdata('DuplicateName_icon', 'error');
                $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Akun');
                $this->session->set_flashdata('DuplicateName_text', 'Nama akun sudah ada');

                redirect('superadmin/DataAkun/C_TambahAkun');
            } else {
                $this->M_CRUD->insertData($dataAkun, 'data_login');

                // Notifikasi Tambah Berhasil
                $this->session->set_flashdata('Tambah_icon', 'success');
                $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                redirect('superadmin/DataAkun/C_DataAkun');
            }
        }
    }
}
