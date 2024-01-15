<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_DataJatuhTempo extends CI_Controller
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

        date_default_timezone_set("Asia/Jakarta");
        $day = date('Y-m-d');

        // Memisahkan Tanggal
        $pecahDay       = explode("-", $day);

        $tahun          = $pecahDay[0];
        $bulan          = $pecahDay[1];
        $tanggal        = $pecahDay[2];

        $data['tanggal']            = $tanggal;
        $data['bulan']              = $bulan;
        $data['tahun']              = $tahun;

        // Memanggil mysql dari model
        $data['JatuhTempo']         = $this->M_JatuhTempo->JatuhTempo($day);
        $data['JumlahJatuhTempo']   = $this->M_JatuhTempo->JumlahJatuhTempo($day);

        $NominalJatuhTempo          = $this->M_JatuhTempo->NominalJatuhTempo($day);
        $data['NominalJatuhTempo']  = $NominalJatuhTempo->harga_paket;

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebarAdmin', $data);
        $this->load->view('admin/JatuhTempo/V_DataJatuhTempo', $data);
        $this->load->view('template/V_FooterJatuhTempo', $data);
    }

    public function GetJatuhTempo()
    {
        date_default_timezone_set("Asia/Jakarta");
        $toDay = date('Y-m-d');

        $result        = $this->M_JatuhTempo->JatuhTempo($toDay);

        $no = 0;

        foreach ($result as $dataCustomer) {
            $GrossAmount = $dataCustomer['gross_amount'] == NULL;
            $StatusMikrotik = $dataCustomer['disabled'] == 'true';

            $row = array();
            $row[] = '<div class="text-center">' . ++$no . '</div>';
            $row[] = '<div class="text-center">' . ($GrossAmount ? 'Tanggal ' . $dataCustomer['tanggal'] : changeDateFormat('d-m-Y / H:i:s', $dataCustomer['transaction_time'])) . '</div>';
            $row[] = $dataCustomer['name_pppoe'];
            $row[] = $dataCustomer['name'];
            $row[] = '<div class="text-center">' . strtoupper($dataCustomer['nama_paket']) . '</div>';
            $row[] = '<div class="text-center">' . 'Rp. ' . number_format($dataCustomer['harga_paket'], 0, ',', '.') . '</div>';
            $row[] = '<div class="text-center">' . ($StatusMikrotik ? '<span class="badge bg-danger">DISABLED</span>' : '<span class="badge bg-success">ENABLE</span>') . '</div>';

            $row[] =
                '<div class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown" data-bs-target="#dropdown" aria-expanded="false" aria-controls="dropdown">
                        Opsi
                    </button>
                    <div class="dropdown-menu text-black" style="background-color:aqua;">
                        <a onclick="PaymentJatuhTempo(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"><i class="bi bi-receipt-cutoff"></i>  Lunasi Pelanggan</a>
                        <a onclick="KirimWAJatuhTempo(' . $dataCustomer['id'] . ')"class="dropdown-item text-black"><i class="bi bi-whatsapp"></i> Kirim Tagihan</a>
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
