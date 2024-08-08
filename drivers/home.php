<?php if ($_settings->chk_flashdata('success')) : ?>
  <script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
  </script>
<?php endif; ?>

<h1 class="text-center">Officers Performance Data</h1>
<hr class="bg-light">

<!-- Main content -->
<section class="content">
  <div class="container-fluid">


    <div class="row">


      <!-- /.col -->
      <div class="col-md-9">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Top 10 Officer</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body ">
            <form method="POST">
              <div class="row justify-content-center">
                <div class="col-5">
                  <div class="form-group text-center">
                    <lable class="control-label" for="enforcers_name">Officer</lable>
                    <select name="enforcers_name" id="enforcers_name" class="custom-select select2" required>
                      <option value="">--Select Officer--</option>
                     
                    </select>
                  </div>

                </div>
                <div class="col-2 align-self-center mt-3 ">
                  <button type="submit" name="submit" value="submit" class="btn btn-success ">Filter</button>
                </div>
              </div>
            </form>
            <div class="chart">
              <canvas id="barChart" style="min-height: 320px; height: 320px; max-height: 320px; max-width: 100%;"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>






<script>

</script>