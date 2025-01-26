<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <?php if (session()->getFlashdata('message')): ?>
    <div class="position-fixed mt-2 me-2 top-0 end-0">
      <div class="alert alert-success flash-message">
        <?= session()->getFlashdata('message') ?>
      </div>
    </div>
  <?php endif ?>
  <div class="card col-md-4 mx-auto">
    <div class="card-body">
      <h5 class="card-title text-center">Sign In</h5>
      <form action="/signin" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" class="form-control">
        </div>
        <div class="mb-3 text-end">
          <a href="/forgotPassword">Forgot Password</a>
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
        <div class="text-center">
          Do you haven't account? <a href="/signup">Sign Up</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>