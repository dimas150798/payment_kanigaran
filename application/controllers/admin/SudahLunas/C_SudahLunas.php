<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_SudahLunas extends CI_Controller
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

            // Menambahkan 0 di depan bulan jika kurang dari 10
            $bulanGET_0 = sprintf("%02d", $bulanGET);

            // Menampilkan tanggal pada akhir bulan GET
            $tanggal_akhir_GET          = cal_days_in_month(CAL_GREGORIAN, $bulanGET_0, $tahunGET);

            // Menggabungkan tanggal, bulan, tahun
            $TanggalAkhirGET            = $tahunGET . '-' . $bulanGET_0 . '-' . $tanggal_akhir_GET;

            // Menyimpan Dalam Session
            $this->session->set_userdata('bulan_GET', $bulanGET);
            $this->session->set_userdata('bulanGET', $bulanGET_0);
            $this->session->set_userdata('tahunGET', $tahunGET);
            $this->session->set_userdata('TanggalAkhirGET', $TanggalAkhirGET);
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
        }

        $Month = $this->session->userdata('bulanGET') != NULL && $this->session->userdata('bulanGET') != ''
            ? $this->session->userdata('bulanGET')
            : $this->session->userdata('bulan');

        $Year = $this->session->userdata('tahunGET') != NULL && $this->session->userdata('tahunGET') != ''
            ? $this->session->userdata('tahunGET')
            : $this->session->userdata('tahun');

        $LastDate = $this->session->userdata('TanggalAkhirGET') != NULL && $this->session->userdata('TanggalAkhirGET') != ''
            ? $this->session->userdata('TanggalAkhirGET')
            : $this->session->userdata('TanggalAkhir');

        $bulan_show = $this->session->userdata('bulan_GET') != NULL && $this->session->userdata('bulan_GET') != ''
            ? $this->session->userdata('bulan_GET')
            : date("n");

        $tahun_show = $this->session->userdata('tahunGET') != NULL && $this->session->userdata('tahunGET') != ''
            ? $this->session->userdata('tahunGET')
            : date("Y");

        // Memanggil mysql dari model
        // Memanggil mysql dari model
        $data['SudahLunas']         = $this->M_SudahLunas->SudahLunas($Month, $Year, $LastDate);
        $data['JumlahSudahLunas']   = $this->M_SudahLunas->JumlahSudahLunas($Month, $Year, $LastDate);

        $NominalSudahLunas          = $this->M_SudahLunas->NominalSudahLunas($Month, $Year, $LastDate);
        $NominalBiayaAdmin          = $this->M_SudahLunas->BiayaAdmin($Month, $Year);

        // Menyimpan query di dalam data
        $data['bulan']              = $bulan_show;
        $data['tahun']              = $tahun_show;
        $data['NominalSudahLunas']  = $NominalSudahLunas->harga_paket + $NominalBiayaAdmin->biaya_admin;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/SudahLunas/V_SudahLunas', $data);
        $this->load->view('template/V_FooterSudahLunas', $data);
    }

    public function GetSudahLunas()
    {
        $bulan = $this->session->userdata('bulanGET') != NULL && $this->session->userdata('bulanGET') != ''
            ? $this->session->userdata('bulanGET')
            : $this->session->userdata('bulan');

        $tahun = $this->session->userdata('tahunGET') != NULL && $this->session->userdata('tahunGET') != ''
            ? $this->session->userdata('tahunGET')
            : $this->session->userdata('tahun');

        $TanggalAkhir = $this->session->userdata('TanggalAkhirGET') != NULL && $this->session->userdata('TanggalAkhirGET') != ''
            ? $this->session->userdata('TanggalAkhirGET')
            : $this->session->userdata('TanggalAkhir');

        $result        = $this->M_SudahLunas->SudahLunas($bulan, $tahun, $TanggalAkhir);

        $no = 0;

        foreach ($result as $dataCustomer) {
            $GrossAmount = $dataCustomer['gross_amount'] == NULL;
            $StatusMikrotik = $dataCustomer['disabled'] == 'true';

            $row = array();
            $row[] = '<div class="text-center">' .  ++$no . '</div>';
            $row[] = $dataCustomer['name_pppoe'];
            $row[] = $dataCustomer['name'];
            $row[] = '<div class="text-center">' . ($GrossAmount ? 'Penagihan Tanggal ' . $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['created_at'])) . '</div>';
            $row[] = '<div class="text-center">' . $dataCustomer['nama_paket'] . '</div>';
            $row[] = '<div class="text-center">' .  'Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.') . '<br>' . 'Rp.' . number_format($dataCustomer['biaya_admin'], 0, ',', '.') . '</div>';
            $row[] = '<div class="text-center">' .  $dataCustomer['nama_admin'] . '</div>';
            $row[] = '<div class="text-center">' . ($StatusMikrotik ? '<span class="badge bg-danger">DISABLED</span>' : '<span class="badge bg-success">ENABLE</span>') . '</div>';

            $row[] =
                '<div class="btn-group text-center">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                            Opsi
                        </button>
                        <div class="dropdown-menu text-black" style="background-color:aqua;">
                            <a onclick="KwitansiLunas(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"><i class="bi bi-receipt-cutoff"></i> Kwitansi</a>
                            <a onclick="KirimWA_Lunas(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"><i class="bi bi-whatsapp"></i> Kirim WA Lunas</a>
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
