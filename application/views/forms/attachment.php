<div class="row">
	<div class="col-lg-12">

		<?php if (isset($error)): ?>
			<div class="alert alert-danger small"><?= $error; ?></div>
		<?php endif; ?>

		<form id="attachment-form" class="form-horizontal" enctype="multipart/form-data">

			<div class="form-group form-group-sm">
				<div class="col-lg-7 col-lg-offset-1">
					<input class="form-control" type="file" name="file" accept="application/pdf">
					<span class="text-danger small"><?= isset($errors['file']) ? $errors['file'] : ''; ?></span>
				</div>
				<div class="col-lg-3">
					<input class="btn btn-primary btn-block btn-sm" type="submit" name="upload" value="Upload">
				</div>
			</div>

		</form>
	</div>
</div>