<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<style>
    @media (max-width: 575px) {
        #parking_spot {
            width: 35px;

        }

        #park-icon {
            font-size: 17px;
            z-index: 1;
        }


    }

    @media (min-width: 576px) {
        #parking_spot {
            width: 43px;

        }

        #park-icon {
            font-size: 20px;
            z-index: 1;
        }


    }

    @media (min-width: 729px) {
        #parking_spot {
            width: 60px;

        }

        #park-icon {
            font-size: 27px;
            z-index: 1;
        }


    }

    @media (min-width: 991px) {
        #parking_spot {
            width: 76px;

        }

        #park-icon {
            font-size: 27px;
            z-index: 1;
        }


    }

    @media (min-width: 1200px) {
        #parking_spot {
            width: 103px;

        }

        #park-icon {
            font-size: 55px;
            z-index: 1;
        }


    }


    #parking_spot {
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

    #status {
        font-size: 30px;
        z-index: 3;
    }


    .list-group-item-action {
        width: 345px;
    }

    .legend {
        margin-bottom: 44px;
    }

    #legends {

        width: 100px;

    }
</style>
<div class="card card-outline card-dark">


    <div class="card-header d-flex justify-content-center ">
        <h3>Vacant</h3>
        <div class="bg-success ml-2" id="legends"></div>
        <h3 class=" ml-2">Occupied</h3>
        <div class="bg-danger ml-2" id="legends"></div>
    </div>

    <div class="row mt-3">
        <div class="col-4 d-flex align-items-center justify-content-end font-weight-bold"><span>Search:</span></div>
        <div class="col-4"> <input type="text" class="form-control " id="search" placeholder="Search Name or Plate.No"></div>
        <div class="col-4 d-flex align-items-center justify-content-start"> <button class="btn btn-primary" type="button" id="filterBtn">Search</button>
        </div>

        <div class="col" style="position: relative;margin-top: 0px;margin-left: 360px;">
            <div class="list-group" id="show-list" style="position: absolute; top: 100%; left: 600ox; z-index: 100;">

                <!-- Here autocomplete list will be display -->
            </div>
        </div>

    </div>
    <div class="d-flex justify-content-center">

        <h6 class="text-center mt-3">Parking Location:</h6>
        <h6 class="text-center mt-3" id="location"></h6>

    </div>
    <div class="card-body ">
        <div class="d-flex  flex-wrap spot top-park">
            <?php
            $qry = $conn->query("SELECT * from `parking_number` where `position` ='Top' ");

            while ($row = $qry->fetch_assoc()) :  ?>
                <div class=" d-flex gap-2 bg-danger" id="parking_spots">
                    <div class=" badge " data-id="<?php echo $row['id'] ?>"><i id="park-icon-top" class="fas fa-motorcycle"></i></div>

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
                $qry2 = $conn->query("SELECT i.id FROM offense_list i LEFT JOIN parking_number p ON i.ticket_no = p.impound_no WHERE i.status != '4' AND p.parking_location='{$row['parking_location']}'");
                $id = ''; // Variable to store the fetched ID
                if ($row2 = $qry2->fetch_assoc()) {
                    $id = $row2['id']; // Assuming 'id' is the column you want to pass
                }
        ?>
                <div class="d-flex flex-column gap-2  assignParkingSpot  <?php echo $spotColor ?>  view_details " id="parking_spot" data-id="<?php echo $id ?>" data-location="<?php echo $parking_location ?>" style="cursor: pointer;">
                    <!-- Passing the fetched ID from $qry2 to the data-id attribute in the anchor tag -->
                    <a href="javascript:void(0)" class=" badge    "><i id="park-icon" class="fas fa-motorcycle"></i></a>
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

                $qry = $conn->query("SELECT * from `parking_number` where `position` ='Additional_Parking_Column1' OR `position` ='Additional_Parking_Column2' OR `position` ='Additional_Parking_Column3'
                OR `position` ='Additional_Parking_Column4'  OR `position` ='Additional_Parking_Column5'  OR `position` ='Additional_Parking_Column6'  OR `position` ='Additional_Parking_Column7'  OR `position` ='Additional_Parking_Column8'
                 OR `position` ='Additional_Parking_Column9'  OR `position` ='Additional_Parking_Column10'  OR `position` ='Additional_Parking_Column11'  OR `position` ='Additional_Parking_Column12'  OR `position` ='Additional_Parking_Column13'");
                $all_impound_set = false; // Assuming all are set initially

                while ($row = $qry->fetch_assoc()) {
                    if ($row['impound_no'] !== '') {
                        $all_impound_set = true;
                        break; // No need to continue the loop if any impound_no is not set
                    }
                } 
                if($all_impound_set){
                    $qry2 = $conn->query("SELECT * FROM `parking_number` WHERE `position` ='$position'");
    
                    while ($row = $qry2->fetch_assoc()) {
                        $spotColor = isset($row['impound_no']) && $row['impound_no'] != '' ? 'bg-danger' : 'bg-success';
                        /*  $display = isset($row['impound_no']) && $row['impound_no'] != '' ? '' : 'd-none';
                        $border = isset($row['impound_no']) && $row['impoun_dno'] != '' ? '' : 'border-0';
                        $view_details = isset($row['impound_no']) && $row['impound_no'] != '' ? 'view_details' : '';
                        $pointer = isset($row['impound_no']) && $row['impound_no'] != '' ? 'cursor: pointer;' : ''; */
    
                        $parking_location = $row['parking_location'];
                        $qry2 = $conn->query("SELECT i.id FROM offense_list i LEFT JOIN parking_number p ON i.ticket_no = p.impound_no WHERE i.status != '4' AND p.parking_location='{$row['parking_location']}'");
                        $id = ''; // Variable to store the fetched ID
                        if ($row2 = $qry2->fetch_assoc()) {
                            $id = $row2['id']; // Assuming 'id' is the column you want to pass
                        }
                ?>
                        <div class="d-flex flex-column  gap-2  assignParkingSpot <?php echo $spotColor ?>   view_details " id="parking_spot" data-id="<?php echo $id ?>" data-location="<?php echo $parking_location ?>" style="cursor: pointer;">
                            <!-- Passing the fetched ID from $qry2 to the data-id attribute in the anchor tag -->
                            <a href="javascript:void(0)" class=" badge     "><i id="park-icon" class="fas fa-motorcycle"></i></a>
                            <h5><?php echo $parking_location ?></h5>
                        </div>
                <?php
                    }
                }
            }
            ?>

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
<script>
    $(document).ready(function() {

        // Send Search Text to the server
        $("#search").keyup(function() {
            let searchText = $(this).val();
            if (searchText != "") {
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=display_vehicle_owner",
                    method: "post",
                    data: {
                        query: searchText,
                    },
                    success: function(response) {
                        $("#show-list").html(response);
                    },
                });
            } else {
                $("#show-list").html("");
            }
        });
        // Set searched text in input field on click of search button
        $(document).on("click", "#name", function() {
            $("#search").val($(this).text());
            $("#show-list").html("");
        });
        $("#filterBtn").click(function() {
            $("#show-list").html("");
            var searchText = $("#search").val();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=display_parking_location",
                method: "post",
                data: {
                    query: searchText,
                },
                dataType: "json",
                success: function(resp) {
                    if (resp.status === 'success') {
                        $("#location").html(resp.parking);
                        $(".assignParkingSpot.bg-warning")
                            .removeClass("bg-warning")
                            .addClass("bg-danger");
                        $(".assignParkingSpot").each(function() {
                            var assignParkingSpotId = $(this).attr('data-location');
                            if (resp.parking == assignParkingSpotId) {

                                $(this)
                                    .removeClass("bg-danger")
                                    .removeClass("bg-success")
                                    .addClass("bg-warning")

                                return false;
                            }

                        });
                    } else {
                        $("#location").html(resp.message);
                        $(".assignParkingSpot.bg-warning")
                            .removeClass("bg-warning")
                            .addClass("bg-danger");
                    }
                },
            });

        });

        $('.view_details').click(function() {
            uni_modal("<i class='fas fa-car-side'></i> Impound Vehicle Details", "impounding_area/view_details.php?id=" + $(this).attr('data-id'), 'large')
        })
    })
</script>