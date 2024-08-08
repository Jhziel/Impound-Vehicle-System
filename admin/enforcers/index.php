<?php if ($_settings->chk_flashdata('success')) : ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Enforcers</h3>
        <div class="card-tools">
            <a href="?page=enforcers/manage_enforcer" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-stripped">
                    <colgroup>
                        <col width="10%">
                        <col width="25%">
                        <col width="30%">
                        <col width="20%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr align="center">
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
                        
                        $qry = $conn->query("SELECT * from `enforcers_list` where `status` != '4' order by unix_timestamp(date_created) desc ");
                        while ($row = $qry->fetch_assoc()) :
                            $lt_qry = $conn->query("SELECT meta_value FROM `enforcers_meta` where enforcers_id = '{$row['id']}' and meta_field = 'status' ");
                            $row['status'] = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";
                        ?>
                            <tr align="center">
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
                                <td class="d-flex">
                                    <a class="btn btn-primary  mr-1" style="padding: 6px 12px; width:  71.7188px;" href="?page=enforcers/manage_enforcer&id=<?php echo $row['id'] ?>">Edit</a>
                                    <a class="btn btn-secondary archive_data" href="javascript:void(0)" data-type="enforcer" data-id="<?php echo $row['id'] ?>">Archive</a>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url ?>assets/js/archieveData.js"></script>
<script>
    $(document).ready(function() {


        $('.table').DataTable({ // Corrected the typo 'DataTable'
            columnDefs: [{
                orderable: false,
                targets: [3, 4]
            }]
        });
    });
</script>