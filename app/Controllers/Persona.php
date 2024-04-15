<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Persona extends BaseController
{   

    public function __construct()
    {
    }

    public function index() {
        return view('admin/mantenimiento/vpersona');
    }
}

?>