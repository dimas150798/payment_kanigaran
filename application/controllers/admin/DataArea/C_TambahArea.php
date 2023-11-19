<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahArea extends CI_Controller
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

    public function index()
    {
        //memanggil mysql dari model 
        $data['DataArea']      = $this->M_Area->DataArea();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataArea/V_TambahArea', $data);
        $this->load->view('template/V_FooterArea', $data);
    }

    public function TambahAreaSave()
    {
        //mengambil data post pada view 
        $name       = $this->input->post('name');

        //menyimpan data ke dalam array
        $dataArea   = array(
            'name'         => $name,
            'created_at'   => date('Y-m-d H:i:s', time())
        );

        //memanggil mysql dari model 
        $data['DataArea']       = $this->M_Area->DataArea();
        $checkDuplicate         = $this->M_Area->CheckDuplicateArea($name);

        // Rules form Validation
        $this->form_validation->set_rules('name', 'Nama Area', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataArea/V_TambahArea', $data);
            $this->load->view('template/V_FooterArea', $data);
        } else {
            if ($name == $checkDuplicate->name) {

                // Notifikasi Duplicate Name 
                $this->session->set_flashdata('DuplicateName_icon', 'error');
                $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Area');
                $this->session->set_flashdata('DuplicateName_text', 'Nama area sudah ada');

                redirect('admin/DataArea/C_TambahArea');
            } else {
                $this->M_CRUD->insertData($dataArea, 'area');

                // Notifikasi Tambah Berhasil
                $this->session->set_flashdata('Tambah_icon', 'success');
                $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                redirect('admin/DataArea/C_DataArea');
            }
        }
    }
}
