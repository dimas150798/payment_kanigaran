<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DataMikrotik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('email') == null) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>Login Terlebih Dahulu</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
            redirect('C_FormLogin');
        }
    }

    public function index()
    {
        // clear session login
        $this->session->unset_userdata('LoginBerhasil_icon');

        $data['DataMikrotik'] = $this->MikrotikModel->DataMikrotik();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarSuperadmin', $data);
        $this->load->view('superadmin/DataMikrotik/V_DataMikrotik', $data);
        $this->load->view('template/V_FooterMikrotik', $data);
    }

    public function GetDataAjax()
    {
        $result = $this->MikrotikModel->DataMikrotik();

        $no = 0;

        foreach ($result as $dataMikrotik) {
            $statusMikrotik = $dataMikrotik['status_mikrotik'] == 'disable';

            $row = array();
            $row[] = ++$no;
            $row[] = $dataMikrotik['ip_mikrotik'];
            $row[] = $dataMikrotik['username_mikrotik'];
            $row[] = $dataMikrotik['password_mikrotik'];
            $row[] = '<div class="text-center">' . ($statusMikrotik ? '<span class="badge bg-danger">Disable</span>' : '<span class="badge bg-success">Enable</span>') . '</div>';

            $row[] =
                '<div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                        Opsi
                    </button>
                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                        <a onclick="EditMikrotik(' . $dataMikrotik['id_mikrotik'] . ')"class="dropdown-item text-black"></i> Edit</a>
                        <a onclick="DeleteMikrotik(' . $dataMikrotik['id_mikrotik'] . ')" class="dropdown-item text-black"><i class="bi bi-trash3-fill"></i> Hapus</a>
                        <a onclick="EnableMikrotik(' . $dataMikrotik['id_mikrotik'] . ')" class="dropdown-item text-black"><i class="bi bi-trash3-fill"></i> Enable</a>
                        <a onclick="DisableMikrotik(' . $dataMikrotik['id_mikrotik'] . ')" class="dropdown-item text-black"><i class="bi bi-trash3-fill"></i> Disable</a>
                    </div>
                </div>
                </div>';
            $data[] = $row;
        }

        $ouput = array(
            'data' => $data
        );

        $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
    }
}
