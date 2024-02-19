<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('changeDateFormat')) {
    function changeDateFormat($format = 'd-m-Y', $givenDate = null)
    {
        return date($format, strtotime($givenDate));
    }
}

class C_API_TerminasiPelanggan extends CI_Controller
{

    public function ApiTerminasi()
    {
        $request = $this->M_TerminasiPelanggan->TerminasiPelanggan();
        echo json_encode($request);
    }
}
