<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_TambahPelanggan extends CI_Controller
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
        // Memanggil mysql dari model
        $data['DataPaket'] = $this->M_Paket->DataPaket();
        $data['DataArea'] = $this->M_Area->DataArea();
        $data['DataSales'] = $this->M_Sales->DataSales();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPelanggan/V_TambahPelanggan', $data);
        $this->load->view('template/V_FooterPelanggan', $data);
    }

    public function TambahPelangganSave()
    {
        date_default_timezone_set("Asia/Jakarta");

        // Mengambil data post pada view
        $order_id = $this->input->post('order_id');
        $code_client = $this->input->post('code_client');
        $phone = $this->input->post('phone');
        $name = $this->input->post('name');
        $id_paket = $this->input->post('id_paket');
        $name_pppoe = $this->input->post('name_pppoe');
        $password_pppoe = $this->input->post('password_pppoe');
        $address = $this->input->post('address');
        $email = $this->input->post('email');
        $start_date = $this->input->post('start_date');
        $id_area = $this->input->post('id_area');
        $description = $this->input->post('description');
        $id_sales = $this->input->post('id_sales');
        $biaya_instalasi = $this->input->post('biaya_instalasi');

        $GetDataPaket = $this->M_Paket->GetDataPaket($id_paket);

        $price_paket = $GetDataPaket->price;
        $name_paket = $GetDataPaket->name;

        if ($name_paket == 'Free 20 Mbps') {
            $profile_paket = 'HOME 20 B';
        } elseif ($name_paket == 'Free Up Home 50') {
            $profile_paket = 'HOME 50 B';
        } else {
            $profile_paket = strtoupper($name_paket) . " B";
        }

        // Menyimpan data pelanggan ke dalam array
        $dataPelanggan = array(
            'code_client'    => $code_client,
            'phone'          => $phone,
            'latitude'       => 0,
            'longitude'      => 0,
            'name'           => $name,
            'id_paket'       => $id_paket,
            'name_pppoe'     => $name_pppoe,
            'password_pppoe' => $password_pppoe,
            'address'        => $address,
            'email'          => $email,
            'start_date'     => $start_date,
            'id_area'        => $id_area,
            'description'    => $description,
            'id_sales'       => $id_sales,
            'created_at'     => date('Y-m-d H:i:s', time()),
        );

        // Menyimpan data pelanggan ke dalam array
        $dataPelangganDuplicate = array(
            'code_client'    => $this->M_BelumLunas->invoice(),
            'phone'          => $phone,
            'latitude'       => 0,
            'longitude'      => 0,
            'name'           => $name,
            'id_paket'       => $id_paket,
            'name_pppoe'     => $name_pppoe,
            'password_pppoe' => $password_pppoe,
            'address'        => $address,
            'email'          => $email,
            'start_date'     => $start_date,
            'id_area'        => $id_area,
            'description'    => $description,
            'id_sales'       => $id_sales,
            'created_at'     => date('Y-m-d H:i:s', time()),
        );

        $dataPembayaran = array(
            'order_id'         => $order_id,
            'gross_amount'     => $price_paket,
            'biaya_admin'      => '0',
            'biaya_instalasi'  => $biaya_instalasi,
            'nama'             => $name_pppoe,
            'paket'            => $name_paket,
            'nama_admin'       => 'Admin Infly',
            'keterangan'       => 'Registrasi Baru',
            'transaction_time' => date('Y-m-d H:i:s', time()),
            'status_code'      => '200',
            'created_at'        => date('Y-m-d H:i:s', time()),
        );

        $dataPembayaranDuplicate = array(
            'order_id'         => $this->M_BelumLunas->invoice(),
            'gross_amount'     => $price_paket,
            'biaya_admin'      => '0',
            'biaya_instalasi'  => $biaya_instalasi,
            'nama'             => $name_pppoe,
            'paket'            => $name_paket,
            'nama_admin'       => 'Admin Infly',
            'keterangan'       => 'Registrasi Baru',
            'transaction_time' => date('Y-m-d H:i:s', time()),
            'status_code'      => '200',
            'created_at'        => date('Y-m-d H:i:s', time()),
        );

        // Memanggil mysql dari model
        $data['DataPaket'] = $this->M_Paket->DataPaket();
        $data['DataArea'] = $this->M_Area->DataArea();
        $data['DataSales'] = $this->M_Sales->DataSales();

        // Check name pppoe duplicate
        $checkDuplicate = $this->M_Pelanggan->CheckDuplicatePelanggan($name_pppoe);

        // Check duplicate code
        $checkDuplicateCode = $this->M_Pelanggan->CheckDuplicateCode($order_id);


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
            $this->load->view('admin/DataPelanggan/V_TambahPelanggan', $data);
            $this->load->view('template/V_FooterPelanggan', $data);
        } else {
            if ($name_pppoe == $checkDuplicate->name_pppoe) {
                // Notifikasi Duplicate Name
                $this->session->set_flashdata('DuplicateName_icon', 'error');
                $this->session->set_flashdata('DuplicateName_title', 'Gagal Tambah Pelanggan');
                $this->session->set_flashdata('DuplicateName_text', 'Name PPPOE Sudah Ada');

                redirect('admin/DataPelanggan/C_TambahPelanggan');
            } else {
                if ($order_id != $checkDuplicateCode->order_id) {
                    $this->M_CRUD->insertData($dataPelanggan, 'client');
                    $this->M_CRUD->insertData($dataPembayaran, 'data_pembayaran');
                    $this->M_CRUD->insertData($dataPembayaran, 'data_pembayaran_history');

                    // Tambah Pelanggan Ke Mikrotik
                    $api = connect();
                    $api->comm('/ppp/secret/add', [
                        "name"     => $name_pppoe,
                        "password" => $password_pppoe,
                        "service"  => "pppoe",
                        "profile"  => $profile_paket,
                        "comment"  => "",
                    ]);
                    $api->disconnect();

                    // Memanggil data Mikrotik
                    $this->MikrotikModel->index();

                    // Notifikasi Tambah Data Berhasil
                    $this->session->set_flashdata('Tambah_icon', 'success');
                    $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                    redirect('admin/DataPelanggan/C_DataPelanggan');
                } else {
                    $this->M_CRUD->insertData($dataPelangganDuplicate, 'client');
                    $this->M_CRUD->insertData($dataPembayaranDuplicate, 'data_pembayaran');
                    $this->M_CRUD->insertData($dataPembayaranDuplicate, 'data_pembayaran_history');

                    // Tambah Pelanggan Ke Mikrotik
                    $api = connect();
                    $api->comm('/ppp/secret/add', [
                        "name"     => $name_pppoe,
                        "password" => $password_pppoe,
                        "service"  => "pppoe",
                        "profile"  => $profile_paket,
                        "comment"  => "",
                    ]);
                    $api->disconnect();

                    // Memanggil data Mikrotik
                    $this->MikrotikModel->index();

                    // Notifikasi Tambah Data Berhasil
                    $this->session->set_flashdata('Tambah_icon', 'success');
                    $this->session->set_flashdata('Tambah_title', 'Tambah Data Berhasil');

                    redirect('admin/DataPelanggan/C_DataPelanggan');
                }
            }
        }
    }
}
