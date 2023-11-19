<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_EditPaket extends CI_Controller
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

    public function EditPaket($id_paket)
    {
        //memanggil mysql dari model 
        $data['DataPaket']       = $this->M_Paket->EditPaket($id_paket);

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPaket/V_EditPaket', $data);
        $this->load->view('template/V_FooterPaket', $data);
    }

    public function EditPaketSave()
    {
        //mengambil data post pada view 
        $id                 = $this->input->post('id');
        $name               = $this->input->post('name');
        $price              = $this->input->post('price');
        $description        = $this->input->post('description');

        //memanggil mysql dari model 
        $data['DataPaket']  = $this->M_Paket->EditPaket($id);

        //menyimpan data ke dalam array
        $dataPaket = array(
            'name'          => $name,
            'price'         => $price,
            'description'   => $description,
            'updated_at'    => date('Y-m-d H:i:s', time())
        );

        $idPaket = array(
            'id' => $id
        );

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
            $this->M_CRUD->updateData('paket', $dataPaket, $idPaket);

            // Notifikasi Edit Berhasil
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            redirect('admin/DataPaket/C_DataPaket');
        }
    }
}
