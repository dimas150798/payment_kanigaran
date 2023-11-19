<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_EditSales extends CI_Controller
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

    public function EditSales($id_sales)
    {
        //memanggil mysql dari model 
        $data['DataSales']      = $this->M_Sales->EditSales($id_sales);
        $data['DataJabatan']    = $this->M_Jabatan->DataJabatan();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataSales/V_EditSales', $data);
        $this->load->view('template/V_FooterSales', $data);
    }

    public function EditSalesSave()
    {
        //mengambil data post pada view 
        $id           = $this->input->post('id');
        $name         = $this->input->post('name');
        $phone        = $this->input->post('phone');

        //menyimpan data Sales ke dalam array
        $dataSales = array(
            'id'          => $id,
            'name'        => $name,
            'phone'       => $phone,
            'updated_at'  => date('Y-m-d H:i:s', time())
        );

        $idSales = array(
            'id' => $id
        );

        //memanggil mysql dari model 
        $data['DataSales']       = $this->M_Sales->EditSales($id);

        // Rules form Validation
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataSales/V_EditSales', $data);
            $this->load->view('template/V_FooterSales', $data);
        } else {
            $this->M_CRUD->updateData('sales', $dataSales, $idSales);

            // Notifikasi Edit Berhasil
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            redirect('admin/DataSales/C_DataSales');
        }
    }
}
