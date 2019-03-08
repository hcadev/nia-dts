<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-3"><h5>Employees</h5></div>
					<div class="col-lg-5">
						<form>
							<div class="input-group input-group-sm">
								<input class="form-control" type="text" name="keyword" value="<?= isset($keyword) ? $keyword : ''; ?>" placeholder="Enter search keyword here. . .">
								<div class="input-group-btn">
									<input class="btn btn-default" type="submit" value="Go!">
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-4 text-right">
<!--						<a id="refresh-employee-list" class="btn btn-default btn-sm" onclick="location.reload();" href="#" title="Refresh"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>-->
						<?php if (in_array('Create Employee', $user['privileges'])): ?>
							<a id="new-employee" class="btn btn-default btn-sm" href="#" title="Add"><span class="glyphicon glyphicon-plus"></span> Add</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-striped table-hover small">
					<tr>
						<th class="text-center col-lg-2">Date Added</th>
						<th class="text-center col-lg-3">Name</th>
						<th class="text-center col-lg-3">Position</th>
						<th class="text-center col-lg-1">Status</th>
						<th class="text-center col-lg-3"></th>
					</tr>
					<?php foreach ($employees AS $employee): ?>
						<tr>

							<td class="text-center"><?= date('F d, Y h:i:s A', strtotime($employee['date_created'])); ?></td>
							<td>
								<span class="employee-id hidden"><?= $employee['id']; ?></span>
								<span class="employee-name"><?= strtoupper($employee['last_name']).', '.ucwords($employee['given_name'].' '.$employee['middle_name'].' '.$employee['name_suffix']); ?></span>

							</td>
							<td class="text-center"><span><?= $employee['position']; ?></span></td>
							<td class="text-center"><span><?= $employee['status']; ?></span></td>
							<td class="text-center">
								<a class="btn btn-primary btn-xs" href="<?= URL::site('employee/view/'.$employee['id']); ?>"><span class="glyphicon glyphicon-user"></span> <small>View</small></a>
								<?php if (in_array('Block Employee', $user['privileges']) && $user['id'] != $employee['id']): ?>
									<a class="btn btn-xs <?= $employee['status'] == 'Active' ? 'btn-danger employee-block' : 'btn-success employee-allow'; ?>" href="#"><span class="glyphicon <?= $employee['status'] == 'Active' ? 'glyphicon-ban-circle' : 'glyphicon-ok-circle'; ?>"></span> <small><?= $employee['status'] == 'Active' ? 'Deactivate' : 'Activate'; ?><small></a>
								<?php endif; ?>
<!--								<a class="btn btn-primary btn-xs" href="#"><span class="glyphicon glyphicon-envelope"></span> <small>Message</small></a>-->
<!--								--><?php //if (in_array('Edit Employee', $user['privileges'])): ?>
<!--									<a class="btn btn-warning btn-xs" href="#"><span class="glyphicon glyphicon-pencil"></span> <small>Edit</small></a>-->
<!--								--><?php //endif; ?>
								<?php if (in_array('Delete Employee', $user['privileges']) && $user['id'] != $employee['id']): ?>
									<a class="btn btn-danger btn-xs employee-delete" href="#"><span class="glyphicon glyphicon-remove"></span> <small>Delete</small></a>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>