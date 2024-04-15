<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Actividades extends BaseController
{   

    public function __construct()
    {
    }

    public function index() {
        return view('admin/mantenimiento/vactividades');
    }
}

?>