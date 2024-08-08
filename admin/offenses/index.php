<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>

<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Offense Records</h3>
		<div class="card-tools">
			<a href="?page=offenses/manage_record" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
				<table class="table table-hover table-stripped">
					<colgroup>
						<col width="5%">
						<col width="15%">
						<col width="15%">
						<col width="20%">
						<col width="20%">
						<col width="10%">
						<col width="15%">
					</colgroup>
					<thead>
						<tr align="center">
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
						$qry = $conn->query("SELECT r.*,d.license_id_no FROM `offense_list` r inner join `drivers_list` d on r.driver_id = d.id where r.category = 'ticket' and r.status != '4' order by unix_timestamp(r.date_created) desc ");
						while ($row = $qry->fetch_assoc()) :
						?>
							<tr align="center">
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
								<td class="d-flex">
									<a class="btn btn-primary  mr-1" style="padding: 6px 12px; width:  71.7188px;" href="?page=offenses/manage_record&id=<?php echo $row['id'] ?>"> Edit</a>
									<a class="btn btn-secondary archive_data" href="javascript:void(0)" data-type="offense" data-id="<?php echo $row['id'] ?>"> Archive</a>
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
			uni_modal("<i class='fa fa-ticket'></i> Driver's Offense Ticket Details", "offenses/view_details.php?id=" + $(this).attr('data-id'), 'mid-large')
		})
		$('.table').dataTable({
			columnDefs: [{
				orderable: false,
				targets: [5, 6]
			}]
		});
	})
</script>