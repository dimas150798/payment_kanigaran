<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_DataPelanggan extends CI_Controller
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
        // clear session
        $this->session->unset_userdata('LoginBerhasil_icon');
        $this->session->unset_userdata('tahunGET');
        $this->session->unset_userdata('bulanGET');
        $this->session->unset_userdata('TanggalAkhirGET');

        // Memanggil data Mikrotik
        $this->MikrotikModel->index();

        // Memanggil mysql dari model
        $data['DataPelanggan'] = $this->M_Pelanggan->DataPelanggan();
        $data['JumlahPelanggan'] = $this->M_Pelanggan->JumlahPelanggan();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/DataPelanggan/V_DataPelanggan', $data);
        $this->load->view('template/V_FooterPelanggan', $data);
    }

    public function GetDataAjax()
    {
        $result = $this->M_Pelanggan->DataPelanggan();

        $no = 0;

        foreach ($result as $dataCustomer) {
            $StartDate = $dataCustomer['start_date'] == NULL;
            $StatusMikrotik = $dataCustomer['disabled'] == 'true';

            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = $dataCustomer['name'];
            $row[] = $dataCustomer['name_pppoe'];
            $row[] = '<div class="text-center">' . $dataCustomer['phone'] . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['nama_paket'] . '</div>';
            $row[] = '<div class="text-center">' . ($StartDate ? '<span class="badge bg-danger">DATA KOSONG</span>' : changeDateFormat('d-m-Y', $dataCustomer['start_date'])) . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['nama_sales'] . '</div>';
            $row[] = $dataCustomer['nama_area'];
            $row[] = '<div class="text-center">' . ($StatusMikrotik ? '<span class="badge bg-danger">DISABLED</span>' : '<span class="badge bg-success">ENABLE</span>') . '</div>';

            $row[] =
                '<div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                        Opsi
                    </button>
                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                        <a onclick="EditDataPelanggan(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"><i class="bi bi-pencil-square"></i> Edit</a>
                        <a onclick="TerminatedPelanggan(' . $dataCustomer['id'] . ')" class="dropdown-item text-black"><i class="bi bi-trash3-fill"></i> Terminated</a>
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
