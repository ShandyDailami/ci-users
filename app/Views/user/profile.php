<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<nav class="navbar bg-body-tertiary border-bottom border-2">
  <div class="container d-flex justify-content-between">
    <i class="bi bi-list"></i>
    <div class="col-md-1 d-flex align-items-center justify-content-center" style="width: 30px;">
      <img class="rounded-circle img-fluid me-2" src="<?php echo base_url('uploads/' . $user['path']); ?>" alt="">
      <span style="cursor: pointer"><?= esc($user['username']) ?></span>
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
      <a href="/logout" class="text-decoration-none text-danger link-hover-danger py-2 ps-4 fs-5"><i
          class="bi bi-box-arrow-left me-3"></i>Log
        out</a>
    </div>
  </div>
  <div class="col-10 d-flex flex-column align-items-center justify-content-center ps-5 pe-0">
    <div class="d-flex align-items-center justify-content-start">
      <img class="rounded-circle img-fluid me-5 profile" src="<?php echo base_url('uploads/' . $user['path']); ?>"
        alt="">
      <span class="fs-4" style="cursor: pointer"><?= esc($user['username']) ?></span>
    </div>
    <form action="/update" method="post" class="d-flex flex-column align-items-center justify-content-center">
      <?= csrf_field() ?>
      <input type="hidden" name="id" value="<?= esc($user['id']) ?>">
      <div class="row mb-3">
        <div class="col">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username"
            value="<?= esc($user['username']) ?>">
        </div>
        <div class="col">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
            value="<?= esc($user['email']) ?>">
        </div>
      </div>
      <button type="submit" name="submit" class="btn btn-primary text-center">Update</button>
    </form>
  </div>
</div>
<?= $this->endSection('content') ?>