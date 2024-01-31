<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_DP_Pelanggan extends CI_Controller
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

        if ((isset($_GET['nama_dp']) && $_GET['nama_dp'] != '')) {
            $NamaDP_GET                 = $_GET['nama_dp'];

            // Memanggil mysql dari model
            $data['DataPelanggan']      = $this->M_Pelanggan->DP_Pelanggan($NamaDP_GET);
            $data['JumlahPelanggan']    = $this->M_Pelanggan->DP_JumlahPelanggan($NamaDP_GET);

            $data['DataArea']           = $this->M_Area->DataArea();

            $this->session->set_userdata('NamaDP_GET', $NamaDP_GET);

            $this->load->view('template/user/V_Header', $data);
            $this->load->view('template/user/V_Sidebar', $data);
            $this->load->view('user/DataArea/V_DP_Pelanggan', $data);
            $this->load->view('template/user/V_FooterPelanggan', $data);
        } elseif ($_GET['nama_dp'] == '' && empty($_GET['nama_dp'])) {
            // Memanggil mysql dari model
            $data['DataPelanggan']      = $this->M_Pelanggan->DataPelanggan();
            $data['JumlahPelanggan']    = $this->M_Pelanggan->JumlahPelanggan();

            $data['DataArea']           = $this->M_Area->DataArea();

            $this->session->unset_userdata('NamaDP_GET');

            $this->load->view('template/user/V_Header', $data);
            $this->load->view('template/user/V_Sidebar', $data);
            $this->load->view('user/DataArea/V_DP_Pelanggan', $data);
            $this->load->view('template/user/V_FooterPelanggan', $data);
        }
    }

    public function GetDataAjax()
    {
        if ($this->session->userdata('NamaDP_GET') != NULL) {
            $result = $this->M_Pelanggan->DP_Pelanggan($this->session->userdata('NamaDP_GET'));

            $no = 0;

            foreach ($result as $dataCustomer) {
                $row = array();
                $row[] = '<div class="text-center">' . ++$no . '</div>';
                $row[] = $dataCustomer['name_pppoe'];
                $row[] = $dataCustomer['name'];
                $row[] = $dataCustomer['nama_dp'] . '/' . $dataCustomer['nama_area'];
                $row[] = $dataCustomer['address'];
                $row[] = $dataCustomer['nama_paket'];

                $row[] =
                    '<div class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                            Opsi
                        </button>
                        <div class="dropdown-menu text-black" style="background-color:aqua;">
                            <a onclick="EditDataDPPelanggan(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"><i class="bi bi-pencil-square"></i> Edit</a>
                        </div>
                    </div>
                    </div>';
                $data[] = $row;
            }

            $ouput = array(
                'data' => $data
            );

            $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
        } elseif ($_GET['nama_dp'] == '' && empty($_GET['nama_dp'])) {
            $this->session->unset_userdata('NamaDP_GET');

            $result = $this->M_Pelanggan->DataPelanggan();

            $no = 0;

            foreach ($result as $dataCustomer) {
                $row = array();
                $row[] = '<div class="text-center">' . ++$no . '</div>';
                $row[] = $dataCustomer['name_pppoe'];
                $row[] = $dataCustomer['name'];
                $row[] = $dataCustomer['nama_dp'] . '/' . $dataCustomer['nama_area'];
                $row[] = $dataCustomer['address'];
                $row[] = $dataCustomer['nama_paket'];

                $row[] =
                    '<div class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                            Opsi
                        </button>
                        <div class="dropdown-menu text-black" style="background-color:aqua;">
                            <a onclick="EditDataDPPelanggan(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"><i class="bi bi-pencil-square"></i> Edit</a>
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
}
