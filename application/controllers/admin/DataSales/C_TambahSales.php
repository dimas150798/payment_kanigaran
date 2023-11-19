<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahSales extends CI_Controller
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
        $data['DataJabatan']      = $this->M_Jabatan->DataJabatan();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataSales/V_TambahSales', $data);
        $this->load->view('template/V_FooterSales', $data);
    }

    public function TambahSalesSave()
    {
        //mengambil data post pada view 
        $name           = $this->input->post('name');
        $phone          = $this->input->post('phone');

        //menyimpan data Sales ke dalam array
        $dataSales = array(
            'name'              => $name,
            'phone'             => $phone,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        //memanggil mysql dari model 
        $checkDuplicate          = $this->M_Sales->CheckDuplicateSales($name);

        // Rules form Validation
        $this->form_validation->set_rules('name', 'Nama Sales', 'required');
        $this->form_validation->set_rules('phone', 'Phone Sales', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header');
            $this->load->view('template/sidebarAdmin');
            $this->load->view('admin/DataSales/V_TambahSales');
            $this->load->view('template/V_FooterSales');
        } else {
            if ($name == $checkDuplicate->name) {
                // Notifikasi Duplicate Name 
                $this->session->set_flashdata('DuplicateName_icon', 'error');
                $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Sales');
                $this->session->set_flashdata('DuplicateName_text', 'Nama sales sudah ada');

                echo "
                <script>history.go(-1);            
                </script>
                ";
            } else {
                $this->M_CRUD->insertData($dataSales, 'sales');

                // Notifikasi Tambah Berhasil
                $this->session->set_flashdata('Tambah_icon', 'success');
                $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                redirect('admin/DataSales/C_DataSales');
            }
        }
    }
}
