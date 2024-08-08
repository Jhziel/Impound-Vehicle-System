<div class="row">
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-light elevation-1"><i class="fas fa-calendar-day"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Today's Offences</span>
                <span class="info-box-number text-right">
                    <?php
                    $offense = $conn->query("SELECT * FROM `offense_list` where date(date_created) = '" . date('Y-m-d') . "' ")->num_rows;
                    echo number_format($offense);
                    
                    ?>
                    
                    
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-id-card"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">This Month Offences</span>
                <span class="info-box-number text-right">
                    <?php
                    $offenses_this_month = $conn->query("SELECT * FROM `offense_list` WHERE MONTH(date_created) = MONTH(CURDATE()) AND YEAR(date_created) = YEAR(CURDATE())")->num_rows;
                    echo number_format($offenses_this_month);
                    ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-4">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-traffic-light"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">This Year Total Offences</span>
                <span class="info-box-number text-right">
                    <?php
                    // Get the current year
                    $current_year = date('Y');

                    // SQL query to count offenses for the current year
                    $offenses_current_year = $conn->query("SELECT * FROM `offense_list` WHERE YEAR(date_created) = $current_year")->num_rows;

                    echo number_format($offenses_current_year);
                    ?>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>