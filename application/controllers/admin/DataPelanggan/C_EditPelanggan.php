<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_EditPelanggan extends CI_Controller
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

    public function EditPelanggan($id_customer)
    {
        $data['DataPelanggan']  = $this->M_Pelanggan->EditPelanggan($id_customer);
        $data['DataPaket']      = $this->M_Paket->DataPaket();
        $data['DataArea']       = $this->M_Area->DataArea();
        $data['DataSales']      = $this->M_Sales->DataSales();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPelanggan/V_EditPelanggan', $data);
        $this->load->view('template/V_FooterPelanggan', $data);
    }

    public function EditPelangganSave()
    {
        date_default_timezone_set("Asia/Jakarta");

        // Mengambil data post pada view
        $id_pppoe               = $this->input->post('id_pppoe');
        $id                     = $this->input->post('id');
        $code_client            = $this->input->post('code_client');
        $phone                  = $this->input->post('phone');
        $name                   = $this->input->post('name');
        $id_paket               = $this->input->post('id_paket');
        $name_pppoe             = $this->input->post('name_pppoe');
        $password_pppoe         = $this->input->post('password_pppoe');
        $address                = $this->input->post('address');
        $email                  = $this->input->post('email');
        $start_date             = $this->input->post('start_date');
        $id_area                = $this->input->post('id_area');
        $description            = $this->input->post('description');
        $id_sales               = $this->input->post('id_sales');

        $GetDataPaket           = $this->M_Paket->GetDataPaket($id_paket);

        $price_paket            = $GetDataPaket->price;
        $name_paket             = $GetDataPaket->name;

        if ($name_paket == 'Free 20 Mbps') {
            $profile_paket      = 'HOME 20 B';
        } elseif ($name_paket == 'Free Up Home 50') {
            $profile_paket = 'HOME 50 B';
        } else {
            $profile_paket      = strtoupper($name_paket) . " B";
        }

        // Menyimpan data pelanggan ke dalam array
        $dataPelanggan = array(
            'id'                => $id,
            'code_client'       => $code_client,
            'phone'             => $phone,
            'name'              => $name,
            'id_paket'          => $id_paket,
            'name_pppoe'        => $name_pppoe,
            'password_pppoe'    => $password_pppoe,
            'address'           => $address,
            'email'             => $email,
            'start_date'        => $start_date,
            'id_area'           => $id_area,
            'description'       => $description,
            'id_sales'          => $id_sales,
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
        $this->form_validation->set_rules('name', 'Nama Customer', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('code_client', 'Kode Customer', 'required');
        $this->form_validation->set_rules('name_pppoe', 'Name PPPOE', 'required');
        $this->form_validation->set_rules('password_pppoe', 'Password PPPOE', 'required');
        $this->form_validation->set_rules('phone', 'Phone Customer', 'required');
        $this->form_validation->set_rules('id_paket', 'Nama Paket', 'required');
        $this->form_validation->set_rules('id_area', 'Nama Area', 'required');
        $this->form_validation->set_rules('id_sales', 'Nama Sales', 'required');
        $this->form_validation->set_rules('email', 'Email Customer', 'required');
        $this->form_validation->set_rules('address', 'Alamat Customer', 'required');
        $this->form_validation->set_message('required', 'Masukan data terlebih dahulu...');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/DataPelanggan/V_EditPelanggan', $data);
            $this->load->view('template/V_FooterPelanggan', $data);
        } else {
            // Edit Pelanggan Ke Mikrotik
            $api = connect();
            $api->comm('/ppp/secret/set', [
                ".id" => $id_pppoe,
                "name" => $name_pppoe,
                "password" => $password_pppoe,
                "service" => "pppoe",
                "profile"   => $profile_paket,
                "comment" => "",
            ]);
            $api->disconnect();

            $this->M_CRUD->updateData('client', $dataPelanggan, $idCustomer);

            // Notifikasi Login Berhasil
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            redirect('admin/DataPelanggan/C_DataPelanggan');
        }
    }
}
