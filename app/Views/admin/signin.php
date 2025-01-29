<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
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
    <?php elseif (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger flash-message">
        <?= session()->getFlashdata('error') ?>
      </div>
    <?php endif ?>
  </div>
  <div class="card col-md-4 mx-auto">
    <div class="card-body">
      <h5 class="card-title text-center">Sign In</h5>
      <form action="/admin/signin" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="username" class="form-label">Username or Email</label>
          <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" name="role" id="role" aria-label="role">
            <option selected disabled>Select Role</option>
            <option value="admin">Admin</option>
            <option value="super admin">Super Admin</option>
            <option value="editor">Editor</option>
          </select>
        </div>
        <div class="mb-3 text-end">
          <a href="/admin/forgotPassword">Forgot Password</a>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100 mb-3">Sign In</button>
        <div class="text-center">
          Do you haven't account? <a href="/admin/signup">Sign Up</a>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>