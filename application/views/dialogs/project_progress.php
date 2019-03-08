<?php if (isset($error)): ?>
	<div class="alert alert-danger small"><?= $error; ?></div>
<?php endif; ?>

<form id="project-progress" class="form-horizontal">
	<div class="form-group form-group-sm">
		<label class="col-lg-7 col-lg-offset-1 control-label">Physical Accomplishment Progress : </label>
		<div class="col-lg-2">
			<input class="form-control text-center" type="number" name="pa_progress" value="<?= $project['pa_progress']; ?>" min="0" max="100" step="1">
		</div>
		<div class="col-lg-1">
			<small>/100</small>
		</div>
	</div>
	<div class="form-group form-group-sm">
		<label class="col-lg-7 col-lg-offset-1 control-label">Financial Reports Progress : </label>
		<div class="col-lg-2">
			<input class="form-control text-center" type="number" name="fr_progress" value="<?= $project['fr_progress']; ?>" min="0" max="100" step="1">
		</div>
		<div class="col-lg-1">
			<small>/100</small>
		</div>
	</div>
	<div class="form-group form-group-sm">
		<div class="col-lg-2 col-lg-offset-8">
			<input class="btn btn-primary btn-block btn-sm" type="submit" value="Set">
		</div>
	</div>
</form>