<?php

class M_Jabatan extends CI_Model
{
    // Menampilkan Data Akses Login
    public function DataJabatan()
    {
        $query   = $this->db->query("SELECT id_jabatan, nama_jabatan
            FROM data_jabatan
            ORDER BY id_jabatan ASC");

        return $query->result_array();
    }

    // Edit Akses Login
    public function EditJabatan($id_jabatan)
    {
        $query   = $this->db->query("SELECT id_jabatan, nama_jabatan
            FROM data_jabatan
            WHERE id_jabatan = '$id_jabatan'
            ORDER BY id_jabatan ASC");

        return $query->result_array();
    }
}
