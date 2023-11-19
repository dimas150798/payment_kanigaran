<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_BelumLunasDate extends CI_Controller
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

        if ((isset($_GET['day']) && $_GET['day'] != '')) {
            $dayGET                     = $_GET['day'];

            $convertDate                = explode("-", $dayGET);

            $tahun                      = $convertDate[0];
            $bulan                      = $convertDate[1];
            $tanggal                    = $convertDate[2];

            // Menyimpan Dalam Session
            $this->session->set_userdata('dayGET', $dayGET);
            $this->session->set_userdata('tahunGET', $tahun);
            $this->session->set_userdata('bulanGET', $bulan);
            $this->session->set_userdata('tanggalGET', $tanggal);

            $data['dayGET']             = $dayGET;

            $data['BelumLunas']         = $this->M_BelumLunas->BelumLunasPertanggal($dayGET);
            $data['JumlahBelumLunas']   = $this->M_BelumLunas->JumlahBelumLunasPertanggal($dayGET);

            $NominalBelumLunas          = $this->M_BelumLunas->NominalBelumLunasPertanggal($dayGET);
            $data['NominalBelumLunas']   = $NominalBelumLunas->harga_paket;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_BelumLunasDate', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $day                        = date("Y-m-d");

            $convertDate                = explode("-", $day);

            $tahun                      = $convertDate[0];
            $bulan                      = $convertDate[1];
            $tanggal                    = $convertDate[2];

            // Menyimpan Dalam Session
            $this->session->set_userdata('day', $day);
            $this->session->set_userdata('tahun', $tahun);
            $this->session->set_userdata('bulan', $bulan);
            $this->session->set_userdata('tanggal', $tanggal);

            $data['day']                = $day;

            $data['BelumLunas']         = $this->M_BelumLunas->BelumLunasPertanggal($day);
            $data['JumlahBelumLunas']   = $this->M_BelumLunas->JumlahBelumLunasPertanggal($day);

            $NominalBelumLunas          = $this->M_BelumLunas->NominalBelumLunasPertanggal($day);
            $data['NominalBelumLunas']   = $NominalBelumLunas->harga_paket;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_BelumLunasDate', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        }
    }

    public function GetBelumLunas()
    {
        if ($this->session->userdata('dayGET') == NULL) {
            $result        = $this->M_BelumLunas->BelumLunasPertanggal($this->session->userdata('day'));

            $no = 0;

            foreach ($result as $dataCustomer) {
                $GrossAmount = $dataCustomer['gross_amount'] == NULL;

                $row = array();
                $row[] = ++$no;
                $row[] = $dataCustomer['name_pppoe'];
                $row[] = '<div class="text-center">' . ($GrossAmount ? 'Penagihan Tanggal ' . $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time'])) . '</div>';
                $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_paket']) . '</div>';
                $row[] = '<div class="text-center">' . 'Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.') . '</div>';
                $row[] =
                    '<div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                        Opsi
                    </button>
                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                        <a onclick="KirimWADate(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"></i> Kirim Tagihan</a>
                    </div>
                </div>
                </div>';
                $data[] = $row;
            }

            $ouput = array(
                'data' => $data
            );

            $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
        } else {
            $result        = $this->M_BelumLunas->BelumLunasPertanggal($this->session->userdata('dayGET'));

            $no = 0;

            foreach ($result as $dataCustomer) {
                $GrossAmount = $dataCustomer['gross_amount'] == NULL;

                $row = array();
                $row[] = ++$no;
                $row[] = $dataCustomer['name_pppoe'];
                $row[] = '<div class="text-center">' . ($GrossAmount ? 'Penagihan Tanggal ' . $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time'])) . '</div>';
                $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_paket']) . '</div>';
                $row[] = '<div class="text-center">' .  'Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.') . '</div>';
                $row[] =
                    '<div class="text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                                Opsi
                            </button>
                            <div class="dropdown-menu text-black" style="background-color:aqua;">
                                <a onclick="KirimWADate(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"></i> Kirim Tagihan</a>
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
