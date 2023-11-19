<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DeleteMikrotik extends CI_Controller
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

    public function DeleteMikrotik($id_mikrotik)
    {
        // clear session login
        $this->session->unset_userdata('LoginBerhasil_icon');

        // Kondisi delete menggunakan id_customer
        $idMikrotik = array(
            'id_mikrotik'       => $id_mikrotik
        );

        $this->M_CRUD->deleteData($idMikrotik, 'data_mikrotik');

        // Notifikasi Delete Berhasil
        $this->session->set_flashdata('Delete_icon', 'success');
        $this->session->set_flashdata('Delete_title', 'Delete Data Berhasil');

        redirect('superadmin/DataMikrotik/C_DataMikrotik');
    }
}
