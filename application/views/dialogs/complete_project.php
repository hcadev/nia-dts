<?php if (isset($error)): ?>
	<div class="alert alert-danger small"><?= $error; ?></div>
<?php endif; ?>

<form id="project-complete" class="form-horizontal">
	<div class="form-group form-group-sm">
		<label class="col-lg-3 control-label">Completion Date : </label>
		<div class="col-lg-5">
			<p class="form-control-static"><?= date('F d, Y'); ?></p>
		</div>
		<div class="col-lg-4">
			<input class="btn btn-success btn-block btn-sm" type="submit" value="Complete Project">
		</div>
</form>