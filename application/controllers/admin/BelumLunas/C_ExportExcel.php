<?php

defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';
//Memanggil class dari PhpSpreadsheet dengan namespace
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_ExportExcel extends CI_Controller
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
        $bulan      = $this->session->userdata('bulanGET');
        $tahun      = $this->session->userdata('tahunGET');
        $tanggal    = $this->session->userdata('TanggalAkhirGET');

        if ($bulan == NULL && $tahun == NULL) {
            date_default_timezone_set("Asia/Jakarta");
            $bulanGET       = date('m');
            $tahunGET       = date('Y');

            // Menampilkan tanggal pada akhir bulan GET
            $tanggal_akhir_GET      = cal_days_in_month(CAL_GREGORIAN, $bulanGET, $tahunGET);

            // Menggabungkan tanggal, bulan, tahun
            $tanggalGET             = $tahunGET . '-' . $bulanGET . '-' . $tanggal_akhir_GET;
        } else {
            $bulanGET       = $bulan;
            $tahunGET       = $tahun;

            // Menampilkan tanggal pada akhir bulan GET
            $tanggal_akhir_GET      = cal_days_in_month(CAL_GREGORIAN, $bulanGET, $tahunGET);

            // Menggabungkan tanggal, bulan, tahun
            $tanggalGET             = $tahunGET . '-' . $bulanGET . '-' . $tanggal_akhir_GET;
        }

        $data = $this->M_BelumLunas->BelumLunas($bulanGET, $tahunGET, $tanggalGET);

        /* Spreadsheet Init */
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // tambpilaN judul
        $styleJudul = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];

        // tambpilan border atas
        $styleHeader = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        // tampilkan border bawah
        $styleTables = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        /* Excel Header */
        $sheet->setCellValue('A1', 'PT. Urban Teknologi Nusantara');
        $sheet->setCellValue('A2', 'Laporan Belum Lunas Customer KBS' . ' Bulan ' . $bulanGET . ' Tahun ' . $tahunGET);

        // Merubah ukuran font
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(17);
        $spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setSize(17);

        // MERGE
        $spreadsheet->getActiveSheet()->mergeCells('A1:M1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:M2');

        // Merubah tampilan border
        $spreadsheet->getActiveSheet()->getStyle('A1')->applyFromArray($styleJudul);
        $spreadsheet->getActiveSheet()->getStyle('A2')->applyFromArray($styleJudul);

        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Tanggal');
        $sheet->setCellValue('C4', 'Nama');
        $sheet->setCellValue('D4', 'Paket');
        $sheet->setCellValue('E4', 'Harga');

        // Merubah huruf
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');

        // Merubah tampilan border
        $spreadsheet->getActiveSheet()->getStyle('A4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('B4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('C4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('D4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('E4')->applyFromArray($styleHeader);

        // Merubah ukuran font
        $spreadsheet->getActiveSheet()->getStyle('A4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('B4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('C4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('D4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('E4')->getFont()->setSize(14);

        // merubah ukuran border
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

        /* Excel Data */
        $row_number = 5;
        foreach ($data as $key => $row) {
            $sheet->setCellValue('A' . $row_number, $key + 1);
            $sheet->setCellValue('B' . $row_number, 'Penagihan Tanggal ' . $row['tanggal']);
            $sheet->setCellValue('C' . $row_number, strtoupper($row['name']));
            $sheet->setCellValue('D' . $row_number, strtoupper($row['nama_paket']));
            $sheet->setCellValue('E' . $row_number, $row['harga_paket']);

            $spreadsheet->getActiveSheet()->getStyle('A' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('B' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('C' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('D' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('E' . $row_number)->applyFromArray($styleTables);

            // Convert nominal indonesia
            $spreadsheet->getActiveSheet()->getStyle('E' . $row_number)->getNumberFormat()->setFormatCode('#,##0');

            // Merubah ukuran font
            $spreadsheet->getActiveSheet()->getStyle('A' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('B' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('C' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('D' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('E' . $row_number)->getFont()->setSize(12);

            $row_number++;
        }

        // Write an .xlsx file
        $date = date('d-m-y-' . substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "Laporan Belum Lunas Customer KBS " . $bulanGET . " Tahun " . $tahunGET . substr((string)microtime(), 1, 8);
        $filePath = __DIR__ . DIRECTORY_SEPARATOR . $filename; //make sure you set the right permissions and change this to the path you want

        try {
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save($filePath);
        } catch (Exception $e) {
            exit($e->getMessage());
        }

        // redirect output to client browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
