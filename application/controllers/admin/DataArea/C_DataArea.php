<?php

defined('BASEPATH') or exit('No direct script access allowed');

class C_DataArea extends CI_Controller
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
        // clear session login
        $this->session->unset_userdata('LoginBerhasil_icon');
        $this->session->unset_userdata('tahunGET');
        $this->session->unset_userdata('bulanGET');
        $this->session->unset_userdata('TanggalAkhirGET');

        // Memanggil mysql dari model
        $data['DataArea'] = $this->M_Area->DataArea();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataArea/V_DataArea', $data);
        $this->load->view('template/V_FooterArea', $data);
    }

    public function GetDataAjax()
    {
        $result = $this->M_Area->DataArea();

        $no = 0;

        foreach ($result as $dataArea) {
            $row = array();
            $row[] = ++$no;
            $row[] = $dataArea['nama_dp'];
            $row[] = $dataArea['name'];
            $row[] =
                '<div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                        Opsi
                    </button>
                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                        <a onclick="EditArea(' . $dataArea['id'] . ')"class="dropdown-item text-black"></i> Edit</a>
                        <a onclick="DeleteArea(' . $dataArea['id'] . ')" class="dropdown-item text-black"><i class="bi bi-trash3-fill"></i> Hapus</a>
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
