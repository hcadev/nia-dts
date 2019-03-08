<div class="row">
	<div class="col-lg-12">

		<?php if ($success && $action == 'update'): ?>
			<div class="alert alert-success small">Project no. <?= $project['id'].', '.$project['name'].', '; ?> has been updated.</div>
		<?php elseif ($success && $action == 'add'): ?>
			<div class="alert alert-success small">Project no. <?= $project['id'].', '.$project['name'].', '; ?> has been added.</div>
		<?php endif; ?>

		<form id="<?= empty($project['id']) ? 'project-add-form' : 'project-edit-form'; ?>" class="form-horizontal">

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Date Proposed</label>
				<div class="col-lg-7">
					<input class="form-control" type="date" name="date_proposed" value="<?= isset($project['date_proposed']) ? $project['date_proposed'] : ''; ?>">
					<span class="text-danger small"><?= isset($errors['date_proposed']) ? $errors['date_proposed'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Fund Source</label>
				<div class="col-lg-7">
					<input class="form-control" type="text" name="title" value="<?= isset($project['title']) ? $project['title'] : ''; ?>">
					<span class="text-danger small"><?= isset($errors['title']) ? $errors['title'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Name of System</label>
				<div class="col-lg-7">
					<input class="form-control" type="text" name="name" value="<?= isset($project['name']) ? $project['name'] : ''; ?>">
					<span class="text-danger small"><?= isset($errors['name']) ? $errors['name'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Systems Category</label>
				<div class="col-lg-7">
					<select class="form-control" name="category">
						<option value="Communal Irrigation System" selected>Communal Irrigation System</option>
						<option value="Communal Irrigation Project" <?= isset($project['category']) && $project['category'] == 'Communal Irrigation Project' ? 'selected' : ''; ?>>Communal Irrigation Project</option>
						<option value="National Irrigation System" <?= isset($project['category']) && $project['category'] == 'National Irrigation System' ? 'selected' : ''; ?>>National Irrigation System</option>
						<option value="Small Irrigation System" <?= isset($project['category']) && $project['category'] == 'Small Irrigation System' ? 'selected' : ''; ?>>Small Irrigation System</option>
						<option value="Small Irrigation Project" <?= isset($project['category']) && $project['category'] == 'Small Irrigation Project' ? 'selected' : ''; ?>>Small Irrigation Project</option>
						<option value="Pump Irrigation System" <?= isset($project['category']) && $project['category'] == 'Pump Irrigation System' ? 'selected' : ''; ?>>Pump Irrigation System</option>
						<option value="Pump Irrigation Project" <?= isset($project['category']) && $project['category'] == 'Pump Irrigation Project' ? 'selected' : ''; ?>>Pump Irrigation Project</option>
					</select>
					<span class="text-danger small"><?= isset($errors['category']) ? $errors['category'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Project Description</label>
				<div class="col-lg-7">
					<input class="form-control" type="text" name="description" value="<?= isset($project['description']) ? $project['description'] : ''; ?>">
					<span class="text-danger small"><?= isset($errors['description']) ? $errors['description'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Municipality</label>
				<div class="col-lg-7">
					<select class="form-control" name="municipality_id">
						<?php for ($i = 0; $i < count($municipalities); $i++): ?>
							<?php if ($i == 0): ?>
								<option value="<?= $municipalities[$i]['id']; ?>" selected><?= $municipalities[$i]['name']; ?></option>
							<?php else: ?>
								<option value="<?= $municipalities[$i]['id']; ?>" <?= isset($project['municipality_id']) && $project['municipality_id'] == $municipalities[$i]['id'] ? 'selected' : ''; ?>><?= $municipalities[$i]['name']; ?></option>
							<?php endif; ?>
						<?php endfor; ?>
					</select>
					<span class="text-danger small"><?= isset($errors['municipality_id']) ? $errors['municipality_id'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Project Cost</label>
				<div class="col-lg-7">
					<div class="input-group input-group-sm">
						<div class="input-group-addon">&#8369;</div>
						<input class="form-control text-right" type="text" name="cost" value="<?= isset($project['cost']) ? $project['cost'] : ''; ?>">
					</div>
					<span class="text-danger small"><?= isset($errors['cost']) ? $errors['cost'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Service Area</label>
				<div class="col-lg-7">
					<div class="input-group input-group-sm">
						<input class="form-control text-right" type="text" name="area" value="<?= isset($project['area']) ? $project['area'] : ''; ?>">
						<div class="input-group-addon">
							<select name="area_unit">
<!--								<option value="m&sup2;" selected>m&sup2;</option>-->
								<option value="ha" selected>ha</option>
							</select>
						</div>
					</div>
					<span class="text-danger small"><?= isset($errors['area']) ? $errors['area'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group">
<!--				<div class="col-lg-3 col-lg-offset-4">-->
<!--					<a id="close-project-form" href="#" class="btn btn-primary btn-block btn-sm">Cancel</a>-->
<!--				</div>-->
				<div class="col-lg-3 col-lg-offset-8">
					<input type="submit" class="btn btn-primary btn-block btn-sm" value="Submit">
				</div>
			</div>

		</form>
	</div>
</div>