<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Siswa extends BaseController
{
    public function index(): string
    {
        $siswaModel = new SiswaModel();

        return view('siswa_view', [
            'siswa' => $siswaModel->getSiswa(),
        ]);
    }
}