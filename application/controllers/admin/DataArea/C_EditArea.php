<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_EditArea extends CI_Controller
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

    public function EditArea($id_area)
    {
        //memanggil mysql dari model 
        $data['DataArea']       = $this->M_Area->EditArea($id_area);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataArea/V_EditArea', $data);
        $this->load->view('template/V_FooterArea', $data);
    }

    public function EditAreaSave()
    {
        //mengambil data post pada view 
        $id           = $this->input->post('id');
        $name         = $this->input->post('name');

        //menyimpan data ke dalam array
        $dataArea = array(
            'id'          => $id,
            'name'        => $name,
            'updated_at'  => date('Y-m-d H:i:s', time())
        );

        $idArea = array(
            'id' => $id
        );

        //memanggil mysql dari model 
        $data['DataArea']       = $this->M_Area->EditArea($id);
        $checkDuplicate         = $this->M_Area->CheckDuplicateArea($name);

        // Rules form Validation
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataArea/V_EditArea', $data);
            $this->load->view('template/V_FooterArea', $data);
        } else {
            if ($name == $checkDuplicate->name) {

                // Notifikasi Duplicate Name 
                $this->session->set_flashdata('DuplicateName_icon', 'error');
                $this->session->set_flashdata('DuplicateName_title', 'Gagal Edit Area');
                $this->session->set_flashdata('DuplicateName_text', 'Nama area sudah ada');

                redirect('admin/DataArea/C_DataArea');
            } else {
                $this->M_CRUD->updateData('area', $dataArea, $idArea);

                // Notifikasi Edit Berhasil
                $this->session->set_flashdata('Edit_icon', 'success');
                $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

                redirect('admin/DataArea/C_DataArea');
            }
        }
    }
}
