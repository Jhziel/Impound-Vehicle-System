<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `offense_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
    $qry = $conn->query("SELECT * from `impound_vehicle_list` where impound_no = '{$ticket_no}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            ${"impound_vehicle_" . $k} = $v;
        }
    }
}
?>
<style>
    .modal-confirm {
        color: #636363;
        width: 325px;
    }

    .modal-confirm .modal-content {
        padding: 20px;
        border-radius: 5px;
        border: none;
    }

    .modal-confirm .modal-header {
        border-bottom: none;
        position: relative;
    }

    .modal-confirm h4 {
        text-align: center;
        font-size: 26px;
        margin: 30px 0 -15px;
    }

    .modal-confirm .form-control,
    .modal-confirm .btn {
        min-height: 40px;
        border-radius: 3px;
    }

    .modal-confirm .close {
        position: absolute;
        top: -5px;
        right: -5px;
    }

    .modal-confirm .modal-footer {
        border: none;
        text-align: center;
        border-radius: 5px;
        font-size: 13px;
    }

    .modal-confirm .icon-box {
        color: #fff;
        position: absolute;
        margin: 0 auto;
        left: 0;
        right: 0;
        top: -70px;
        width: 95px;
        height: 95px;
        border-radius: 50%;
        z-index: 9;
        background: #ef513a;
        padding: 15px;
        text-align: center;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    }

    .modal-confirm .icon-box i {
        font-size: 56px;
        position: relative;
        top: 4px;
    }

    .modal-confirm.modal-dialog {
        margin-top: 80px;
    }

    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
        background: #ef513a;
        text-decoration: none;
        transition: all 0.4s;
        line-height: normal;
        border: none;
    }

    .modal-confirm .btn:hover,
    .modal-confirm .btn:focus {
        background: #da2c12;
        outline: none;
    }

    .trigger-btn {
        display: inline-block;
        margin: 100px auto;
    }

    .img-panel {
        width: 170px;
    }

    .parking_spot {
        border: 3px solid black;
        height: 90px;
        width: 68.5px;
        align-items: center;
        justify-content: center;
    }

    #parking_spots {
        border: 3px solid black;
        height: 90px;
        width: 68.5px;
        align-items: center;
        justify-content: center;
    }

    #park-icon {
        font-size: 27px;
        z-index: 1;
    }

    #park-icon-top {
        margin-top: 10px;
        font-size: 45px;
        z-index: 1;
    }

    #parking_spot {
        cursor: pointer;
        /* Set cursor to pointer to indicate clickable */
    }

    .legend {
        margin-bottom: 44px;
    }

    #legends {
        width: 100px;
    }

    .assignParkingSpot {
        cursor: pointer;
    }
</style>
<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> Impound Vehicle Record</h3>
        <div class="card-tools">
            <a href="?page=impound_vehicle" class="btn btn-outline-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button class="btn btn-danger mr-2" id="clear-all">
                <i class="fas fa-times"></i> Clear All
            </button>
            <button class="btn btn-primary" form="offense-form">
                <i class="fas fa-save"></i> Save
            </button>

        </div>
    </div>
    <div class="card-body">
        <form action="" id="offense-form">
            <input type="hidden" name="id" id="id" value="<?php echo isset($id) ? $id : '' ?>">
            <input type="hidden" name="parking_location" id="parking_location" value=" <?php echo isset($impound_vehicle_parking_location) ? $impound_vehicle_parking_location : '' ?>">
            <input type="hidden" name="category" value="impound">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <lable class="control-label" for="date_created">Date Violated</lable><span class="text-danger h5">*</span>
                        <input type="datetime-local" class="form-control" name="date_created" id="date_created" value="<?php echo isset($date_created) ? date("Y-m-d\\TH:i", strtotime($date_created)) : date("Y-m-d\\TH:i") ?>" required>
                    </div>
                    <div class="form-group">
                        <lable class="control-label" for="ticket_no">Ticket No.</lable><span class="text-danger h5">*</span>
                        <input type="text" class="form-control" name="ticket_no" id="ticket_no" autocomplete="off" value="<?php echo isset($ticket_no) ? $ticket_no : '' ?>" required>
                        <div class="invalid-feedback">
                            Please do not enter a Special Character expect for Hypen
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <div class="form-group">
                                <lable class="control-label" for="driver_id">Driver</lable><span class="text-danger h5">*</span>
                                <select name="driver_id" id="driver_id" class="custom-select select2" required>
                                    <option value="">--Select Driver--</option>
                                    <?php
                                    $driver = $conn->query("SELECT * FROM `drivers_list` WHERE status ='1'order by `name` asc ");
                                    while ($row = $driver->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['id'] ?>" <?php echo (isset($driver_id) && $driver_id == $row['id']) ? 'selected' : '' ?>>[<?php echo $row['license_id_no'] ?>] <?php echo ucwords($row['name']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <span class="ml-2"><a href="javascript:void(0)" class="add_driver btn btn-primary pb-1 mt-4 text-light"> Add Driver</a></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <lable class="control-label" for="vehicle_type">Vehicle Type</lable><span class="text-danger h5">*</span>
                        <select name="vehicle_type" id="vehicle_type" class="custom-select" required>
                            <option value="">--Select Vehicle Type--</option>
                            <option <?php echo (isset($impound_vehicle_vehicle_type) && $impound_vehicle_vehicle_type == 'Motorcycle') ? 'selected' : '' ?>>Motorcycle</option>
                            <option <?php echo (isset($impound_vehicle_vehicle_type) && $impound_vehicle_vehicle_type == 'Tricycle') ? 'selected' : '' ?>>Tricycle</option>
                            <option <?php echo (isset($impound_vehicle_vehicle_type) && $impound_vehicle_vehicle_type == 'Sedan') ? 'selected' : '' ?>>Sedan</option>
                            <option <?php echo (isset($impound_vehicle_vehicle_type) && $impound_vehicle_vehicle_type == 'Vans') ? 'selected' : '' ?>>Vans</option>
                            <option <?php echo (isset($impound_vehicle_vehicle_type) && $impound_vehicle_vehicle_type == 'SUV') ? 'selected' : '' ?>>SUV</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <lable class="control-label" for="ownership">Ownership</lable><span class="text-danger h5">*</span>
                        <select name="ownership" class="custom-select" required>
                            <option <?php echo (isset($impound_vehicle_ownership) && $impound_vehicle_ownership == 'Private') ? 'selected' : '' ?>>Private</option>
                            <option <?php echo (isset($impound_vehicle_ownership) && $impound_vehicle_ownership == 'Public') ? 'selected' : '' ?>>Public</option>
                            <option <?php echo (isset($impound_vehicle_ownership) && $impound_vehicle_ownership == 'Goverment') ? 'selected' : '' ?>>Goverment</option>
                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <lable class="control-label" for="location_of_incident">Location of Incident</lable><span class="text-danger h5">*</span>
                        <select name="location_of_incident" id="location_of_incident" class="custom-select" required>
                            <option value="">--Select Location--</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Baclaran') ? 'selected' : '' ?>>Baclaran</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Banay-Banay') ? 'selected' : '' ?>>Banay-Banay</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Banlic') ? 'selected' : '' ?>>Banlic</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Bigaa') ? 'selected' : '' ?>>Bigaa</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Butong') ? 'selected' : '' ?>>Butong</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Casile') ? 'selected' : '' ?>>Casile</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Diezmo') ? 'selected' : '' ?>>Diezmo</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Gulod') ? 'selected' : '' ?>>Gulod</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Mamatid') ? 'selected' : '' ?>>Mamatid</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Marinig') ? 'selected' : '' ?>>Marinig</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Niugan') ? 'selected' : '' ?>>Niugan</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Pittland') ? 'selected' : '' ?>>Pittland</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Pulo') ? 'selected' : '' ?>>Pulo</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Sala') ? 'selected' : '' ?>>Sala</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'San Isidro') ? 'selected' : '' ?>>San Isidro</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Poblacion I') ? 'selected' : '' ?>>Poblacion I</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Poblacion II') ? 'selected' : '' ?>>Poblacion II</option>
                            <option <?php echo (isset($location_of_incident) && $location_of_incident == 'Poblacion III') ? 'selected' : '' ?>>Poblacion III</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <lable class="control-label" for="plate_no">Plate No.</lable><span class="text-danger h5">*</span>
                        <input type="text" class="form-control" name="plate_no" id="plate_no" autocomplete="off" value="<?php echo isset($plate_no) ? $plate_no : '' ?>" required>
                    </div>
                    <div class="form-group">
                        <lable class="control-label" for="status">Status</lable><span class="text-danger h5">*</span>
                        <select name="status" class="custom-select" required>
                            <option value="0" <?php echo (isset($status) && $status == '0') ? 'selected' : '' ?>>Pending</option>
                            <option value="1" <?php echo (isset($status) && $status == '1') ? 'selected' : '' ?>>Paid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable class="control-label" for="enforcers_id">Officer</lable><span class="text-danger h5">*</span>
                        <select name="enforcers_id" id="enforcers_id" class="custom-select select2" required>
                            <option value="">--Select Officer--</option>
                            <?php
                            $enforcers = $conn->query("SELECT * FROM `enforcers_list` WHERE status ='1' order by `name` asc ");
                            while ($row = $enforcers->fetch_assoc()) :
                            ?>
                                <option <?php echo (isset($officer_name) && $officer_name == $row['name']) ? 'selected' : '' ?>>[<?php echo $row['employee_id_no'] ?>] <?php echo ucwords($row['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>
            <hr>

            <div class="row">

                <div class="col-6">
                    <h5 class='border-bottom border-light'><b>Offense List</b></h5>
                    <div class="row">
                        <div class="col-auto float-left">
                            <div class="form-group">
                                <lable class="control-label" for="offense_id">Offense</lable><span class="text-danger h5">*</span>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="form-group">
                                <select id="offense_id" class="custom-select select2">
                                    <option value=""></option>
                                    <?php
                                    $driver = $conn->query("SELECT * FROM `offenses` order by `name` asc ");
                                    while ($row = $driver->fetch_assoc()) :
                                    ?>
                                        <option value="<?php echo $row['id'] ?>" data-fine="<?php echo $row['fine'] ?>" data-code="<?php echo $row['code'] ?>" data-name="<?php echo $row['name'] ?>">[<?php echo $row['code'] ?>] <?php echo ucwords($row['name']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <button class='btn btn-flat btn-default bg-lightblue' type="button" id="add_to_list"><i class="fa fa-plus"></i> Add to List</button>
                            </div>
                        </div>
                        <div class="col-4"></div>
                    </div>
                    <table class="table table-stripped table-hover" id="fine-list">
                        <thead>
                            <tr align="center">
                                <th>Code</th>
                                <th>Offense</th>
                                <th>Fine</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($id)) :
                                $olist = $conn->query("SELECT i.*,o.code,o.name FROM `offense_items` i inner join `offenses` o on i.offense_id = o.id where i.driver_offense_id ='{$id}' ");
                                while ($row = $olist->fetch_assoc()) :
                            ?>
                                    <tr align="center">
                                        <td><?php echo $row['code'] ?>
                                            <input type="hidden" name="offense_id[]" value="<?php echo $row['offense_id'] ?>">
                                            <input type="hidden" name="fine[]" value="<?php echo $row['fine'] ?>">
                                        </td>
                                        <td><?php echo $row['name'] ?>
                                            <input type="hidden" name="offense_name[]" value="<?php echo $row['name'] ?>">
                                        </td>
                                        <td class="fine text-right"><?php echo "₱ " . number_format($row['fine'], 2) ?></td>
                                        <td>
                                            <button class="btn  btn-sm btn-default text-danger" type="button" onclick="rem_item($(this))"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <?php if (!isset($id) || (isset($olist) && $olist->num_rows <= 0)) : ?>
                                <tr id='td-none'>
                                    <th colspan="4" class="text-center">No Offense Listed Yet.</th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">Total</th>
                                <th colspan="2" class="text-right" id="total_amount"><?php echo isset($total_amount) ? "₱ " . number_format($total_amount, 2) : '0.00' ?></th>
                                <th><input type="hidden" name="total_amount" value="<?php echo isset($total_amount) ? $total_amount : 0 ?>"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="remarks" class="control-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control" cols="30" rows="3" style="resize:none !important"><?php echo isset($remarks) ? $remarks : '' ?></textarea>
                    </div>
                </div>
            </div>
            <hr>


        </form>
    </div>

</div>

<div class="card card-outline card-dark">
    <div class="card-header d-flex justify-content-center ">
        <h3>Selected</h3>
        <div class="bg-warning ml-2 mr-2" id="legends"></div>
        <h3>Vacant</h3>
        <div class="bg-success ml-2" id="legends"></div>
        <h3 class=" ml-2">Occupied</h3>
        <div class="bg-danger ml-2" id="legends"></div>
    </div>

    <div class="card-body ">
        <div class="d-flex  flex-wrap spot top-park bg-danger ">
            <?php
            $qry = $conn->query("SELECT * from `parking_number` where `position` ='Top' ");

            while ($row = $qry->fetch_assoc()) :  ?>
                <div class=" gap-2" id="parking_spots">
                    <a class="view_details badge " data-id="<?php echo $row['id'] ?>"><i id="park-icon-top" class="fas fa-motorcycle"></i></a>
                </div>
            <?php endwhile; ?>
        </div>

        <?php
        function displayParking($conn, $position)
        {
            $qry = $conn->query("SELECT * FROM `parking_number` WHERE `position` ='$position'");

            while ($row = $qry->fetch_assoc()) {
                $spotColor = isset($row['impound_no']) && $row['impound_no'] != '' ? 'bg-danger' : 'bg-success';
                $parking_location = $row['parking_location'];
        ?>
                <div class="d-flex flex-column gap-2   <?php echo $spotColor ?>  assignParkingSpot parking_spot " id="<?php echo $parking_location ?>">
                    <!-- Passing the fetched ID from $qry2 to the data-id attribute in the anchor tag -->
                    <a class=" badge text-light"><i id="park-icon" class="fas fa-motorcycle"></i></a>
                    <h2><?php echo $parking_location ?></h2>
                </div>
        <?php
            }
        }
        ?>

        <div class="d-flex justify-content-between ">
            <div class="d-flex spot flex-column">
                <?php displayParking($conn, 'Left'); ?>
            </div>

            <?php
            function displayAdditionalParking($conn, $position)
            {
                $qry = $conn->query("SELECT * from `parking_number` where `position` ='Left' OR `position` ='Right' OR `position` ='LeftBottom'
                OR `position` ='RightBottom'");
                $all_impound_set = true; // Assuming all are set initially

                while ($row = $qry->fetch_assoc()) {
                    if ($row['impound_no'] == '') {
                        $all_impound_set = false;
                        break; // No need to continue the loop if any impound_no is not set
                    }
                }

                if ($all_impound_set) { // Display only if all impound_no are set
                    $qry2 = $conn->query("SELECT * from `parking_number` where `position` ='$position'");
                    while ($row2 = $qry2->fetch_assoc()) :
                        $spotColor = isset($row2['impound_no']) && $row2['impound_no'] != '' ? 'bg-danger' : 'bg-success';

                        $parking_location = $row2['parking_location'];
            ?>
                        <div class="d-flex flex-column gap-2 <?php echo $spotColor ?> assignParkingSpot parking_spot" id="<?php echo $parking_location ?>">
                            <!-- Passing the fetched ID from $qry2 to the data-id attribute in the anchor tag -->
                            <a class=" badge text-light"><i id="park-icon" class="fas fa-motorcycle"></i></a>
                            <h5><?php echo $parking_location ?></h5>
                        </div>
            <?php endwhile;
                }
            } ?>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column1'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column2'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column3'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column4'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column5'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column6'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column7'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column8'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column9'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column10'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column11'); ?>
            </div>

            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column12'); ?>
            </div>
            <div class="d-flex flex-column">
                <?php displayAdditionalParking($conn, 'Additional_Parking_Column13'); ?>
            </div>

            <div class="d-flex spot flex-column">
                <?php displayParking($conn, 'Right'); ?>
            </div>

        </div>
        <div class="d-flex justify-content-between">
            <div class="d-flex spot ">
                <?php displayParking($conn, 'LeftBottom'); ?>
            </div>

            <div class="d-flex spot ">
                <?php displayParking($conn, 'RightBottom'); ?>
            </div>
        </div>

    </div>
</div>

<script src="/../traffic_offense/assets/js/addToList.js"></script>
<script src="/../traffic_offense/assets/js/addOffenseImpound.js"></script>
<script src="/../traffic_offense/assets/js/assignParkingSpot.js"></script>
<script src="/../traffic_offense/assets/js/clearAllInputImpound.js"></script>

<script>
    $('.add_driver').click(function() {
        uni_modal("", "impound_vehicle/add_driver.php", 'large')
    })

    $(document).ready(function() {

        $('#ticket_no').on('input', function() {
            var licenseNoValue = $(this).val(); // Remove non-numeric characters
            var regex = /^[a-zA-Z0-9\s'-]+$/;

            if (licenseNoValue.trim().length === 0) {
                $(this).removeClass('is-valid');
                $(this).removeClass('is-invalid');
            } else if (regex.test(licenseNoValue)) {
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
            } else {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            }
        });
        $('.select2').select2({
            placeholder: "Please Select here",
            width: "relative"
        })

    })
</script>