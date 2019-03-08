<?php if (isset($error)): ?>
	<div class="alert alert-danger small"><?= $error; ?></div>
<?php endif; ?>

<div class="row small">
	<span class="col-sm-6"><strong>Attachment Name :</strong></span>
	<span class="col-sm-6"><?= $attachment['name']; ?></span>
</div>
<div class="row small">
	<span class="col-sm-6"><strong>Date Uploaded :</strong></span>
	<span class="col-sm-6"><?= date('F d, Y', strtotime($attachment['date_uploaded'])); ?></span>
</div>
<div class="row small">
	<span class="col-sm-6"><strong>Uploaded By :</strong></span>
	<span class="col-sm-6"><?= ucwords($attachment['given_name'].' '.$attachment['middle_name'].' '.$attachment['last_name'].' '.$attachment['name_suffix']); ?></span>
</div>

<br><br>

<div class="row">
	<div class="col-sm-6">
		<a id="cancel-attachment-delete" class="btn btn-primary btn-block btn-sm" href="#">Cancel</a>
	</div>
	<div class="col-sm-6">
		<a id="confirm-attachment-delete" class="btn btn-danger btn-block btn-sm" href="#">Confirm</a>
	</div>
</div>