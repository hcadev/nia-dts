<?php if (isset($error)): ?>
	<div class="alert alert-danger small"><?= $error; ?></div>
<?php endif; ?>

<form id="project-extend" class="form-horizontal">
	<div class="form-group form-group-sm">
		<label class="col-lg-3 control-label">Completion Date : </label>
		<div class="col-lg-5">
			<input class="form-control text-center" type="date" name="completion_date" value="<?= $project['completion_date']; ?>" min="<?= $project['completion_date']; ?>">
		</div>
		<div class="col-lg-4">
			<input class="btn btn-primary btn-block btn-sm" type="submit" value="Extend Project">
		</div>
</form>