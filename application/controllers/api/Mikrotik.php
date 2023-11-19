<?php

// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Content-type: application/json');
class Mikrotik extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    private function connect()
    {
        $Mikrotik           = $this->MikrotikModel->CheckStatusMikrotik();

        $ipMikrotik         = $Mikrotik->ip_mikrotik;
        $usernameMikrotik   = $Mikrotik->username_mikrotik;
        $passwordMikrotik   = $Mikrotik->password_mikrotik;

        $api = new RouterosAPI();
        $api->connect($ipMikrotik, $usernameMikrotik, $passwordMikrotik);

        // if (count($api->comm('/system/resource/print')) == 0) {
        //     echo json_encode("Connection Failed");
        //     exit;
        // }

        return $api;
    }

    public function interface()
    {
        $api = $this->connect();

        $interface = $api->comm('/interface/print');
        echo json_encode($interface);

        $api->disconnect();
    }

    public function resource()
    {
        $api = $this->connect();

        $resource = $api->comm('/system/resource/print');
        echo json_encode($resource);

        $api->disconnect();
    }

    public function server()
    {
        $api = $this->connect();

        $server = $api->comm('/ip/hotspot/print');
        echo json_encode($server);

        $api->disconnect();
    }

    public function users($id = null)
    {
        $api = $this->connect();
        $users = [];

        if ($id == null) {
            $users = $api->comm('/ip/hotspot/user/print');
        } else {
            $users = $api->comm('/ip/hotspot/user/print', [
                '?.id' => "*$id"
            ]);
        }

        echo json_encode($users);

        $api->disconnect();
    }

    public function userAdd()
    {
        $api = $this->connect();

        $result = $api->comm('/ip/hotspot/user/add', [
            "name" => "name",
            "password" => "password",
            "server" => "server",
            "profile" => "profile",
            "limit-uptime" => "limit-uptime",
            "comment" => "comment"
        ]);
        echo json_encode($result);

        $api->disconnect();
    }

    public function userUpdate()
    {
        $api = $this->connect();

        $result = $api->comm('/ip/hotspot/user/set', [
            ".id" => "*1234",
            "name" => "name",
            "password" => "password",
            "server" => "server",
            "profile" => "profile",
            "limit-uptime" => "limit-uptime",
            "comment" => "comment"
        ]);
        echo json_encode($result);

        $api->disconnect();
    }

    public function userDelete()
    {
        $api = $this->connect();

        $result = $api->comm('/ip/hotspot/user/remove', [
            ".id" => "*.id",
        ]);

        echo json_encode($result);

        $api->disconnect();
    }

    public function active()
    {
        $api = $this->connect();

        $hotspotActive = $api->comm('/ip/hotspot/active/print');
        echo json_encode($hotspotActive);

        $api->disconnect();
    }

    public function activeDelete()
    {
        $api = $this->connect();

        $result = $api->comm('/ip/hotspot/active/remove', [
            ".id" => "*.id",
        ]);

        echo json_encode($result);

        $api->disconnect();
    }

    public function userProfile()
    {
        $api = $this->connect();

        $profile = $api->comm('/ip/hotspot/profile/print');
        echo json_encode($profile);

        $api->disconnect();
    }

    public function userProfileAdd()
    {
        $api = $this->connect();

        $result = $api->comm('/ip/hotspot/user/profile/add', [
            "name" => "name",
            "rate-limit" => "rate-limit",
            "shared_user" => "shared_user",
        ]);
        echo json_encode($result);

        $api->disconnect();
    }

    public function userProfileDelete()
    {
        $api = $this->connect();

        $result = $api->comm('/ip/hotspot/user/profile/remove', [
            ".id" => "*.id",
        ]);

        echo json_encode($result);

        $api->disconnect();
    }

    public function binding()
    {
        $api = $this->connect();

        $binding = $api->comm('/ip/hotspot/ip-binding/print');
        echo json_encode($binding);

        $api->disconnect();
    }

    public function bindingAdd()
    {
        $api = $this->connect();

        $result = $api->comm('/ip/hotspot/ip-binding/add', [
            "mac-address" => "mac-address",
            "address" => "0.0.0.0",
            "to-address" => "0.0.0.0",
            "type" => "type",
            "comment" => "comment"
        ]);
        echo json_encode($result);

        $api->disconnect();
    }

    public function bindingDelete()
    {
        $api = $this->connect();

        $result = $api->comm('/ip/hotspot/ip-binding/remove', [
            ".id" => "*.id",
        ]);

        echo json_encode($result);

        $api->disconnect();
    }

    public function host()
    {
        $api = $this->connect();

        $host = $api->comm('/ip/hotspot/host/print');
        echo json_encode($host);

        $api->disconnect();
    }

    public function cookie()
    {
        $api = $this->connect();

        $host = $api->comm('/ip/hotspot/cookie/print');
        echo json_encode($host);

        $api->disconnect();
    }

    public function cookieDelete()
    {
        $api = $this->connect();

        $result = $api->comm('/ip/hotspot/cookie/remove', [
            ".id" => "*.id",
        ]);

        echo json_encode($result);

        $api->disconnect();
    }

    public function traffic($interface = null)
    {
        $api = $this->connect();

        $traffic = [];
        $data = [];

        // $interface = 'vlan143';
        // $interface = 'vlan255';
        $interface = 'SFP+1-CRS326';

        if ($interface) {
            $traffic = $api->comm('/interface/monitor-traffic', [
                "interface" => $interface,
                "once" => ""
            ]);

            $data = [
                "rx" => formatBytes($traffic[0]["rx-bits-per-second"]),
                "tx" => formatBytes($traffic[0]["tx-bits-per-second"]),
            ];
        }

        echo json_encode($data);

        $api->disconnect();
    }
}
