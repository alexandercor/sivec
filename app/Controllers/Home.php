<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('tb_departamento');
        $query   = $builder->get();

        $data = ['titulo' => 'nuevo', 'provincias' => $query];
        return view('admin/vprueba', $data);
    }
}
