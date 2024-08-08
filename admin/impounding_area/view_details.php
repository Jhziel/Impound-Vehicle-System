<?php
require_once('../../config.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $sql = $conn->query("SELECT  i.*,p.parking_location,p.position,
    p.impound_no AS parking_impound_no,
    m.impound_no AS vehicle_impound_no,
    m.vehicle_owner,
    m.vehicle_type,
    m.parking_location AS vehicle_parking_location,
    m.ownership
    FROM `offense_list` i LEFT JOIN
    `parking_number` p ON i.ticket_no = p.impound_no 
    LEFT JOIN
    impound_vehicle_list m ON i.ticket_no = m.impound_no
    WHERE
    i.status != '4' AND i.id = '{$_GET['id']}'");

    if ($sql->num_rows > 0) {
        $row = $sql->fetch_assoc();
        foreach ($row as $k => $v) {
            $$k = $v;
        }
    }
}

?>
<div class="container-fluid">
    <div class="w-100 d-flex justify-content-end mb-2">
        <?php if (isset($_GET['id']) && $_GET['id'] > 0) : ?>
            <a class="btn btn-success  mr-1 archive_data" href="javascript:void(0)" data-id="<?php echo $id; ?>"><i class="fas fa-check-circle"></i> Release</a>
            <a class="btn btn-primary  mr-1" style="padding: 6px 12px; width:  71.7188px;" href="?page=impound_vehicle/manage_impound_info&id=<?php echo $id; ?>"><i class="fas fa-edit"></i> Edit</a>
        <?php endif ?>
        <button class="btn btn-flat btn-sm btn-default bg-black" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
    <div class="border border-dark px-2 py-2" id="print_out">

        <style>
            img#cimg {
                height: 25vh;
                width: 15vw;
                object-fit: scale-down;
                object-position: center center;
            }

            p,
            label {
                margin-bottom: 5px;
            }

            #uni_modal .modal-footer {
                display: none !important;
            }
        </style>

        <table class="table boder-0">
            <tr class='boder-0'>
                <td width="80%" class='boder-0 align-bottom'>
                    <div class="row">
                        <div class="col-6 d-flex w-max-100">
                            <label class="float-left w-auto whitespace-nowrap">Ticket No: </label>
                            <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo isset($ticket_no) ? $ticket_no : ' ' ?></b></p>
                        </div>
                        <div class="col-6 d-flex w-max-100">
                            <label class="float-left w-auto whitespace-nowrap">Plate No: </label>
                            <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo isset($plate_no) ? $plate_no : ' ' ?></b></p>
                        </div>
                        <div class="col-12">
                            <div class="row justify-content-between  w-max-100">
                                <div class="col-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Vehicle Owner: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo isset($vehicle_owner) ? $vehicle_owner : ' ' ?></b></p>
                                </div>
                                <div class="col-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Vehicle Type: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><b><?php echo isset($vehicle_type) ? $vehicle_type : ' ' ?></b></p>
                                </div>
                            </div>
                            <div class="d-flex col-6 ">
                                <label class="float-left w-auto whitespace-nowrap">Parking Location:</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($parking_location) ? $parking_location : ' ' ?></b></p>
                            </div>
                            <div class="d-flex col-6">
                                <label class="float-left w-auto whitespace-nowrap">Ownership:</label>
                                <p class="col-md-auto border-bottom border-dark w-100"><b><?php echo isset($ownership) ? $ownership : ' ' ?></b></p>
                            </div>
                        </div>
                    </div>
                </td>
                <td width="20%" class="border-3 border-dark">
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="<?php $_settings->info('short_name') ?>" class="img-thumnail" id="cimg">
                    </div>
                </td>
            </tr>

        </table>
        <hr class='bg-dark border-dark'>
        <h4 class="text-center"><b>Offense Records</b></h4>
        <table class='table table-stripped px-4'>
            <thead>
                <tr align="center">
                    <th>DateTime</th>
                    <th>Offense</th>
                    <th>Fine</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $ids = 0; // Set a default value for $ids

                if (isset($id)) {
                    $ids = $id; // Assign $id to $ids if $id is set
                }

                $olist = $conn->query("SELECT i.*,o.code,o.name from `offense_items` i inner join `offenses` o on i.offense_id = o.id where i.driver_offense_id = '{$ids}' order by unix_timestamp(i.date_created) desc  ");


                while ($row = $olist->fetch_assoc()) :
                ?>
                    <tr align="center">
                        <td><?php echo date("M d, Y H:i A", strtotime($row['date_created'])) ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td class="text-right"><?php echo '₱ ' . number_format($row['fine'], 2) ?></td>
                        <td><?php echo ($row['status'] == 1) ? "Paid" : 'Pending' ?></td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($olist->num_rows <= 0) : ?>
                    <tr>
                        <th class="text-center" colspan="4">No Record.</th>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<script src="/../traffic_offense/assets/js/releaseImpoundVehicle.js"></script>
