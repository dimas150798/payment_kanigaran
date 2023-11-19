<?php

class M_DataAkun extends CI_Model
{
    // Menampilkan Data Akun
    public function DataAkun()
    {
        $query   = $this->db->query("SELECT data_login.id_login, data_login.email_login, data_login.password_login, data_login.id_akses, data_akses.nama_akses
                FROM data_login
                
                LEFT JOIN data_akses ON data_login.id_akses = data_akses.id_akses
                ORDER BY data_login.id_login ASC");

        return $query->result_array();
    }

    public function EditAkun($id_login)
    {
        $query   = $this->db->query("SELECT data_login.id_login, data_login.email_login, data_login.password_login, data_login.id_akses, data_akses.nama_akses
                FROM data_login
                
                LEFT JOIN data_akses ON data_login.id_akses = data_akses.id_akses
                WHERE id_login = '$id_login'
                ORDER BY data_login.id_login ASC");

        return $query->result_array();
    }

    // Check data akun
    public function CheckDuplicateakun($email_login)
    {
        $this->db->select('email_login, id_login');
        $this->db->where('email_login', $email_login);

        $this->db->limit(1);
        $result = $this->db->get('data_login');

        return $result->row();
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
}
