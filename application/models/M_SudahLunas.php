<?php

class M_SudahLunas extends CI_Model
{

    // Menampilkan Data Sudah Lunas
    public function SudahLunas($bulan, $tahun, $tanggalAkhir)
    {
        $query   = $this->db->query("SELECT 
        client.id, client.code_client, client.phone, client.name,  
        client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
        DAY(client.start_date) as tanggal, client.stop_date, client.description, client.disabled,
        data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, data_pembayaran.biaya_instalasi,
        data_pembayaran.nama_admin, data_pembayaran.nama, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
        data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
        data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_pembayaran.paket as nama_paket, data_pembayaran.gross_amount as harga_paket,
        data_pembayaran.created_at, DAY(data_pembayaran.created_at) as tanggalTransaksi, MONTH(data_pembayaran.created_at) as bulanTransaksi, YEAR(data_pembayaran.created_at) as tahunTransaksi

        FROM client
        LEFT JOIN paket ON client.id_paket = paket.id
        LEFT JOIN data_pembayaran ON client.name_pppoe = data_pembayaran.nama

        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        WHERE client.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
        data_pembayaran.transaction_time IS NOT NULL AND client.stop_date IS NULL
        AND paket.name != 'Free 20 Mbps'

        GROUP BY client.name_pppoe
        ORDER BY data_pembayaran.order_id DESC");

        return $query->result_array();
    }

    // Menampilkan Data Sudah Lunas
    public function CheckJumlahSudahLunas($bulan, $tahun, $nama)
    {
        $query   = $this->db->query("SELECT * FROM data_pembayaran 
                                    WHERE MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
                                    AND nama = '$nama'");

        return $query->num_rows();
    }

    // Menampilkan Data Sudah Lunas
    public function SudahLunasExcel($bulan, $tahun, $tanggalAkhir)
    {
        $query   = $this->db->query("SELECT 
            client.id, client.code_client, client.phone, client.name,  
            client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
            DAY(client.start_date) as tanggal, client.stop_date, client.description,
            data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, data_pembayaran.biaya_instalasi,
            data_pembayaran.nama_admin, data_pembayaran.nama, data_pembayaran.keterangan, data_pembayaran.payment_type, 
            data_pembayaran.transaction_time, MONTH(data_pembayaran.transaction_time) as bulanJatuhTempo, YEAR(data_pembayaran.transaction_time) as tahunJatuhTempo, data_pembayaran.expired_date,
            data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
            data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_pembayaran.paket as nama_paket, data_pembayaran.gross_amount as harga_paket,
            data_pembayaran.created_at, DAY(data_pembayaran.created_at) as tanggalTransaksi, MONTH(data_pembayaran.created_at) as bulanTransaksi, YEAR(data_pembayaran.created_at) as tahunTransaksi
    
            FROM client
            LEFT JOIN paket ON client.id_paket = paket.id
            LEFT JOIN data_pembayaran ON client.name_pppoe = data_pembayaran.nama
    
            AND MONTH(data_pembayaran.created_at) = '$bulan' AND YEAR(data_pembayaran.created_at) = '$tahun'
    
            WHERE client.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
            data_pembayaran.transaction_time IS NOT NULL AND client.stop_date IS NULL 
            AND paket.name != 'Free 20 Mbps'
    
            ORDER BY DAY(client.start_date) ASC");

        return $query->result_array();
    }

    // Menampilkan Jumlah Belum Lunas
    public function JumlahSudahLunas($bulan, $tahun, $tanggalAkhir)
    {
        $query   = $this->db->query("SELECT 
        client.id, client.code_client, client.phone, client.name,  
        client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
        DAY(client.start_date) as tanggal, client.stop_date, client.description,
        data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
        data_pembayaran.nama_admin, data_pembayaran.nama, data_pembayaran.keterangan, data_pembayaran.payment_type, data_pembayaran.transaction_time, data_pembayaran.expired_date,
        data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
        data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, paket.name as nama_paket, paket.price as harga_paket

        FROM client
        LEFT JOIN paket ON client.id_paket = paket.id
        LEFT JOIN data_pembayaran ON client.name_pppoe = data_pembayaran.nama
        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        WHERE client.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir' AND
        data_pembayaran.transaction_time IS NOT NULL AND client.stop_date IS NULL
        AND paket.name != 'Free 20 Mbps'

        GROUP BY client.name_pppoe
        ORDER BY DAY(client.start_date) ASC");

        return $query->num_rows();
    }

    // Menampilkan Jumlah Nominal Belum Lunas
    public function NominalSudahLunas($bulan, $tahun, $tanggalAkhir)
    {
        $result   = $this->db->query("SELECT 
        SUM(data_pembayaran.gross_amount) AS harga_paket

        FROM client
        LEFT JOIN paket ON client.id_paket = paket.id
        LEFT JOIN data_pembayaran ON client.name_pppoe = data_pembayaran.nama
        AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
        
        WHERE client.start_date BETWEEN '2020-01-01' AND '$tanggalAkhir'
        AND data_pembayaran.transaction_time IS NOT NULL AND client.stop_date IS NULL
        AND paket.name != 'Free 20 Mbps'
        ");

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }

    // Invoice payment
    public function invoice()
    {
        $sql = "SELECT MAX(MID(order_id,8,4)) AS invoiceID 
        FROM data_pembayaran
        WHERE MID(order_id,4,4) = DATE_FORMAT(CURDATE(), '%y%m')";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $dataRow    = $query->row();
            $dataN      = ((int)$dataRow->invoiceID) + 1;
            $no         = sprintf("%'.04d", $dataN);
        } else {
            $no         = "0001";
        }

        $invoice = "IN7" . date('ym') . $no;
        return $invoice;
    }

    // Pembayaran Pelanggan
    public function Payment($id_customer, $bulan, $tahun)
    {
        $query   = $this->db->query("SELECT 
        client.id, client.code_client, client.phone, client.name,  
        client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
        DAY(client.start_date) as tanggal, client.stop_date, client.description,
        data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
        data_pembayaran.nama_admin, data_pembayaran.nama, data_pembayaran.keterangan, data_pembayaran.payment_type, MONTH(data_pembayaran.transaction_time) as bulan_transaksi,
        YEAR(data_pembayaran.transaction_time) as tahun_transaksi, data_pembayaran.transaction_time, data_pembayaran.expired_date,
        data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
        data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, paket.name as nama_paket, paket.price as harga_paket

        FROM client
        LEFT JOIN paket ON client.id_paket = paket.id
        LEFT JOIN data_pembayaran ON client.name_pppoe = data_pembayaran.nama

        WHERE client.id = '$id_customer' AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        GROUP BY client.name_pppoe
        ORDER BY DAY(client.start_date) ASC");

        return $query->result_array();
    }

    // Kwitansi
    public function Kwitansi($id_customer, $bulan, $tahun)
    {
        $query   = $this->db->query("SELECT 
                client.id, client.code_client, client.phone, client.name,  
                client.name_pppoe, client.password_pppoe, client.id_pppoe, client.address, client.email, 
                DAY(client.start_date) as tanggal, client.stop_date, client.description,
                data_pembayaran.order_id, data_pembayaran.gross_amount, data_pembayaran.biaya_admin, 
                data_pembayaran.nama_admin, data_pembayaran.nama, data_pembayaran.keterangan, data_pembayaran.payment_type, MONTH(data_pembayaran.transaction_time) as bulan_transaksi, data_pembayaran.transaction_time, data_pembayaran.expired_date,
                data_pembayaran.bank, data_pembayaran.va_number, data_pembayaran.permata_va_number, data_pembayaran.payment_code, data_pembayaran.bill_key, 
                data_pembayaran.biller_code, data_pembayaran.pdf_url, data_pembayaran.status_code, data_pembayaran.created_at, paket.name as nama_paket, paket.price as harga_paket
    
                FROM client
                LEFT JOIN paket ON client.id_paket = paket.id
                LEFT JOIN data_pembayaran ON client.name_pppoe = data_pembayaran.nama
    
                WHERE client.id = '$id_customer' AND MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'
        
                GROUP BY client.name_pppoe
                ORDER BY DAY(client.start_date) ASC");

        return $query->result_array();
    }

    public function BiayaAdmin($bulan, $tahun)
    {

        $result   = $this->db->query("SELECT SUM(data_pembayaran.biaya_admin) AS biaya_admin
        
        FROM client 
        LEFT OUTER JOIN paket ON client.id_paket = paket.id
        LEFT OUTER JOIN data_pembayaran ON client.name_pppoe = data_pembayaran.nama
        
        WHERE MONTH(data_pembayaran.transaction_time) = '$bulan' AND YEAR(data_pembayaran.transaction_time) = '$tahun'

        ORDER BY data_pembayaran.order_id DESC
        ");

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
