<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `impound_vehicle_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
if (isset($_GET['driver_id'])) {
    $driver_id = $_GET['driver_id'];
    $sql = $conn->query("SELECT `name` from `drivers_list` where id = '{$driver_id}' ");
    if ($sql->num_rows > 0) {
        foreach ($sql->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>
<style>
    .uploaded_img {
        width: 150px;
        height: 135px;
        object-fit: scale-down;
        object-position: center center;
    }

    .img-panel {
        width: 170px;
    }

    #parking_spot {
        border: 3px solid black;
        height: 90px;
        width: 105px;
        align-items: center;
        justify-content: center;
    }

    #parking_spots {
        border: 3px solid black;
        height: 90px;
        width: 102px;
        align-items: center;
        justify-content: center;
    }

    #park-icon {
        font-size: 70px;
        z-index: 1;
    }

    #status {
        font-size: 30px;
        z-index: 3;
    }

    .top-park {
        background-color: red;
    }

    #parking_spot {
        cursor: pointer;
        /* Set cursor to pointer to indicate clickable */
    }

    .legend {
        margin-bottom: 46px;
    }
</style>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> Impound Vehicle</h3>
    </div>
    <div class="card-body">
        <form action="" id="impound_vehicle_form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <input type="hidden" name="vehicle_owner" value="<?php echo isset($name) ? $name : '' ?>">

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <lable class="control-label" for="impound_no">Impound No.</lable>
                        <input type="text" class="form-control" name="impound_no" id="impound_no" autocomplete="off" value="<?php echo isset($impound_no) ? $impound_no : '' ?>" required>
                    </div>
                    <!--  <div class="form-group">
                        <lable class="control-label" for="vehicle_owner">Vehicle Owner</lable>
                        <select name="vehicle_owner" id="vehicle_owner" class="custom-select select2" required>
                            <option value="">--Select Vehicle Owner--</option>
                            <?php
                            $owner = $conn->query("SELECT DISTINCT offense_list.driver_id,drivers_list.license_id_no ,drivers_list.name FROM `offense_list`LEFT JOIN `drivers_list` ON offense_list.driver_id = drivers_list.id;");
                            while ($row = $owner->fetch_assoc()) :
                            ?>
                                <option <?php echo (isset($vehicle_owner) && $vehicle_owner == $row['name']) ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <lable class="control-label" for="vehicle_model">Vehicle Model</lable>
                        <input type="text" class="form-control" name="vehicle_model" id="vehicle_model" autocomplete="off" value="<?php echo isset($vehicle_model) ? $vehicle_model : '' ?>" required>
                    </div>

                </div>

                <hr>
                <div class="col-6">
                    <div class="form-group">
                        <lable class="control-label" for="parking_location">Parking Location</lable>
                        <select name="parking_location" id="parking_location" class="custom-select" required>
                            <option value="">--Select Location--</option>
                            <?php
                            $owner = $conn->query("SELECT *  FROM `parking_number` WHERE `availability` ='1'");
                            while ($row = $owner->fetch_assoc()) :
                            ?>
                                <option <?php echo (isset($parking_location) && $parking_location == $row['parking_location']) ? 'selected' : '' ?>> <?php echo ucwords($row['parking_location']) ?></option>
                            <?php endwhile; ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <lable class="control-label" for="status">Status</lable>
                        <select name="status" class="custom-select" required>
                            <option value="0" <?php echo (isset($status) && $status == '0') ? 'selected' : '' ?>>Detain</option>
                            <option value="1" <?php echo (isset($status) && $status == '1') ? 'selected' : '' ?>>Release</option>
                        </select>
                    </div>


                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="impound_vehicle_form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=impound_vehicle">Cancel</a>
    </div>
</div>
<div class="card card-outline card-dark">

    <div class="card-body ">
        <div class="d-flex  flex-wrap spot top-park ">
            <?php
            $qry = $conn->query("SELECT * from `parking_number` where `position` ='Top' ");

            while ($row = $qry->fetch_assoc()) :  ?>
                <div class=" gap-2" id="parking_spots">
                    <a href="javascript:void(0)" class="view_details badge " data-id="<?php echo $row['id'] ?>"><i id="park-icon" class="fas fa-motorcycle"></i></a>

                </div>
            <?php endwhile; ?>
        </div>

        <div class="d-flex justify-content-between ">
            <div class="d-flex spot flex-column">

                <?php
                $qry = $conn->query("SELECT * from `parking_number` where `position` ='Left'");

                while ($row = $qry->fetch_assoc()) :
                    $spotColor = ''; // Initialize spot color variable
                    // Check if impound_no is set and not empty
                    if (isset($row['impound_no']) && $row['impound_no'] != '') {
                        // Set spot color to green when condition is met
                        $spotColor = 'bg-success'; // Use a class or inline style for green color
                    }

                    // Fetch corresponding ID for the current row from $qry2
                    $qry2 = $conn->query("SELECT i.*, p.parking_location, p.availability, p.position, p.impound_no FROM impound_vehicle_list i LEFT JOIN parking_number p ON i.impound_no = p.impound_no WHERE p.id = '{$row['id']}'");
                    $id = ''; // Variable to store the fetched ID
                    if ($row2 = $qry2->fetch_assoc()) {
                        $id = $row2['id']; // Assuming 'id' is the column you want to pass
                    }
                ?>

                    <div class="d-flex gap-2" id="parking_spot">
                        <!-- Passing the fetched ID from $qry2 to the data-id attribute in the anchor tag -->
                        <a href="javascript:void(0)" class="view_details badge  <?php echo $spotColor ?>" data-id="<?php echo $id ?>"><i id="park-icon" class="fas fa-motorcycle"></i></a>

                    </div>

                <?php endwhile; ?>
            </div>
            <div class="d-flex flex-column mr-auto">
                <?php
                $qry = $conn->query("SELECT * from `parking_number` where `position` ='Left'");
                $total_rows = $qry->num_rows;
                $counter = 1;
                while ($row = $qry->fetch_assoc()) :
                ?>
                    <h1 class="<?php echo ($counter !== $total_rows) ? '' : 'mb-0'; ?> legend">
                        <?php echo $row['parking_location'] ?>
                    </h1>
                    <?php $counter++; ?>
                <?php endwhile ?>
            </div>

            <div class="d-flex flex-column ml-auto">
                <?php
                $qry = $conn->query("SELECT * from `parking_number` where `position` ='Right'");
                $total_rows = $qry->num_rows;
                $counter = 1;
                while ($row = $qry->fetch_assoc()) :
                ?>
                    <h1 class="<?php echo ($counter !== $total_rows) ? '' : 'mb-0'; ?> legend">
                        <?php echo $row['parking_location'] ?>
                    </h1>
                    <?php $counter++; ?>
                <?php endwhile ?>
            </div>




            <div class="d-flex spot flex-column">
                <?php
                $qry = $conn->query("SELECT * from `parking_number` where `position` ='Right'");
                while ($row = $qry->fetch_assoc()) :
                    $spotColor = ''; // Initialize spot color variable
                    // Check if impound_no is set and not empty
                    if (isset($row['impound_no']) && $row['impound_no'] != '') {
                        // Set spot color to green when condition is met
                        $spotColor = 'bg-success'; // Use a class or inline style for green color
                    }

                    // Fetch corresponding ID for the current row from $qry2
                    $qry2 = $conn->query("SELECT i.*, p.parking_location, p.availability, p.position, p.impound_no FROM impound_vehicle_list i LEFT JOIN parking_number p ON i.impound_no = p.impound_no WHERE p.id = '{$row['id']}'");
                    $id = ''; // Variable to store the fetched ID
                    if ($row2 = $qry2->fetch_assoc()) {
                        $id = $row2['id']; // Assuming 'id' is the column you want to pass
                    }
                ?>
                    <div class="d-flex gap-2" id="parking_spot">
                        <!-- Passing the fetched ID from $qry2 to the data-id attribute in the anchor tag -->
                        <a href="javascript:void(0)" class="view_details badge  <?php echo $spotColor ?>" data-id="<?php echo $id ?>"><i id="park-icon" class="fas fa-motorcycle"></i></a>
                        <p></p>
                    </div>
                <?php endwhile; ?>
            </div>


        </div>
        <div class="d-flex justify-content-between">
            <div class="d-flex spot ">
                <?php
                $qry = $conn->query("SELECT * from `parking_number` where `position` ='LeftBottom' ");
                while ($row = $qry->fetch_assoc()) :
                    $spotColor = ''; // Initialize spot color variable
                    // Check if impound_no is set and not empty
                    if (isset($row['impound_no']) && $row['impound_no'] != '') {
                        // Set spot color to green when condition is met
                        $spotColor = 'bg-success'; // Use a class or inline style for green color
                    }

                    // Fetch corresponding ID for the current row from $qry2
                    $qry2 = $conn->query("SELECT i.*, p.parking_location, p.availability, p.position, p.impound_no FROM impound_vehicle_list i LEFT JOIN parking_number p ON i.impound_no = p.impound_no WHERE p.id = '{$row['id']}'");
                    $id = ''; // Variable to store the fetched ID
                    if ($row2 = $qry2->fetch_assoc()) {
                        $id = $row2['id']; // Assuming 'id' is the column you want to pass
                    }
                ?>
                    <div class="d-flex gap-2" id="parking_spot">
                        <!-- Passing the fetched ID from $qry2 to the data-id attribute in the anchor tag -->
                        <a href="javascript:void(0)" class="view_details badge  <?php echo $spotColor ?>" data-id="<?php echo $id ?>"><i id="park-icon" class="fas fa-motorcycle"></i></a>
                        <p></p>
                    </div>
                <?php endwhile; ?>
            </div>


            <div class="d-flex spot ">
                <?php
                $qry = $conn->query("SELECT * from `parking_number` where `position` ='RightBottom' ");
                while ($row = $qry->fetch_assoc()) :
                    $spotColor = ''; // Initialize spot color variable
                    // Check if impound_no is set and not empty
                    if (isset($row['impound_no']) && $row['impound_no'] != '') {
                        // Set spot color to green when condition is met
                        $spotColor = 'bg-success'; // Use a class or inline style for green color
                    }

                    // Fetch corresponding ID for the current row from $qry2
                    $qry2 = $conn->query("SELECT i.*, p.parking_location, p.availability, p.position, p.impound_no FROM impound_vehicle_list i LEFT JOIN parking_number p ON i.impound_no = p.impound_no WHERE p.id = '{$row['id']}'");
                    $id = ''; // Variable to store the fetched ID
                    if ($row2 = $qry2->fetch_assoc()) {
                        $id = $row2['id']; // Assuming 'id' is the column you want to pass
                    }
                ?>
                    <div class="d-flex gap-2" id="parking_spot">
                        <!-- Passing the fetched ID from $qry2 to the data-id attribute in the anchor tag -->
                        <a href="javascript:void(0)" class="view_details badge  <?php echo $spotColor ?>" data-id="<?php echo $row2['id'] ?>"><i id="park-icon" class="fas fa-motorcycle"></i></a>
                        <p></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="d-flex flex-row">
                <h1 class="mr-5">LB1</h1>
                <h1 class="mr-5">LB2</h1>
                <h1 class="mr-5">LB3</h1>
            </div>
            <div class="d-flex flex-row">
                <h1 class="ml-5">RB1</h1>
                <h1 class="ml-5">RB2</h1>
                <h1 class="ml-5">RB3</h1>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#impound_vehicle_form').submit(function(e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_impound_vehicle",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An error occured", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=impound_vehicle";
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").animate({
                            scrollTop: _this.closest('.card').offset().top
                        }, "fast");
                        end_loader()
                    } else {
                        alert_toast("An errorf occured", 'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        })
    })
</script>