<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
<style>
  body {
    background-image: url('<?php echo validate_image($_settings->info('cover')) ?>');
    background-size: cover;
    background-repeat: no-repeat;
  }
</style>

<body class="hold-transition login-page ">
  <script>
    start_loader()
  </script>
  <?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
      alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
  <?php endif; ?>
  <h2 class="text-center pb-4 mb-4 text-light"><?php echo $_settings->info('name') ?> Log-In</h2>
  <div class="login-box" style="width: 400px;">
    <!-- /.login-logo -->
    <div class="card card-primary">
      <div class="card-body">
        <form id="login-frm" action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <i id="icon" class="fas fa-eye"></i>

              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-flat  btn-block mb-3">Login</button>
          <div class="row">
            <div class="col-4">
              <a href="<?php echo base_url ?>">Go to Portal</a>

            </div>
            <!-- /.col -->
            <div class="col-8  text-right">
              <span>Dont have account?</span>
              <a href='http://localhost/traffic_offense/admin/signup.php'>signup</a>
            </div>
            <!-- /.col -->

          </div>
        </form>
        <!-- /.social-auth-links -->

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <script src="/../traffic_offense/assets/js/passwordVisibility.js"></script>

  <script>
    $(document).ready(function() {

      end_loader();
    })
  </script>
</body>

</html>