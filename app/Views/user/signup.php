<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<div class="container d-flex flex-column align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="d-flex flex-column mt-2 me-2 top-0 end-0 position-fixed">
    <?php if (session()->getFlashdata('errors')): ?>
      <?php foreach (session()->getFlashdata('errors') as $error): ?>
        <div class="alert alert-danger flash-message">
          <?= esc($error) ?>
        </div>
      <?php endforeach ?>
    <?php endif ?>
  </div>
  <div class="card col-md-4 mx-auto">
    <div class="card-body">
      <h5 class="card-title text-center">Sign Up</h5>
      <form action="/signup" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="profile" class="form-label">Profile</label>
          <input type="file" id="profile" name="profile" class="form-control">
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username"
            value="<?= old('username') ?>">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
            value="<?= old('email') ?>">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control">
        </div>
        <input type="hidden" name="role" value="user">
        <button type="submit" name="submit" class="btn btn-primary w-100 mb-3">Sign Up</button>
        <div class="text-center">
          Do you have account? <a href="/signin">Sign In</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>