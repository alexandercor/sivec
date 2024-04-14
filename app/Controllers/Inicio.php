<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Inicio extends BaseController
{
    public function index() {
        $data = ['miUrlBase' => 'resources/adle'];
        return view('admin/vinicio', $data);
    }
}

?>