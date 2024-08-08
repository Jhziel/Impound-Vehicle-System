<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Drivers</h3>
		<div class="card-tools">
			<a href="?page=drivers/manage_driver" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
		</div>
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
						<tr align="center">
							<th>#</th>
							<th>License ID</th>
							<th>Name</th>
							<th>License Type</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						function dump($value){
							echo "<pre>";
							var_dump($value);
							echo "<pre>";
							die();
						}
						$i = 1;
						$qry = $conn->query("SELECT * from `drivers_list` where `status` != '4' order by unix_timestamp(date_created) desc ");
						
						while ($row = $qry->fetch_assoc()) :
							$lt_qry = $conn->query("SELECT meta_value FROM `drivers_meta` where driver_id = '{$row['id']}' and meta_field = 'license_type' ");
							$row['license_type'] = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?php echo $row['license_id_no'] ?></td>
								<td><span class="mr-2"><a href="javascript:void(0)" class="view_details badge badge-dark text-light" data-id="<?php echo $row['id'] ?>"> <i class="fa fa-eye"></i></a></span> <?php echo $row['name'] ?></td>
								<td align="center"><?php echo $row['license_type'] ?></td>

								<td class="d-flex">
									<a class="btn btn-primary  mr-1" style="padding: 6px 12px; width:  71.7188px;" href="?page=drivers/manage_driver&id=<?php echo $row['id'] ?>"> Edit</a>
									<a class="btn btn-secondary archive_data" href="javascript:void(0)" data-type="driver"  data-id="<?php echo $row['id'] ?>"> Archive</a>
								</td>

							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url?>assets/js/archieveData.js"></script>

<script>
	$(document).ready(function() {

		$('.view_details').click(function() {
			uni_modal("<i class='fa fa-id-card'></i> Driver's Information", "drivers/view_details.php?id=" + $(this).attr('data-id'), 'large')
		})
		$('.table').dataTable({
			columnDefs: [{
				orderable: false,
				targets: [3, 4]
			}]
		});
	})
</script>