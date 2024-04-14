<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = ['titulo' => 'nuevo'];
        return view('admin/vprueba', $data);
    }
}
