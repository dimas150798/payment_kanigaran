<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_BelumLunas extends CI_Controller
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

            date_default_timezone_set("Asia/Jakarta");
            $bulanGET                   = $_GET['bulan'];
            $tahunGET                   = $_GET['tahun'];

            // Menampilkan tanggal pada akhir bulan GET
            $tanggal_akhir_GET          = cal_days_in_month(CAL_GREGORIAN, $bulanGET, $tahunGET);

            // Menggabungkan tanggal, bulan, tahun
            $TanggalAkhirGET            = $tahunGET . '-' . $bulanGET . '-' . $tanggal_akhir_GET;

            // Menyimpan Dalam Session
            $this->session->set_userdata('bulanGET', $bulanGET);
            $this->session->set_userdata('tahunGET', $tahunGET);
            $this->session->set_userdata('TanggalAkhirGET', $TanggalAkhirGET);

            // Memanggil mysql dari model
            $data['BelumLunas']         = $this->M_BelumLunas->BelumLunas($bulanGET, $tahunGET, $TanggalAkhirGET);
            $data['JumlahBelumLunas']   = $this->M_BelumLunas->JumlahBelumLunas($bulanGET, $tahunGET, $TanggalAkhirGET);
            $NominalBelumLunas          = $this->M_BelumLunas->NominalBelumLunas($bulanGET, $tahunGET, $TanggalAkhirGET);

            // Menyimpan query di dalam data
            $data['bulanGET']           = $bulanGET;
            $data['tahunGET']           = $tahunGET;
            $data['NominalBelumLunas']  = $NominalBelumLunas->harga_paket;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_BelumLunas', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        } else {
            date_default_timezone_set("Asia/Jakarta");
            $bulan                      = date("m");
            $tahun                      = date("Y");

            // Menampilkan tanggal pada akhir bulan
            $tanggal_akhir              = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

            // Menggabungkan tanggal, bulan, tahun
            $TanggalAkhir               = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

            // Menyimpan Dalam Session
            $this->session->set_userdata('bulan', $bulan);
            $this->session->set_userdata('tahun', $tahun);
            $this->session->set_userdata('TanggalAkhir', $TanggalAkhir);

            // Memanggil mysql dari model
            $data['BelumLunas']         = $this->M_BelumLunas->BelumLunas($bulan, $tahun, $TanggalAkhir);
            $data['JumlahBelumLunas']   = $this->M_BelumLunas->JumlahBelumLunas($bulan, $tahun, $TanggalAkhir);
            $NominalBelumLunas          = $this->M_BelumLunas->NominalBelumLunas($bulan, $tahun, $TanggalAkhir);

            // Menyimpan query di dalam data
            $data['bulan']              = $bulan;
            $data['tahun']              = $tahun;
            $data['NominalBelumLunas']  = $NominalBelumLunas->harga_paket;

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebarAdmin', $data);
            $this->load->view('admin/BelumLunas/V_BelumLunas', $data);
            $this->load->view('template/V_FooterBelumLunas', $data);
        }
    }

    public function GetBelumLunas()
    {
        date_default_timezone_set("Asia/Jakarta");
        $bulan                      = date("m");
        $tahun                      = date("Y");

        // Menampilkan tanggal pada akhir bulan
        $tanggal_akhir              = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Menggabungkan tanggal, bulan, tahun
        $TanggalAkhir               = $tahun . '-' . $bulan . '-' . $tanggal_akhir;

        if ($this->session->userdata('tahunGET') == NULL && $this->session->userdata('bulanGET') == NULL) {
            $result        = $this->M_BelumLunas->BelumLunas($this->session->userdata('bulan'), $this->session->userdata('tahun'), $this->session->userdata('TanggalAkhir'));

            $no = 0;

            foreach ($result as $dataCustomer) {
                $GrossAmount = $dataCustomer['gross_amount'] == NULL;
                $StatusMikrotik = $dataCustomer['disabled'] == 'true';

                $row = array();
                $row[] = ++$no;
                $row[] = ($GrossAmount ? $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time']));
                $row[] = $dataCustomer['name_pppoe'];
                $row[] = $dataCustomer['name'];
                $row[] = strtoupper($dataCustomer['nama_paket']) . ' / Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.');
                $row[] = ($StatusMikrotik ? '<span class="badge bg-danger">DISABLED</span>' : '<span class="badge bg-success">ENABLE</span>');

                $row[] =
                    '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                        Opsi
                    </button>
                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                        <a onclick="Payment(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"></i> Lunasi Pelanggan</a>
                        <a onclick="KirimWA(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"></i> Kirim Tagihan</a>
                    </div>
                </div>';
                $data[] = $row;
            }

            $ouput = array(
                'data' => $data
            );

            $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
        } else {
            $result        = $this->M_BelumLunas->BelumLunas($this->session->userdata('bulanGET'), $this->session->userdata('tahunGET'), $this->session->userdata('TanggalAkhirGET'));

            $no = 0;

            foreach ($result as $dataCustomer) {
                $GrossAmount = $dataCustomer['gross_amount'] == NULL;
                $StatusMikrotik = $dataCustomer['disabled'] == 'true';

                $row = array();
                $row[] = ++$no;
                $row[] = ($GrossAmount ? $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time']));
                $row[] = $dataCustomer['name_pppoe'];
                $row[] = $dataCustomer['name'];
                $row[] = strtoupper($dataCustomer['nama_paket']) . ' / Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.');
                $row[] = ($StatusMikrotik ? '<span class="badge bg-danger">DISABLED</span>' : '<span class="badge bg-success">ENABLE</span>');

                $row[] =
                    '
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                        Opsi
                    </button>
                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                        <a onclick="Payment(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"></i> Lunasi Pelanggan</a>
                        <a onclick="KirimWA(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"></i> Kirim Tagihan</a>
                    </div>
                </div>';
                $data[] = $row;
            }

            $ouput = array(
                'data' => $data
            );

            // <a onclick="PaymentBundling(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"></i> Lunasi Bundling</a>

            $this->output->set_content_type('application/json')->set_output(json_encode($ouput));
        }
    }
}
