<div class="row hidden-print">
	<script type="text/javascript">
		$('#pdf-export').click(function (){
			html2canvas($("#convertible"),{
				onrendered:function(canvas){

					var img=canvas.toDataURL("image/png");
					var doc = new jsPDF("l", "pt", "legal");
					doc.addImage(img,'PNG',20,20);
					doc.save('test.pdf');
				}

			});
		});
	</script>
	<div class="col-lg-3 col-lg-offset-6">
		<a class="btn btn-primary btn-block btn-sm" href="#" id="pdf-export">Export to PDF</a>
	</div>
	<div class="col-lg-3">
		<a class="btn btn-primary btn-block btn-sm" href="#" onclick="window.print();">Print</a>
	</div>
</div>
<div class="row" id="convertible">
	<div class="col-xs-12">
		<h5 class="text-center">
			<span>Republic of the Philippines</span><br>
			<strong>NATIONAL IRRIGATION ADMINISTRATION</strong><br>
			<span>Cordillera Administrative Region</span>
		</h5>
		<h5 class="text-center">
			<strong>Project Status Report</strong>
			<br>
			<small><?= $location; ?></small>
			<br>
			<small><?= ucwords($filter).' Projects'; ?></small>
			<br>
			<small><?= $from.' to '.$to; ?></small>
		</h5>
		<br>
		<table class="table table-bordered table-striped table-hover small">
			<tr>
				<th class="text-center col-xs-1">#</th>
				<th class="text-center col-xs-1">ID</th>
				<th class="text-center col-xs-2">Name</th>
				<th class="text-center col-xs-3">Location</th>
				<th class="text-center col-xs-1">Attachments</th>
				<th class="text-center col-xs-1">Physical Accomplishment</th>
				<th class="text-center col-xs-1">Financial Report</th>
				<th class="text-center col-xs-1">Overall Progress</th>
			</tr>
			<?php if (empty($reports)): ?>
				<tr>
					<td class="text-center text-danger" colspan="7">No records found.</td>
				</tr>
			<?php else: ?>
				<?php $counter = 0; ?>
				<?php foreach ($reports AS $project): ?>
					<?php $counter++; ?>
					<?php $attachment_progress = floor(($project['file_count'] / $project['total_file_count']) * 100); ?>
					<?php $pa_progress = $project['pa_progress']; ?>
					<?php $fr_progress = $project['fr_progress']; ?>
					<?php $overall_progress = ($attachment_progress * .5) + ($pa_progress * .25) + ($fr_progress * .25); ?>
					<tr>
						<td class="text-center"><?= $counter; ?></td>
						<td class="text-center"><?= $project['id']; ?></td>
						<td class="text-center"><?= $project['name']; ?></td>
						<td class="text-center"><?= $project['municipality_name']; ?></td>
						<td class="text-center"><?= (number_format($attachment_progress, 2, '.', ',') + 0).'%'; ?></td>
						<td class="text-center"><?= (number_format($pa_progress, 2, '.', ',') + 0).'%'; ?></td>
						<td class="text-center"><?= (number_format($fr_progress, 2, '.', ',') + 0).'%'; ?></td>
						<td class="text-center"><?= (number_format($overall_progress, 2, '.', ',') + 0).'%'; ?></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</table>
	</div>
</div>