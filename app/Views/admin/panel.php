<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<nav class="navbar bg-body-tertiary border-bottom border-2">
  <div class="container d-flex justify-content-between">
    <i class="bi bi-list"></i>
    <div class="col-md-1 d-flex align-items-center justify-content-center" style="width: 30px;">
      <img class="rounded-circle img-fluid me-2" src="<?php echo base_url('uploads/' . $admin['path']); ?>" alt="">
      <span style="cursor: pointer"><?= esc($admin['username']) ?></span>
    </div>
  </div>
</nav>
<h1>masuk bang</h1>
<a href="/admin/logout" class="btn btn-danger">logout</a>
<?= $this->endSection('content') ?>