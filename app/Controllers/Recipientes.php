<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Recipientes extends BaseController
{   

    public function __construct()
    {
    }

    public function index() {
        return view('admin/mantenimiento/vrecipientes');
    }
}

?>