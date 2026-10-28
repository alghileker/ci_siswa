<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Siswa XI RPL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --background: #f9fafb;
            --surface: #ffffff;
            --border: #e5e7eb;
            --text: #334155;
            --muted: #64748b;
            --primary: #334155;
            --hover: #f8fafc;
        }
        html { scroll-behavior: smooth; }
        body { margin: 0; color: var(--text); background: var(--background); font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        .topbar { height: 64px; background: var(--surface); border-bottom: 1px solid var(--border); }
        .brand { color: var(--text); text-decoration: none; font-size: 16px; font-weight: 700; }
        .management-card { border: 1px solid var(--border); border-radius: 10px; background: var(--surface); box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04); }
        .card-header-clean { border-bottom: 1px solid var(--border); background: var(--surface); border-radius: 10px 10px 0 0; }
        .title { font-size: 17px; font-weight: 700; color: var(--text); }
        .total-badge { border: 1px solid var(--border); border-radius: 999px; color: var(--muted); background: var(--background); font-size: 12px; font-weight: 600; padding: 5px 10px; }
        .btn-add { min-height: 38px; border: 1px solid var(--primary); border-radius: 7px; background: var(--primary); color: #fff; font-weight: 600; padding: 8px 12px; }
        .btn-add:hover, .btn-add:focus { background: #1e293b; border-color: #1e293b; color: #fff; }
        .control-select { width: 76px; border-color: var(--border); border-radius: 7px; }
        .search-box { position: relative; width: 260px; }
        .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
        .search-box input { padding-left: 36px; border-color: var(--border); border-radius: 7px; }
        .search-box input:focus, .control-select:focus, .form-control:focus { border-color: #94a3b8; box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.14); }
        .table-scroll { overflow-x: auto; width: 100%; -webkit-overflow-scrolling: touch; scrollbar-color: #cbd5e1 transparent; }
        .student-table { min-width: 720px; margin-bottom: 0; border-collapse: separate; border-spacing: 0; }
        .student-table thead th { border-top: 0; border-bottom: 1px solid var(--border); border-left: 0; border-right: 0; color: var(--muted); background: var(--background); font-size: 12px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; padding: 12px; }
        .student-table tbody td, .student-table tbody th { border-color: var(--border); border-left: 0; border-right: 0; padding: 13px 12px; background: var(--surface); transition: background-color .15s ease; }
        .student-table tbody tr:hover td, .student-table tbody tr:hover th { background: var(--hover); }
        .icon-action { width: 36px; height: 36px; border-radius: 7px; display: inline-grid; place-items: center; border: 1px solid var(--border); background: var(--surface); transition: background .15s ease, border-color .15s ease, transform .15s ease; text-decoration: none; }
        .icon-action:hover { transform: translateY(-1px); }
        .icon-edit { color: #b45309; }
        .icon-edit:hover { border-color: #f59e0b; background: #fffbeb; color: #92400e; }
        .icon-delete { color: #b91c1c; }
        .icon-delete:hover { border-color: #ef4444; background: #fff1f2; color: #991b1b; }
        .pagination-nav { min-height: 36px; }
        .pager-btn { min-width: 92px; height: 36px; border-radius: 7px; border: 1px solid var(--border); background: var(--surface); color: var(--text); display: inline-flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none; font-size: 13px; font-weight: 600; }
        .pager-btn:hover { border-color: #94a3b8; background: var(--hover); color: var(--text); }
        .pager-btn.disabled { color: #cbd5e1; background: var(--background); pointer-events: none; }
        .modal-content { border: 1px solid var(--border); border-radius: 10px; box-shadow: 0 16px 40px rgba(15, 23, 42, 0.14); }
        .modal-header { border-bottom-color: var(--border); }
        .modal-footer { border-top-color: var(--border); }
        @media (max-width: 575.98px) {
            .search-box { width: 100%; }
            .toolbar-control, .toolbar-search { width: 100%; }
            .card-body-clean { padding: 16px !important; }
            .summary-row { width: 100%; }
        }
    </style>
</head>
<body>
<?php
$validationErrors = session()->getFlashdata('validationErrors') ?? [];
$showTambahModal = session()->getFlashdata('showTambahModal') ?? false;
$editValidationErrors = session()->getFlashdata('editValidationErrors') ?? [];
$showEditModalId = session()->getFlashdata('showEditModalId');
$updateError = session()->getFlashdata('updateError');
$deleteError = session()->getFlashdata('deleteError');
$currentPage = $pager->getCurrentPage();
$totalPages = $pager->getPageCount();
$start = ($currentPage - 1) * $perPage + 1;
$total = $pager->getTotal();
?>

<header class="topbar d-flex align-items-center">
    <div class="container px-3">
        <a class="brand" href="<?= base_url() ?>"><i class="fa-solid fa-graduation-cap me-2 text-secondary"></i>Data Siswa XI RPL</a>
    </div>
</header>

<main class="container py-4 px-3">
    <section class="management-card">
        <div class="card-header-clean px-3 px-md-4 py-3">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h1 class="title mb-0">Daftar Siswa Terdaftar</h1>
                    <span class="total-badge">Total Siswa: <?= esc((string) $total) ?></span>
                </div>
                <button type="button" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah" title="Tambah Data">
                    <i class="fa-solid fa-plus me-1" aria-hidden="true"></i> Tambah Data
                </button>
            </div>
        </div>

        <div class="card-body card-body-clean p-4">
            <?php if ($deleteError): ?><div class="alert alert-danger py-2"><?= esc($deleteError) ?></div><?php endif; ?>
            <?php if ($updateError): ?><div class="alert alert-danger py-2"><?= esc($updateError) ?></div><?php endif; ?>
            <?php if (isset($validationErrors['database'])): ?><div class="alert alert-danger py-2"><?= esc($validationErrors['database']) ?></div><?php endif; ?>
            <?php if (isset($editValidationErrors['database'])): ?><div class="alert alert-danger py-2"><?= esc($editValidationErrors['database']) ?></div><?php endif; ?>

            <div class="d-flex justify-content-between align-items-center gap-3 mb-3 flex-wrap">
                <form method="get" class="toolbar-control d-flex align-items-center gap-2">
                    <label for="perPage" class="text-muted small text-nowrap mb-0">Tampilkan</label>
                    <select id="perPage" name="per_page" class="form-select form-select-sm control-select" onchange="this.form.submit()">
                        <?php foreach ([5, 10, 25, 50] as $option): ?>
                            <option value="<?= $option ?>" <?= $option === $perPage ? 'selected' : '' ?>><?= $option ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($search !== ''): ?><input type="hidden" name="q" value="<?= esc($search) ?>"><?php endif; ?>
                </form>
                <form method="get" class="toolbar-search search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input class="form-control form-control-sm" type="search" name="q" value="<?= esc($search) ?>" placeholder="Cari siswa..." aria-label="Cari siswa">
                    <input type="hidden" name="per_page" value="<?= $perPage ?>">
                </form>
            </div>

            <div class="table-scroll" id="studentTableScroll" aria-label="Tabel data siswa dapat digeser secara horizontal">
                <table class="table student-table align-middle text-center">
                    <thead><tr><th scope="col" style="width:70px">No</th><th scope="col">NIS</th><th scope="col">Nama</th><th scope="col">Kelas</th><th scope="col" style="width:120px">Aksi</th></tr></thead>
                    <tbody>
                    <?php if (! empty($siswa)): ?>
                        <?php $no = $start; foreach ($siswa as $row): ?>
                        <tr>
                            <th scope="row"><?= $no++ ?></th>
                            <td><?= esc($row['nis']) ?></td>
                            <td class="text-start fw-semibold"><?= esc($row['nama']) ?></td>
                            <td><?= esc($row['kelas']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="button" class="icon-action icon-edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= esc($row['id']) ?>" title="Edit <?= esc($row['nama']) ?>" aria-label="Edit <?= esc($row['nama']) ?>">
                                        <i class="fa-solid fa-pencil"></i>
                                    </button>
                                    <a href="<?= base_url('home/hapus/' . $row['id']) ?>" class="icon-action icon-delete" title="Hapus <?= esc($row['nama']) ?>" aria-label="Hapus <?= esc($row['nama']) ?>" onclick="return confirm('Yakin ingin menghapus <?= esc($row['nama'], 'js') ?>?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="py-5 text-muted"><i class="fa-solid fa-inbox d-block fs-4 mb-2"></i><?= $search !== '' ? 'Data siswa tidak ditemukan.' : 'Belum ada data siswa.' ?></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mt-3 summary-row">
                <small class="text-muted">
                    <?php if (! empty($siswa)): ?>Menampilkan <?= $start ?>–<?= $start + count($siswa) - 1 ?> dari <?= $total ?> data
                    <?php else: ?>Menampilkan 0 data<?php endif; ?>
                </small>
                <nav class="pagination-nav d-flex gap-2" aria-label="Navigasi halaman siswa">
                    <a class="pager-btn <?= $currentPage <= 1 ? 'disabled' : '' ?>" href="<?= $currentPage > 1 ? esc($pager->getPageURI($currentPage - 1)) : '#' ?>" aria-disabled="<?= $currentPage <= 1 ? 'true' : 'false' ?>">
                        <i class="fa-solid fa-chevron-left"></i> Previous
                    </a>
                    <a class="pager-btn <?= $currentPage >= $totalPages ? 'disabled' : '' ?>" href="<?= $currentPage < $totalPages ? esc($pager->getPageURI($currentPage + 1)) : '#' ?>" aria-disabled="<?= $currentPage >= $totalPages ? 'true' : 'false' ?>">
                        Next <i class="fa-solid fa-chevron-right"></i>
                    </a>
                </nav>
            </div>

            <?php foreach ($siswa as $row): ?>
            <div class="modal fade" id="modalEdit<?= esc($row['id']) ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
                    <form action="<?= base_url('home/update/' . $row['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header"><h5 class="modal-title title"><i class="fa-solid fa-pencil me-2 text-secondary"></i>Edit Data Siswa</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
                        <div class="modal-body">
                            <div class="mb-3"><label class="form-label" for="editNis<?= esc($row['id']) ?>">NIS</label><input class="form-control" id="editNis<?= esc($row['id']) ?>" name="nis" value="<?= esc(old('nis') ?? $row['nis']) ?>" required></div>
                            <div class="mb-3"><label class="form-label" for="editNama<?= esc($row['id']) ?>">Nama</label><input class="form-control" id="editNama<?= esc($row['id']) ?>" name="nama" value="<?= esc(old('nama') ?? $row['nama']) ?>" required></div>
                            <div class="mb-3"><label class="form-label" for="editKelas<?= esc($row['id']) ?>">Kelas</label><input class="form-control" id="editKelas<?= esc($row['id']) ?>" name="kelas" value="<?= esc(old('kelas') ?? $row['kelas']) ?>" required></div>
                        </div>
                        <div class="modal-footer"><button class="btn btn-light border" type="button" data-bs-dismiss="modal">Batal</button><button class="btn btn-dark" type="submit">Update Data</button></div>
                    </form>
                </div></div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
        <form action="<?= base_url('home/tambah') ?>" method="post">
            <?= csrf_field() ?>
            <div class="modal-header"><h5 class="modal-title title"><i class="fa-solid fa-user-plus me-2 text-secondary"></i>Tambah Data Siswa</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label for="nis" class="form-label">NIS</label><input type="text" class="form-control <?= isset($validationErrors['nis']) ? 'is-invalid' : '' ?>" id="nis" name="nis" value="<?= esc(old('nis') ?? '') ?>" required><?php if (isset($validationErrors['nis'])): ?><div class="invalid-feedback"><?= esc($validationErrors['nis']) ?></div><?php endif; ?></div>
                <div class="mb-3"><label for="nama" class="form-label">Nama</label><input type="text" class="form-control <?= isset($validationErrors['nama']) ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= esc(old('nama') ?? '') ?>" required><?php if (isset($validationErrors['nama'])): ?><div class="invalid-feedback"><?= esc($validationErrors['nama']) ?></div><?php endif; ?></div>
                <div class="mb-3"><label for="kelas" class="form-label">Kelas</label><input type="text" class="form-control <?= isset($validationErrors['kelas']) ? 'is-invalid' : '' ?>" id="kelas" name="kelas" value="<?= esc(old('kelas') ?? '') ?>" required><?php if (isset($validationErrors['kelas'])): ?><div class="invalid-feedback"><?= esc($validationErrors['kelas']) ?></div><?php endif; ?></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-dark">Simpan Data</button></div>
        </form>
    </div></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const tableScroll = document.getElementById('studentTableScroll');
    if (tableScroll && window.matchMedia('(pointer: fine)').matches) {
        tableScroll.addEventListener('wheel', event => {
            if (tableScroll.scrollWidth > tableScroll.clientWidth && Math.abs(event.deltaY) > Math.abs(event.deltaX)) {
                event.preventDefault();
                tableScroll.scrollLeft += event.deltaY;
            }
        }, { passive: false });
    }
</script>
<?php if ($showTambahModal): ?><script>document.addEventListener('DOMContentLoaded',()=>bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTambah')).show())</script><?php endif; ?>
<?php if ($showEditModalId !== null): ?><script>document.addEventListener('DOMContentLoaded',()=>{const modal=document.getElementById('modalEdit<?= esc($showEditModalId) ?>');if(modal)bootstrap.Modal.getOrCreateInstance(modal).show()})</script><?php endif; ?>
</body>
</html>