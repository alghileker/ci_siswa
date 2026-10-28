<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use CodeIgniter\HTTP\RedirectResponse;

class Home extends BaseController
{
    public function index(): string
    {
        $siswaModel = new SiswaModel();
        $search = trim((string) $this->request->getGet('q'));
        $perPage = (int) ($this->request->getGet('per_page') ?? 10);

        if (! in_array($perPage, [5, 10, 25, 50], true)) {
            $perPage = 10;
        }

        if ($search !== '') {
            $siswaModel->groupStart()
                ->like('nis', $search)
                ->orLike('nama', $search)
                ->orLike('kelas', $search)
                ->groupEnd();
        }

        $siswaModel->orderBy('nis', 'ASC');
        $siswa = $siswaModel->paginate($perPage);
        $siswaModel->pager->only(['q', 'per_page']);

        return view('siswa_view', [
            'siswa'   => $siswa,
            'pager'   => $siswaModel->pager,
            'search'  => $search,
            'perPage' => $perPage,
        ]);
    }

    public function tambah(): RedirectResponse
    {
        $rules = [
            'nis'   => 'required',
            'nama'  => 'required',
            'kelas' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validationErrors', $this->validator->getErrors())
                ->with('showTambahModal', true);
        }

        $siswaModel = new SiswaModel();
        $saved = $siswaModel->save([
            'nis'   => $this->request->getPost('nis'),
            'nama'  => $this->request->getPost('nama'),
            'kelas' => $this->request->getPost('kelas'),
        ]);

        if (! $saved) {
            $errors = $siswaModel->errors();
            if ($errors === []) {
                $errors['database'] = 'Data siswa gagal disimpan. Silakan coba lagi.';
            }

            return redirect()->back()
                ->withInput()
                ->with('validationErrors', $errors)
                ->with('showTambahModal', true);
        }

        return redirect()->to(base_url());
    }

    public function update(int $id): RedirectResponse
    {
        $siswaModel = new SiswaModel();

        if ($siswaModel->find($id) === null) {
            return redirect()->to(base_url())
                ->with('updateError', 'Data siswa tidak ditemukan.');
        }

        $rules = [
            'nis'   => 'required',
            'nama'  => 'required',
            'kelas' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('editValidationErrors', $this->validator->getErrors())
                ->with('showEditModalId', $id);
        }

        $updated = $siswaModel->updateSiswa($id, [
            'nis'   => $this->request->getPost('nis'),
            'nama'  => $this->request->getPost('nama'),
            'kelas' => $this->request->getPost('kelas'),
        ]);

        if (! $updated) {
            $errors = $siswaModel->errors();
            if ($errors === []) {
                $errors['database'] = 'Data siswa gagal diperbarui. Silakan coba lagi.';
            }

            return redirect()->back()
                ->withInput()
                ->with('editValidationErrors', $errors)
                ->with('showEditModalId', $id);
        }

        return redirect()->to(base_url());
    }

    public function hapus(int $id): RedirectResponse
    {
        $siswaModel = new SiswaModel();

        if ($siswaModel->find($id) === null) {
            return redirect()->to(base_url())
                ->with('deleteError', 'Data siswa tidak ditemukan.');
        }

        if (! $siswaModel->delete($id)) {
            return redirect()->to(base_url())
                ->with('deleteError', 'Data siswa gagal dihapus. Silakan coba lagi.');
        }

        return redirect()->to(base_url());
    }
}
