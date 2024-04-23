<?php

namespace App\Controllers;
use App\Models\MusuarioModel;

use CodeIgniter\Controller;

class Essalud extends BaseController
{   
    protected $musuario;
    protected $helpers = ['form', 'fn_helper'];

    public function __construct()
    {
        $this->musuario = new MusuarioModel();
    }

    public function index(){
        return view('admin/mantenimiento/vessalud');
    }
    // ****
}
?>