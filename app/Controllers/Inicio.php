<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Inicio extends BaseController
{
    public function index() {
        return view('admin/vinicio');
    }
}

?>