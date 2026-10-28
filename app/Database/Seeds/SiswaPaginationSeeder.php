<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SiswaPaginationSeeder extends Seeder
{
    public function run()
    {
        $students = [
            ['nis' => '1005', 'nama' => 'Andi Saputra', 'kelas' => 'XI RPL 1'],
            ['nis' => '1006', 'nama' => 'Bella Putri', 'kelas' => 'XI RPL 1'],
            ['nis' => '1007', 'nama' => 'Candra Wijaya', 'kelas' => 'XI RPL 1'],
            ['nis' => '1008', 'nama' => 'Dinda Maharani', 'kelas' => 'XI RPL 1'],
            ['nis' => '1009', 'nama' => 'Eko Prasetyo', 'kelas' => 'XI RPL 2'],
            ['nis' => '1010', 'nama' => 'Farah Nabila', 'kelas' => 'XI RPL 2'],
            ['nis' => '1011', 'nama' => 'Gilang Ramadhan', 'kelas' => 'XI RPL 2'],
            ['nis' => '1012', 'nama' => 'Hana Safitri', 'kelas' => 'XI RPL 2'],
            ['nis' => '1013', 'nama' => 'Ilham Maulana', 'kelas' => 'XI RPL 3'],
            ['nis' => '1014', 'nama' => 'Jihan Amelia', 'kelas' => 'XI RPL 3'],
            ['nis' => '1015', 'nama' => 'Kevin Firmansyah', 'kelas' => 'XI RPL 3'],
            ['nis' => '1016', 'nama' => 'Laila Zahra', 'kelas' => 'XI RPL 3'],
            ['nis' => '1017', 'nama' => 'Miko Alfarizi', 'kelas' => 'XI RPL 3'],
            ['nis' => '1018', 'nama' => 'Nadia Aulia', 'kelas' => 'XI RPL 3'],
        ];

        $nisList = array_column($students, 'nis');
        $existingNis = array_column(
            $this->db->table('siswa')
                ->select('nis')
                ->whereIn('nis', $nisList)
                ->get()
                ->getResultArray(),
            'nis'
        );

        $studentsToInsert = array_values(array_filter(
            $students,
            static fn (array $student): bool => ! in_array($student['nis'], $existingNis, true)
        ));

        if ($studentsToInsert !== []) {
            $this->db->table('siswa')->insertBatch($studentsToInsert);
        }
    }
}
