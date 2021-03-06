<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-3"><h5>Audit Trail</h5></div>
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
						<a id="refresh-employee-list" class="btn btn-default btn-sm" onclick="location.reload();" href="#" title="Refresh"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-striped table-hover small">
					<tr>
						<th class="text-center col-lg-2">Date</th>
						<th class="text-center col-lg-3">Name</th>
						<th class="text-center col-lg-3">Action</th>
					</tr>
					<?php foreach ($trail AS $action): ?>
						<tr>

							<td class="text-center"><?= date('F d, Y h:i:s A', strtotime($action['date_recorded'])); ?></td>
							<td>
								<a class="text-primary" href="<?= URL::site('employee/view/'.$action['employee_id']); ?>"><?= strtoupper($action['last_name']).', '.ucwords($action['given_name'].' '.$action['middle_name'].' '.$action['name_suffix']); ?></a>
							</td>
							<td class="text-center"><span><?= $action['action']; ?></span></td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
	</div>
</div>