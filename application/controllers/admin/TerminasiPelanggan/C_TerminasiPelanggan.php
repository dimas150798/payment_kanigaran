<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_TerminasiPelanggan extends CI_Controller
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
        $data['DataPelanggan']      = $this->M_TerminasiPelanggan->TerminasiPelanggan();
        $data['JumlahPelanggan']    = $this->M_TerminasiPelanggan->JumlahTerminasi();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/TerminasiPelanggan/V_TerminasiPelanggan', $data);
        $this->load->view('template/V_FooterTerminasiPelanggan', $data);
    }

    public function GetDataAjax()
    {
        $result = $this->M_TerminasiPelanggan->TerminasiPelanggan();

        $no = 0;

        foreach ($result as $dataCustomer) {
            $StartDate = $dataCustomer['start_date'] == NULL;
            $StatusMikrotik = $dataCustomer['disabled'] == 'true';

            $row = array();
            $row[] = ++$no;
            $row[] = strtoupper($dataCustomer['name']);
            $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_paket']) . '</div>';
            $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_sales']) . '</div>';
            $row[] = '<div class="text-center">' . ($StartDate ? '<span class="badge bg-danger">DATA KOSONG</span>' : changeDateFormat('d-m-Y', $dataCustomer['start_date'])) . '</div>';
            $row[] = '<div class="text-center">' . changeDateFormat('d-m-Y', $dataCustomer['stop_date']) . '</div>';
            $row[] = '<div class="text-center">' . ($StatusMikrotik ? '<span class="badge bg-danger">DISABLED</span>' : '<span class="badge bg-success">ENABLE</span>') . '</div>';
            $row[] = strtoupper($dataCustomer['keterangan']);

            $row[] =
                '<div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                        Opsi
                    </button>
                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                        <a onclick="DeleteTerminasi(' . $dataCustomer['id'] . ')" class="dropdown-item text-black"><i class="bi bi-trash3-fill"></i> Hapus</a>
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
