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
        date_default_timezone_set("Asia/Jakarta");

        $data = $this->M_Pelanggan->DataPelanggan();

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
        $sheet->setCellValue('A2', 'Export Data Pelanggan');

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
        $sheet->setCellValue('B4', 'Kode Pelanggan');
        $sheet->setCellValue('C4', 'Nama Pelanggan');
        $sheet->setCellValue('D4', 'Phone Pelanggan');
        $sheet->setCellValue('E4', 'Nama Paket');
        $sheet->setCellValue('F4', 'ID PPPOE');
        $sheet->setCellValue('G4', 'Name PPPOE');
        $sheet->setCellValue('H4', 'Password PPPOE');
        $sheet->setCellValue('I4', 'Alamat');
        $sheet->setCellValue('J4', 'Email');
        $sheet->setCellValue('K4', 'Tanggal Registrasi');
        $sheet->setCellValue('L4', 'Nama Area');
        $sheet->setCellValue('M4', 'Nama Sales');
        $sheet->setCellValue('N4', 'Id Paket');
        $sheet->setCellValue('O4', 'Id Area');
        $sheet->setCellValue('P4', 'Id Sales');

        // Merubah huruf
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');

        // Merubah tampilan border
        $spreadsheet->getActiveSheet()->getStyle('A4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('B4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('C4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('D4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('E4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('F4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('G4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('H4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('I4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('J4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('K4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('L4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('M4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('N4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('O4')->applyFromArray($styleHeader);
        $spreadsheet->getActiveSheet()->getStyle('P4')->applyFromArray($styleHeader);

        // Merubah ukuran font
        $spreadsheet->getActiveSheet()->getStyle('A4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('B4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('C4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('D4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('E4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('F4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('G4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('H4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('I4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('J4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('K4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('L4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('M4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('N4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('O4')->getFont()->setSize(14);
        $spreadsheet->getActiveSheet()->getStyle('P4')->getFont()->setSize(14);

        // merubah ukuran border
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

        /* Excel Data */
        $row_number = 5;
        foreach ($data as $key => $row) {
            $sheet->setCellValue('A' . $row_number, $key + 1);
            $sheet->setCellValue('B' . $row_number, $row['code_client']);
            $sheet->setCellValue('C' . $row_number, $row['name']);
            $sheet->setCellValue('D' . $row_number, $row['phone']);
            $sheet->setCellValue('E' . $row_number, $row['nama_paket']);
            $sheet->setCellValue('F' . $row_number, $row['id_pppoe']);
            $sheet->setCellValue('G' . $row_number, $row['name_pppoe']);
            $sheet->setCellValue('H' . $row_number, $row['password_pppoe']);
            $sheet->getCell('I' . $row_number)->setValueExplicit($row['address'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->getCell('J' . $row_number)->setValueExplicit($row['email'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('K' . $row_number, $row['start_date']);
            $sheet->setCellValue('L' . $row_number, $row['nama_area']);
            $sheet->setCellValue('M' . $row_number, $row['nama_sales']);
            $sheet->setCellValue('N' . $row_number, $row['id_paket']);
            $sheet->setCellValue('O' . $row_number, $row['id_area']);
            $sheet->setCellValue('P' . $row_number, $row['id_sales']);


            $spreadsheet->getActiveSheet()->getStyle('A' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('B' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('C' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('D' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('E' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('F' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('G' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('H' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('I' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('J' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('K' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('L' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('M' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('N' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('O' . $row_number)->applyFromArray($styleTables);
            $spreadsheet->getActiveSheet()->getStyle('P' . $row_number)->applyFromArray($styleTables);

            // Convert nominal indonesia
            $spreadsheet->getActiveSheet()->getStyle('E' . $row_number)->getNumberFormat()->setFormatCode('#,##0');

            // Merubah ukuran font
            $spreadsheet->getActiveSheet()->getStyle('A' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('B' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('C' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('D' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('E' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('F' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('G' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('H' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('I' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('J' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('K' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('L' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('M' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('N' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('O' . $row_number)->getFont()->setSize(12);
            $spreadsheet->getActiveSheet()->getStyle('P' . $row_number)->getFont()->setSize(12);

            $row_number++;
        }

        // Write an .xlsx file
        $date = date('d-m-y-' . substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "Data Pelanggan " . $date;
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
