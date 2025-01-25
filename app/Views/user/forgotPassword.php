<?= $this->extend('template/main') ?>
<?= $this->section('content') ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
  <div class="card col-md-4 mx-auto">
    <div class="card-body">
      <h5 class="card-title text-center">Forgot Password</h5>
      <form action="/forgotPassword" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" placeholder="name@example.com">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" class="form-control">
        </div>
        <!-- <div class="mb-3">
          <label for="confirmPassword" class="form-label">Confirm Password</label>
          <input type="password" id="confirmPassword" class="form-control">
        </div> -->
        <button type="submit" class="btn btn-primary w-100 mb-3">Submit</button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection('content') ?>