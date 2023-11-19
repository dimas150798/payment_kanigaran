<?php

class M_AksesLogin extends CI_Model
{

    // Menampilkan Data Akses Login
    public function DataAksesLogin()
    {
        $query   = $this->db->query("SELECT id_akses, nama_akses
            FROM data_akses
            ORDER BY id_akses ASC");

        return $query->result_array();
    }

    // Edit Akses Login
    public function EditAksesLogin($id_akses)
    {
        $query   = $this->db->query("SELECT id_akses, nama_akses
            FROM data_akses
            WHERE id_akses = '$id_akses'
            ORDER BY id_akses ASC");

        return $query->result_array();
    }
}
