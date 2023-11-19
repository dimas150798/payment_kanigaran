<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahTerminated extends CI_Controller
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

    public function TerminatedPelanggan($id_customer)
    {
        $data['DataPelanggan']  = $this->M_Pelanggan->EditPelanggan($id_customer);
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPelanggan/V_TambahTerminated', $data);
        $this->load->view('template/V_FooterPelanggan', $data);
    }

    public function TerminatedPelangganSave()
    {
        date_default_timezone_set("Asia/Jakarta");

        // Mengambil data post pada view
        $id                     = $this->input->post('id');
        $id_pppoe               = $this->input->post('id_pppoe');
        $name_pppoe             = $this->input->post('name_pppoe');
        $stop_date              = $this->input->post('stop_date');
        $keterangan             = $this->input->post('keterangan');

        // Menyimpan data pelanggan ke dalam array
        $dataPelanggan = array(
            'id'                => $id,
            'stop_date'         => $stop_date,
            'keterangan'        => $keterangan,
            'updated_at'        => date('Y-m-d H:i:s', time())
        );

        // Kondisi update menggunakan id
        $idCustomer = array(
            'id'       => $id
        );

        // Memanggil mysql dari model
        $data['DataPelanggan']  = $this->M_Pelanggan->EditPelanggan($id);
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

        // Rules form validation
        $this->form_validation->set_rules('stop_date', 'Stop Date', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataPelanggan/V_TambahTerminated', $data);
            $this->load->view('template/V_FooterPelanggan', $data);
        } else {
            $this->M_CRUD->updateData('client', $dataPelanggan, $idCustomer);

            // disable secret dan active otomatis 
            $api = connect();
            $api->comm('/ppp/secret/set', [
                ".id" => $id_pppoe,
                "disabled" => 'true',
            ]);

            // disable active otomatis
            $ambilid = $api->comm("/ppp/active/print", ["?name" => $name_pppoe]);
            $api->comm('/ppp/active/remove', [".id" => $ambilid[0]['.id']]);
            $api->disconnect();

            // Notifikasi Login Berhasil
            $this->session->set_flashdata('Terminasi_icon', 'success');
            $this->session->set_flashdata('Terminasi_title', 'Terminasi Pelanggan Berhasil');

            redirect('admin/DataPelanggan/C_DataPelanggan');
        }
    }
}
