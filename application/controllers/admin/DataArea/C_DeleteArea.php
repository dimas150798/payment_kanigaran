<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DeleteArea extends CI_Controller
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

    public function DeleteArea($id_area)
    {
        // Kondisi delete menggunakan id_customer
        $idArea = array(
            'id'       => $id_area
        );

        $this->M_CRUD->deleteData($idArea, 'area');

        // Notifikasi Delete Berhasil
        $this->session->set_flashdata('Delete_icon', 'success');
        $this->session->set_flashdata('Delete_title', 'Delete Data Berhasil');

        redirect('admin/DataArea/C_DataArea');
    }
}
