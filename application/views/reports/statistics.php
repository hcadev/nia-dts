<div class="row hidden-print">
	<div class="col-lg-3 col-lg-offset-9">
		<a class="btn btn-primary btn-block btn-sm" href="#" onclick="window.print();">Print</a>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<h5 class="text-center">
			<span>Republic of the Philippines</span><br>
			<strong>NATIONAL IRRIGATION ADMINISTRATION</strong>
		</h5>
		<h5 class="text-center"><strong>Project Statistics Report</strong><br><small><?= $from.' to '.$to; ?></small></h5>
		<br>
		<table class="table table-bordered table-striped table-hover small">
			<tr>
				<th class="text-center col-xs-2" rowspan="2">Date</th>
				<th class="text-center col-xs-5" colspan="2">Started</th>
				<th class="text-center col-xs-5" colspan="2">Completed</th>
			</tr>
			<tr>
				<th class="text-center">Communal Irrigation System</th>
				<th class="text-center">National Irrigation System</th>
				<th class="text-center">Communal Irrigation System</th>
				<th class="text-center">National Irrigation System</th>
			</tr>
			<?php if (empty($reports)): ?>
				<tr>
					<td class="text-center text-danger" colspan="5">No records found.</td>
				</tr>
			<?php else: ?>
				<?php foreach ($reports AS $project): ?>
					<tr>
						<td class="text-center"><?= $project['date']; ?></td>
						<td class="text-right"><?= number_format($project['cis_start'], 0, '.', ','); ?></td>
						<td class="text-right"><?= number_format($project['cis_completed'], 0, '.', ','); ?></td>
						<td class="text-right"><?= number_format($project['nis_start'], 0, '.', ','); ?></td>
						<td class="text-right"><?= number_format($project['nis_completed'], 0, '.', ','); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>