<?php if (isset($error)): ?>
	<div class="alert alert-danger small"><?= $error; ?></div>
<?php endif; ?>

<div class="row small">
	<span class="col-sm-6"><strong>Report Title :</strong></span>
	<span class="col-sm-6"><?= $report['title']; ?></span>
</div>
<div class="row small">
	<span class="col-sm-6"><strong>Date Uploaded :</strong></span>
	<span class="col-sm-6"><?= date('F d, Y', strtotime($report['date_uploaded'])); ?></span>
</div>
<div class="row small">
	<span class="col-sm-6"><strong>Uploaded By :</strong></span>
	<span class="col-sm-6"><?= ucwords($report['given_name'].' '.$report['middle_name'].' '.$report['last_name'].' '.$report['name_suffix']); ?></span>
</div>

<br><br>

<div class="row">
	<div class="col-sm-6">
		<a id="cancel-report-delete" class="btn btn-primary btn-block btn-sm" href="#">Cancel</a>
	</div>
	<div class="col-sm-6">
		<a id="confirm-report-delete" class="btn btn-danger btn-block btn-sm" href="#">Confirm</a>
	</div>
</div>