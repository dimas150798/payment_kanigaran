<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DisableMikrotik extends CI_Controller
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

    public function DisableMikrotik($id_mikrotik)
    {
        // Menyimpan data pelanggan ke dalam array
        $dataMikrotik = array(
            'status_mikrotik' => "disable",
            'updated_at'      => date('Y-m-d H:i:s', time())
        );

        // Kondisi merubah menggunakan id_mikrotik
        $idMikrotik = array(
            'id_mikrotik'       => $id_mikrotik
        );

        $this->M_CRUD->updateData('data_mikrotik', $dataMikrotik, $idMikrotik);

        // Notifikasi Enable Berhasil
        $this->session->set_flashdata('Tambah_icon', 'success');
        $this->session->set_flashdata('Tambah_title', 'Disable Data Berhasil');

        redirect('superadmin/DataMikrotik/C_DataMikrotik');
    }
}
