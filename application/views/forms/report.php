<div class="row">
	<div class="col-lg-12">

		<?php if (isset($error)): ?>
			<div class="alert alert-danger small"><?= $error; ?></div>
		<?php endif; ?>

		<form id="report-form" class="form-horizontal" enctype="multipart/form-data">
			<div class="form-group form-group-sm">
				<label class="col-lg-4 col-lg-offset-1">Title</label>
				<div class="col-lg-6">
					<input class="form-control" type="text" name="title" value="<?= isset($report['title']) ? $report['title'] : ''; ?>">
					<span class="text-danger small"><?= isset($errors['title']) ? $errors['title'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="col-lg-4 col-lg-offset-1">File</label>
				<div class="col-lg-6">
					<input class="form-control" type="file" name="file" accept="application/pdf">
					<span class="text-danger small"><?= isset($errors['file']) ? $errors['file'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="col-lg-4 col-lg-offset-1">Physical Accomplishment Progress</label>
				<div class="col-lg-5">
					<input class="form-control" type="number" name="pa_progress" min="1" max="<?= 100 - $project['pa_progress'] + (empty($report['pa_progress']) ? 0 : $report['pa_progress']); ?>" value="<?= isset($report['pa_progress']) ? $report['pa_progress'] : ''; ?>">
					<span class="text-danger small"><?= isset($errors['pa_progress']) ? $errors['pa_progress'] : ''; ?></span>
				</div>
				<div class="col-lg-1">/ <?= 100 - $project['pa_progress'] + (empty($report['pa_progress']) ? 0 : $report['pa_progress']); ?> </div>
			</div>

			<div class="form-group form-group-sm">
				<label class="col-lg-4 col-lg-offset-1">Financial Report Progress</label>
				<div class="col-lg-5">
					<input class="form-control" type="number" name="fr_progress" min="1" max="<?= 100 - $project['fr_progress'] + (empty($report['fr_progress']) ? 0 : $report['fr_progress']); ?>" value="<?= isset($report['fr_progress']) ? $report['fr_progress'] : ''; ?>">
					<span class="text-danger small"><?= isset($errors['fr_progress']) ? $errors['fr_progress'] : ''; ?></span>
				</div>
				<div class="col-lg-1">/ <?= 100 - $project['fr_progress'] + (empty($report['fr_progress']) ? 0 : $report['fr_progress']); ?> </div>
			</div>

			<div class="form-group">
				<div class="col-lg-4 col-lg-offset-7">
					<input class="btn btn-primary btn-block btn-sm" type="submit" name="upload" value="Upload">
				</div>
			</div>
		</form>
	</div>
</div>