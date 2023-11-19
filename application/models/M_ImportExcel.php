<?php

class M_ImportExcel extends CI_Model
{
    // Menampilkan Data Excel
    public function DataExcel()
    {
        $query   = $this->db->query("SELECT id_excel, file_name, created_at
                FROM data_excel
                
                ORDER BY created_at DESC");

        return $query->result_array();
    }
}
