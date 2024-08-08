<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `offense_list` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
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
</style>
<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?> Offense Record</h3>
        <div class="card-tools">

            <a href="?page=offenses" class="btn btn-outline-secondary mr-2">
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
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <input type="hidden" name="category" value="ticket">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <lable class="control-label" for="date_created">Date Violated</lable><span class="text-danger h5">*</span>
                        <input type="datetime-local" class="form-control" name="date_created" id="date_created" value="<?php echo isset($date_created) ? date("Y-m-d\\TH:i", strtotime($date_created)) : date("Y-m-d\\TH:i") ?>" required>
                    </div>
                    <div class="form-group">
                        <lable class="control-label" for="ticket_no">Ticket No.</lable><span class="text-danger h5">*</span>
                        <input type="text" class="form-control" name="ticket_no" id="ticket_no_Input" autocomplete="off" value="<?php echo isset($ticket_no) ? $ticket_no : '' ?>" required>
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
                        <lable class="control-label" for="status">Status</lable><span class="text-danger h5">*</span>
                        <select name="status" id="status" class="custom-select" required>
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
                                        <td class="fine"><?php echo number_format($row['fine'], 2) ?></td>
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
                                <th colspan="2" class="text-right" id="total_amount"><?php echo isset($total_amount) ? number_format($total_amount, 2) : '0.00' ?></th>
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
        </form>
    </div>

</div>
<script src="<?php echo base_url ?>assets/js/addToList.js"></script>
<script src="<?php echo base_url ?>assets/js/addOffenseTicket.js"></script>
<?php ?>
<script>
    $('.add_driver').click(function() {

        uni_modal("", "offenses/add_driver.php", 'large')
    })

    $(document).ready(function() {

        $('#clear-all').click(function() {
            $('#offense-form')[0].reset(); // Reset the form
            $('#fine-list tbody').empty(); // Clear the offense list
            $('#total_amount').text("₱0.00"); // Reset total amount
            $('input[name="total_amount"]').val(0); // Reset total amount input
            $('#driver_id').val(null).trigger('change'); // Reset the select element
            $('#enforcers_id').val(null).trigger('change'); // Reset the select element
        });
        $('#ticket_no_Input').on('input', function() {
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