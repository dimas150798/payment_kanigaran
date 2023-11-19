<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahPaket extends CI_Controller
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
        $this->load->view('template/header');
        $this->load->view('template/sidebarAdmin');
        $this->load->view('admin/DataPaket/V_TambahPaket');
        $this->load->view('template/V_FooterPaket');
    }

    public function TambahPaketSave()
    {
        //mengambil data post pada view 
        $name           = $this->input->post('name');
        $price          = $this->input->post('price');
        $description    = $this->input->post('description');

        //menyimpan data ke dalam array
        $dataPaket = array(
            'name'              => $name,
            'price'             => $price,
            'description'       => $description,
            'created_at'        => date('Y-m-d H:i:s', time())
        );

        //memanggil mysql dari model 
        $checkDuplicate         = $this->M_Paket->CheckDuplicatePaket($name);

        // Rules form Validation
        $this->form_validation->set_rules('name', 'Nama Paket', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('price', 'Harga Paket', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi Paket', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {

            // Notifikasi kesalahan input
            $this->session->set_flashdata('DuplicateName_icon', 'error');
            $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Paket');
            $this->session->set_flashdata('DuplicateName_text', 'Check kembali data');

            echo "
            <script>history.go(-1);            
            </script>
            ";
        } else {
            if ($name == $checkDuplicate->name) {
                // Notifikasi Duplicate Name 
                $this->session->set_flashdata('DuplicateName_icon', 'error');
                $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Paket');
                $this->session->set_flashdata('DuplicateName_text', 'Nama paket sudah ada');

                redirect('admin/DataPaket/C_TambahPaket');
            } else {
                $this->M_CRUD->insertData($dataPaket, 'paket');

                // Notifikasi Tambah Berhasil
                $this->session->set_flashdata('Tambah_icon', 'success');
                $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                redirect('admin/DataPaket/C_DataPaket');
            }
        }
    }
}
