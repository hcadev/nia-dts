<?php if (isset($error)): ?>
	<div class="alert alert-danger small"><?= $error; ?></div>
<?php endif; ?>

<div class="row small">
	<span class="col-sm-6"><strong>Project No. :</strong></span>
	<span class="col-sm-6"><?= $project['id']; ?></span>
</div>
<div class="row small">
	<span class="col-sm-6"><strong>Date Proposed :</strong></span>
	<span class="col-sm-6"><?= date('F d, Y', strtotime($project['date_proposed'])); ?></span>
</div>
<div class="row small">
	<span class="col-sm-6"><strong>Fund Source :</strong></span>
	<span class="col-sm-6"><?= $project['title']; ?></span>
</div>
<div class="row small">
	<span class="col-sm-6"><strong>Name of System :</strong></span>
	<span class="col-sm-6"><?= $project['name']; ?></span>
</div>
<div class="row small">
	<span class="col-sm-6"><strong>Systems Category :</strong></span>
	<span class="col-sm-6"><?= $project['category']; ?></span>
</div>
<div class="row small">
	<span class="col-sm-6"><strong>Project Description :</strong></span>
	<span class="col-sm-6"><?= $project['description']; ?></span>
</div>

<br><br>

<div class="row">
	<div class="col-sm-6">
		<a id="cancel-project-delete" class="btn btn-primary btn-block btn-sm" href="#">Cancel</a>
	</div>
	<div class="col-sm-6">
		<a id="confirm-project-delete" class="btn btn-danger btn-block btn-sm" href="#">Confirm</a>
	</div>
</div>