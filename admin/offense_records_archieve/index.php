<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>

<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Archieve Offense Records</h3>

    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-stripped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="15%">
                        <col width="25%">
                        <col width="25%">
                        <col width="10%">
                        <col width="5%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>DateTime</th>
                            <th>Ticket No.</th>
                            <th>License ID</th>
                            <th>Officer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT r.*,d.license_id_no FROM `ticket_archive` r inner join `drivers_list` d on r.driver_id = d.id  order by unix_timestamp(r.date_created) desc ");
                        while ($row = $qry->fetch_assoc()) :
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo date("Y-m-d H:i A", strtotime($row['date_created'])) ?></td>
                                <td><a href="javascript:void(0)" class="view_details" data-id="<?php echo $row['id'] ?>"><?php echo $row['ticket_no'] ?></a></td>
                                <td><?php echo $row['license_id_no'] ?></td>
                                <td><?php echo $row['officer_name'] ?></td>
                                <td class="text-center">
                                    <?php if ($row['status'] == 1) : ?>
                                        <span class="badge badge-success">Paid</span>
                                    <?php else : ?>
                                        <span class="badge badge-secondary">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <a class="btn btn-success archive_data" href="javascript:void(0)" data-type="offense" data-id="<?php echo $row['id'] ?>"> <i class="fas fa-undo "></i> Unarchive</a>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url ?>assets/js/unarchieveData.js"></script>
<script>
    $(document).ready(function() {

        $('.view_details').click(function() {
            uni_modal("<i class='fa fa-ticket'></i> Driver's Offense Ticket Details", "offense_records_archieve/view_details.php?id=" + $(this).attr('data-id'), 'mid-large')
        })

        $('.table').dataTable({
            columnDefs: [{
                orderable: false,
                targets: [5, 6]
            }]
        });
    })
</script>