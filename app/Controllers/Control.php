<?php

namespace App\Controllers;
use App\Models\MusuarioModel;

use CodeIgniter\Controller;

class Control extends BaseController
{   
    protected $musuario;
    protected $helpers = ['url', 'form', 'fn_helper'];
    // protected $session;

    public function __construct()
    {
        $this->musuario = new MusuarioModel();
        // $this->session = \Config\Services::session();
    }

    public function index() {
        return view('admin/vcontrol');
    }
}