<div class="row">
	<div class="col-lg-10 col-lg-offset-1 col-xs-12">
		<div class="well well-lg">
			<div class="hidden-print">
				<form id="report-settings" class="form-horizontal">
					<div class="form-group form-group-sm">
						<div class="col-lg-2">
							<label class="control-label">From</label>
							<input class="form-control" type="date" name="from" value="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>">
						</div>
						<div class="col-lg-2">
							<label class="control-label">To</label>
							<input class="form-control" type="date" name="to" value="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>">
						</div>
						<div class="col-lg-3">
							<label class="control-label">Type</label>
							<select class="form-control" name="type">
								<option value="status_all" selected>Project Status Report (All)</option>
								<option value="status_ongoing">Project Status Report (Ongoing)</option>
								<option value="status_completed">Project Status Report (Completed)</option>
<!--								<option value="statistics">Project Statistics Report</option>-->
							</select>
						</div>
						<div class="col-lg-2">
							<label class="control-label">Location</label>
							<select class="form-control" name="municipality">
								<option value="Whole CAR" selected>Whole CAR</option>
								<option disabled>--------------------------------</option>
								<?php foreach ($provinces AS $province): ?>
									<option value="<?= 'Whole '.$province['name']; ?>"><?= 'Whole '.$province['name']; ?></option>
								<?php endforeach; ?>
								<option disabled>--------------------------------</option>
								<?php foreach ($municipalities AS $municipality): ?>
									<option value="<?= $municipality['name']; ?>"><?= $municipality['name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-lg-3">
							<label style="visibility: hidden;">x</label>
							<input class="btn btn-primary btn-block btn-sm" type="submit" value="Generate">
						</div>
					</div>
				</form>
			</div>
			<div id="report-content">

			</div>
		</div>
	</div>
</div>