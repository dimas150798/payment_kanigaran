<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_TerminasiPelangganMonth extends CI_Controller
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

        if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
            $bulanGET                   = $_GET['bulan'];
            $tahunGET                   = $_GET['tahun'];

            // Menyimpan Dalam Session
            $this->session->set_userdata('bulanGET', $bulanGET);
            $this->session->set_userdata('tahunGET', $tahunGET);

            // Memanggil mysql dari model
            $data['DataTerminasi']          = $this->M_TerminasiPelanggan->GetTerminasiMonth($tahunGET, $bulanGET);
            $data['JumlahDataTerminasi']    = $this->M_TerminasiPelanggan->JumlahTerminasiMonth($tahunGET, $bulanGET);

            // Menyimpan query di dalam data
            $data['bulanGET']           = $bulanGET;
            $data['tahunGET']           = $tahunGET;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/TerminasiPelanggan/V_TerminasiPelangganMonth', $data);
            $this->load->view('template/V_FooterTerminasiPelanggan', $data);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $bulan                      = date("m");
            $tahun                      = date("Y");

            // Memanggil mysql dari model
            $data['DataTerminasi']          = $this->M_TerminasiPelanggan->GetTerminasiMonth($tahun, $bulan);
            $data['JumlahDataTerminasi']    = $this->M_TerminasiPelanggan->JumlahTerminasiMonth($tahun, $bulan);

            // Menyimpan query di dalam data
            $data['bulan']              = str_split($bulan);
            $data['tahun']              = $tahun;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/TerminasiPelanggan/V_TerminasiPelangganMonth', $data);
            $this->load->view('template/V_FooterTerminasiPelanggan', $data);
        }
    }

    public function GetDataAjax()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan                      = date("m");
        $tahun                      = date("Y");

        if ($this->session->userdata('tahunGET') == NULL && $this->session->userdata('bulanGET') == NULL) {
            $result        = $this->M_TerminasiPelanggan->GetTerminasiMonth($tahun, $bulan);

            $no = 0;

            foreach ($result as $dataCustomer) {
                $row = array();
                $row[] = ++$no;
                $row[] = strtoupper($dataCustomer['name']);
                $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_paket']) . '</div>';
                $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_sales']) . '</div>';
                $row[] = '<div class="text-center">' . changeDateFormat('d-m-Y', $dataCustomer['start_date']) . '</div>';
                $row[] = '<div class="text-center">' . changeDateFormat('d-m-Y', $dataCustomer['stop_date']) . '</div>';
                $data[] = $row;
            }

            $ouput = array(
                'data' => $data
            );

            $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
        } else {
            $result        = $this->M_TerminasiPelanggan->GetTerminasiMonth($this->session->userdata('tahunGET'), $this->session->userdata('bulanGET'));

            $no = 0;

            foreach ($result as $dataCustomer) {
                $row = array();
                $row[] = ++$no;
                $row[] = strtoupper($dataCustomer['name']);
                $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_paket']) . '</div>';
                $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_sales']) . '</div>';
                $row[] = '<div class="text-center">' . changeDateFormat('d-m-Y', $dataCustomer['start_date']) . '</div>';
                $row[] = '<div class="text-center">' . changeDateFormat('d-m-Y', $dataCustomer['stop_date']) . '</div>';
                $data[] = $row;
            }

            $ouput = array(
                'data' => $data
            );

            $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
        }
    }
}
