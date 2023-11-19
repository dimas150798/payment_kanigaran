<?php
defined('BASEPATH') or exit('No direct script access allowed');

header('Content-type: application/json');
class Client extends CI_Controller
{

      public function index()
      {
            $request = $this->ClientModel->index();
            echo json_encode($request);
      }
}
