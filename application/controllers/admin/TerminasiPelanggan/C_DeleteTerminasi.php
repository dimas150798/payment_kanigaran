<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DeleteTerminasi extends CI_Controller
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

    public function DeletePelanggan($id_customer)
    {
        // Menyimpan data pelanggan ke dalam array
        $dataPelanggan = array(
            'stop_date'       => NULL,
            'updated_at'      => date('Y-m-d H:i:s', time())
        );

        // Kondisi delete menggunakan id_customer
        $idCustomer = array(
            'id'       => $id_customer
        );

        $this->M_CRUD->updateData('client', $dataPelanggan, $idCustomer);

        // Notifikasi Login Berhasil
        $this->session->set_flashdata('Delete_icon', 'success');
        $this->session->set_flashdata('Delete_title', 'Customer Kembali Aktif');

        redirect('admin/TerminasiPelanggan/C_TerminasiPelanggan');
    }
}
