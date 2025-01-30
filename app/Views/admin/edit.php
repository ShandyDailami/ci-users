<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<div class="container d-flex flex-column align-items-center justify-content-center py-3" style="min-height: 100vh;">
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
      <h5 class="card-title text-center">Edit</h5>
      <form action="/admin/update/<?= esc($user['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <!-- <div class="mb-3">
          <label for="profile" class="form-label d-block">Profile</label>
          <img src="<?= base_url('uploads/' . esc($user['path'])) ?>" alt="Profile"
            class="img-thumbnail profile-medium mb-2">
          <input type="file" id="profile" name="path" class="form-control">
        </div> -->
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Username"
            value="<?= esc($user['username']) ?>">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
            value="<?= esc($user['email']) ?>">
        </div>
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" name="role" id="role" aria-label="role">
            <option selected disabled>Select Role</option>
            <option value="user" <?= (esc($user['role']) == 'user') ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= (esc($user['role']) == 'admin') ? 'selected' : '' ?>>Admin</option>
            <option value="super admin" <?= (esc($user['role']) == 'super admin') ? 'selected' : '' ?>>Super Admin
            </option>
            <option value="editor" <?= (esc($user['role']) == 'editor') ? 'selected' : '' ?>>Editor</option>
          </select>
        </div>
        <button type="submit" name="submit" class="btn btn-primary w-100 mb-3">Update</button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>