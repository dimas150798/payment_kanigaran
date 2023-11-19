<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DeletePelanggan extends CI_Controller
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

    public function DeletePelanggan($id_customer)
    {
        // Notifikasi Login Berhasil
        $this->session->set_flashdata('Delete_icon', 'success');
        $this->session->set_flashdata('Delete_title', 'Delete Data Berhasil');

        // Kondisi delete menggunakan id_customer
        $idCustomer = array(
            'id_customer'       => $id_customer
        );

        $this->M_CRUD->deleteData($idCustomer, 'data_customer');

        redirect('admin/DataPelanggan/C_DataPelanggan');
    }
}
