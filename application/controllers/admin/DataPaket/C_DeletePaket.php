<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DeletePaket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('email') == null) {

            // Notifikasi Login Terlebih Dahulu
            $this->session->set_flashdata('BelumLogin_icon', 'error');
            $this->session->set_flashdata('BelumLogin_title', 'Login Terlebih Dahulu');

            redirect('C_FormLogin');
        }
    }

    public function DeletePaket($id_paket)
    {
        // Kondisi delete menggunakan id_paket
        $idPaket = array(
            'id'       => $id_paket
        );

        $this->M_CRUD->deleteData($idPaket, 'paket');

        // Notifikasi Delete Berhasil
        $this->session->set_flashdata('Delete_icon', 'success');
        $this->session->set_flashdata('Delete_title', 'Delete Data Berhasil');

        redirect('admin/DataPaket/C_DataPaket');
    }
}
