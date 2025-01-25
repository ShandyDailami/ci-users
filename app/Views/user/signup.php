<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="card col-md-4 mx-auto">
    <div class="card-body">
      <h5 class="card-title text-center">Sign Up</h5>
      <form action="/signup" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="profile" class="form-label">Profile</label>
          <input type="file" id="profile" class="form-control">
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" placeholder="name@example.com">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" class="form-control">
        </div>
        <input type="hidden" name="" value="user">
        <button type="submit" class="btn btn-primary w-100 mb-3">Sign Up</button>
        <div class="text-center">
          Do you have account? <a href="/signin">Sign In</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>