<?php

defined('BASEPATH') or exit('No direct script access allowed');

function formatBytes($bytes, $decimal = null)
{
    $satuan = ["bytes", 'kb', 'mb', 'gb', 'tb'];
    $i = 0;

    while ($bytes > 1024) {
        $bytes /= 1024;
        $i++;
    }

    return round($bytes, $decimal) . " " . $satuan[$i];
}

function connect()
{
    $CI = &get_instance();
    $CI->load->model('MikrotikModel');
    $result = $CI->MikrotikModel->CheckStatusMikrotik();

    $ipMikrotik         = $result->ip_mikrotik;
    $usernameMikrotik   = $result->username_mikrotik;
    $passwordMikrotik   = $result->password_mikrotik;


    $api = new RouterosAPI();
    $api->connect($ipMikrotik, $usernameMikrotik, $passwordMikrotik);

    // if (count($api->comm('/ppp/secret/print')) == 0) {
    //     echo json_encode("Connection Failed");
    //     exit;
    // }

    return $api;
}
