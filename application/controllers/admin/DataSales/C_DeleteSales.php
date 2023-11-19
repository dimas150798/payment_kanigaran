<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DeleteSales extends CI_Controller
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

    public function DeleteSales($id_sales)
    {
        // Kondisi delete menggunakan id_customer
        $idSales = array(
            'id'       => $id_sales
        );

        $this->M_CRUD->deleteData($idSales, 'sales');

        // Notifikasi Delete Berhasil
        $this->session->set_flashdata('Delete_icon', 'success');
        $this->session->set_flashdata('Delete_title', 'Delete Data Berhasil');

        redirect('admin/DataSales/C_DataSales');
    }
}
