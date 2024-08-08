<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Archieve Enforcers</h3>

    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-stripped">
                    <colgroup>
                        <col width="10%">
                        <col width="25%">
                        <col width="35%">
                        <col width="20%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;

                        $qry = $conn->query("SELECT * from `enforcers_list_archieve` order by unix_timestamp(date_created) desc ");
                        while ($row = $qry->fetch_assoc()) :
                            $lt_qry = $conn->query("SELECT meta_value FROM `enforcers_meta` where enforcers_id = '{$row['id']}' and meta_field = 'status' ");
                            $row['status'] = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['employee_id_no'] ?></td>
                                <td> <?php echo $row['name'] ?></td>
                                <td>
                                    <?php if ($row['status'] == 1) : ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td align="center">
                                    <a class="btn btn-success archive_data" href="javascript:void(0)" data-type="enforcer" data-id="<?php echo $row['id'] ?>"> <i class="fas fa-undo "></i> Unarchive</a>
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
        $('.unarchive_data').click(function() {
            var enforcerID = $(this).attr('data-id');
            _conf("Are you sure to unarchive this enforcer data?", "unarchive_enforcer", [$(this).attr('data-id')])

        });

        $('.table').DataTable({ // Corrected the typo 'DataTable'
            columnDefs: [{
                orderable: false,
                targets: [3, 4]
            }]
        });
    });

    function unarchive_enforcer(id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=unarchive_enforcer",
            method: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(resp) {
                if (typeof resp === 'object' && resp.status === 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            },
            error: function(err) {
                console.log(err);
                alert_toast("Error occurred.", 'error');
                end_loader();
            },
        });
    }
</script>