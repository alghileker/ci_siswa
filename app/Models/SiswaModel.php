<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nis', 'nama', 'kelas'];

    public function getSiswa(): array
    {
        return $this->findAll();
    }

    public function updateSiswa(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }
}