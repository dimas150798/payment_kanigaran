<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_Edit_Pelanggan extends CI_Controller
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

        $this->load->view('template/user/V_Header', $data);
        $this->load->view('template/user/V_Sidebar', $data);
        $this->load->view('user/DataArea/V_Edit_Pelanggan', $data);
        $this->load->view('template/user/V_FooterPelanggan', $data);
    }

    public function EditPelangganSave()
    {
        date_default_timezone_set("Asia/Jakarta");

        // Mengambil data post pada view
        $id_pppoe               = $this->input->post('id_pppoe');
        $id                     = $this->input->post('id');
        $address                = $this->input->post('address');
        $email                  = $this->input->post('email');
        $id_area                = $this->input->post('id_area');
        $description            = $this->input->post('description');
        $id_sales               = $this->input->post('id_sales');
        // Menyimpan data pelanggan ke dalam array
        $dataPelanggan = array(
            'id'                => $id,
            'address'           => $address,
            'email'             => $email,
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
            $this->M_CRUD->updateData('client', $dataPelanggan, $idCustomer);

            // Notifikasi Login Berhasil
            $this->session->set_flashdata('Edit_icon', 'success');
            $this->session->set_flashdata('Edit_title', 'Edit Data Berhasil');

            redirect('user/DataArea/C_DP_Pelanggan');
        }
    }
}
