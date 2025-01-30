<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<nav class="navbar bg-body-tertiary border-bottom border-2">
  <div class="container d-flex justify-content-between">
    <i class="bi bi-list"></i>
    <div class="col-md-1 d-flex align-items-center justify-content-center" style="width: 30px;">
      <img class="rounded-circle img-fluid me-2" src="<?php echo base_url('uploads/' . $path); ?>" alt="">
      <div class="d-flex flex-column">
        <span style="cursor: pointer" class="fw-bold"><?= esc($username) ?></span>
        <span style="cursor: pointer" class="fs-6 text-capitalize"><?= esc($role) ?></span>
      </div>
    </div>
  </div>
</nav>
<div class="position-fixed mt-2 me-2 top-0 end-0">
  <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success flash-message">
      <?= session()->getFlashdata('message') ?>
    </div>
  <?php elseif (session()->getFlashdata('errors')): ?>
    <?php foreach (session()->getFlashdata('errors') as $error): ?>
      <div class="alert alert-danger flash-message">
        <?= esc($error) ?>
      </div>
    <?php endforeach ?>
  <?php endif ?>
</div>
<div class="row container-fluid" style="height: 92vh">

  <div class="col-2 p-0 border-end d-flex flex-column align-items-center justify-content-start">
    <h5 class="my-5 fw-bold">User Profile</h5>
    <div class="col-12 d-flex flex-column">
      <a href="/dashboard" class="text-decoration-none link-hover py-2 ps-4 fs-5 active">
        <i class="bi bi-person me-3"></i>User info
      </a>
      <a href="#" class="text-decoration-none link-hover py-2 ps-4 fs-5">
        <i class="bi bi-box me-3"></i>Item 1
      </a>
      <a href="#" class="text-decoration-none link-hover py-2 ps-4 fs-5">
        <i class="bi bi-box me-3"></i>Item 1
      </a>
      <a href="/admin/logout" class="text-decoration-none text-danger link-hover-danger py-2 ps-4 fs-5"><i
          class="bi bi-box-arrow-left me-3"></i>Log
        out</a>
    </div>
  </div>
  <div class="col-10 d-flex flex-column align-items-center justify-content-center ps-5 pe-0">
    <table class="table table-custom table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Image</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $index => $user): ?>
          <tr>
            <th scope="row"><?= $index + 1 ?></th>
            <td><img class="rounded img-fluid me-2 profile-small"
                src="<?php echo base_url('uploads/' . $user['path']); ?>" alt=""></td>
            <td><?= esc($user['username']) ?></td>
            <td><?= esc($user['email']) ?></td>
            <td><?= esc($user['role']) ?></td>
            <td>
              <button type="button" id="edit" data-id="<?= esc($user['id']) ?>"
                class="btn btn-sm btn-primary">Edit</button>
              <button type="button" data-bs-target="#delete" data-bs-toggle="modal" data-id="<?= esc($user['id']) ?>"
                class="btn btn-sm btn-danger">Delete</button>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus data ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
          <button type="button" class="btn btn-primary" id="confirm">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>