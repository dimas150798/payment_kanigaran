<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_BelumLunas_CustomDate extends CI_Controller
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

        if ((isset($_GET['date_start']) && $_GET['date_start'] != '') && (isset($_GET['date_end']) && $_GET['date_end'] != '')) {
            $date_startGET      = $_GET['date_start'];
            $date_endGET        = $_GET['date_end'];

            $this->session->set_userdata('date_startGET', $date_startGET);
            $this->session->set_userdata('date_endGET', $date_endGET);

            // Memanggil mysql dari model
            $data['BelumLunas']         = $this->M_BelumLunas->BelumLunasCustomDate($date_startGET, $date_endGET);
            $data['JumlahBelumLunas']   = $this->M_BelumLunas->BelumLunasCustomDateJumlah($date_startGET, $date_endGET);
            $NominalBelumLunas          = $this->M_BelumLunas->NominalBelumLunasCustomDate($date_startGET, $date_endGET);


            // Menyimpan query di dalam data
            $data['date_startGET']      = $date_startGET;
            $data['date_endGET']        = $date_endGET;
            $data['NominalBelumLunas']  = $NominalBelumLunas->harga_paket;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_BelumLunas_CustomDate', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $dateNow = date("Y-m-d");

            // Menyimpan Dalam Session
            $this->session->set_userdata('dateNow', $dateNow);

            // Memanggil mysql dari model
            $data['BelumLunas']         = $this->M_BelumLunas->BelumLunasCustomDate($dateNow, $dateNow);
            $data['JumlahBelumLunas']   = $this->M_BelumLunas->BelumLunasCustomDateJumlah($dateNow, $dateNow);
            $NominalBelumLunas          = $this->M_BelumLunas->NominalBelumLunasCustomDate($dateNow, $dateNow);

            // Menyimpan query di dalam data
            $data['dateNow']            = $dateNow;
            $data['NominalBelumLunas']  = $NominalBelumLunas->harga_paket;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_BelumLunas_CustomDate', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        }
    }

    public function GetBelumLunas()
    {
        if ($this->session->userdata('date_startGET') == NULL) {
            $result        = $this->M_BelumLunas->BelumLunasCustomDate(($this->session->userdata('dateNow')), ($this->session->userdata('dateNow')));

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
            $result        = $this->M_BelumLunas->BelumLunasCustomDate($this->session->userdata('date_startGET'), $this->session->userdata('date_endGET'));

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
