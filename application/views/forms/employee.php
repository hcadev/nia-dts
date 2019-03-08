<div class="row">
	<div class="col-lg-12">

		<?php if ($success): ?>
			<div class="alert alert-success small">Employee no. <?= $id; ?> has been added.</div>
		<?php endif; ?>

		<?php if ( ! empty($success_update)): ?>
			<div class="alert alert-success small">Employee information has been updated.</div>
		<?php endif; ?>

		<?php if (empty($employee['id'])): ?>
			<div class="alert alert-warning small">Warning! Some positions require only 1 employee to be active. To replace the currently assigned employee, tick the checkbox below, otherwise, newly added employee will not be able to access the system unless activated manually.</div>
		<?php endif; ?>

		<form id="employee-form" class="form-horizontal" method="<?= empty($employee['id']) ? 'get' : 'post'; ?>">

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Given Name</label>
				<div class="col-lg-7">
					<?php if (empty($employee['id']) || $employee['id'] == $user['id']): ?>
						<input class="form-control" type="text" name="given_name" value="<?= isset($employee['given_name']) ? $employee['given_name'] : ''; ?>">
					<?php else: ?>
						<p class="form-control-static"><?= $employee['given_name']; ?></p>
					<?php endif; ?>
					<span class="text-danger small"><?= isset($errors['given_name']) ? $errors['given_name'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Middle Name</label>
				<div class="col-lg-7">
					<?php if (empty($employee['id']) || $employee['id'] == $user['id']): ?>
						<input class="form-control" type="text" name="middle_name" value="<?= isset($employee['middle_name']) ? $employee['middle_name'] : ''; ?>">
					<?php else: ?>
						<p class="form-control-static"><?= $employee['middle_name']; ?></p>
					<?php endif; ?>
					<span class="text-danger small"><?= isset($errors['middle_name']) ? $errors['middle_name'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Last Name</label>
				<div class="col-lg-7">
					<?php if (empty($employee['id']) || $employee['id'] == $user['id']): ?>
						<input class="form-control" type="text" name="last_name" value="<?= isset($employee['last_name']) ? $employee['last_name'] : ''; ?>">
					<?php else: ?>
						<p class="form-control-static"><?= $employee['last_name']; ?></p>
					<?php endif; ?>
					<span class="text-danger small"><?= isset($errors['last_name']) ? $errors['last_name'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Name Suffix</label>
				<div class="col-lg-7">
					<?php if (empty($employee['id']) || $employee['id'] == $user['id']): ?>
						<input class="form-control" type="text" name="name_suffix" value="<?= isset($employee['name_suffix']) ? $employee['name_suffix'] : ''; ?>">
					<?php else: ?>
						<p class="form-control-static"><?= $employee['name_suffix']; ?></p>
					<?php endif; ?>
					<span class="text-danger small"><?= isset($errors['name_suffix']) ? $errors['name_suffix'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Username</label>
				<div class="col-lg-7">
					<?php if (empty($employee['id']) || $employee['id'] == $user['id']): ?>
						<input class="form-control" type="text" name="username" value="<?= isset($employee['username']) ? $employee['username'] : ''; ?>">
					<?php else: ?>
						<p class="form-control-static"><?= $employee['username']; ?></p>
					<?php endif; ?>
					<span class="text-danger small"><?= isset($errors['username']) ? $errors['username'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Password</label>
				<div class="col-lg-7">
					<?php if (empty($employee['id']) || $employee['id'] == $user['id']): ?>
						<input class="form-control" type="password" name="password">
					<?php endif; ?>
					<span class="text-danger small"><?= isset($errors['password']) ? $errors['password'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Confirm Password</label>
				<div class="col-lg-7">
					<?php if (empty($employee['id']) || $employee['id'] == $user['id']): ?>
						<input class="form-control" type="password" name="confirm_password">
					<?php endif; ?>
					<span class="text-danger small"><?= isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Email</label>
				<div class="col-lg-7">
					<?php if (empty($employee['id']) || $employee['id'] == $user['id']): ?>
						<input class="form-control" type="text" name="email" value="<?= isset($employee['email']) ? $employee['email'] : ''; ?>">
					<?php else: ?>
						<p class="form-control-static"><?= $employee['email']; ?></p>
					<?php endif; ?>
					<span class="text-danger small"><?= isset($errors['email']) ? $errors['email'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-lg-3 col-lg-offset-1">Position</label>
				<div class="col-lg-7">
					<?php if (in_array('Edit Employee', $user['privileges']) && (empty($employee['id']) || $employee['id'] != $user['id'])): ?>
						<select class="form-control" name="position_id">
							<?php foreach ($positions AS $position): ?>
								<option value="<?= $position['id']; ?>" <?= isset($employee['position_id']) && $position['id'] == $employee['position_id'] ? 'selected' : ''; ?>><?= $position['name']; ?></option>
							<?php endforeach; ?>
						</select>
					<?php else: ?>
						<p class="form-control-static"><?= $employee['position']; ?></p>
					<?php endif; ?>
					<span class="text-danger small"><?= isset($errors['position_id']) ? $errors['position_id'] : ''; ?></span>
				</div>
			</div>

			<div class="form-group">
				<div class="col-lg-4 col-lg-offset-4">
					<?php if (empty($employee['id'])): ?>
						<div class="checkbox">
							<label><input class="small" type="checkbox" name="replace" <?= isset($employee['replace']) && $employee['replace'] ? 'checked' : ''; ?>>Replace currently assigned employee.</label>
						</div>
					<?php endif; ?>
				</div>
				<?php if (in_array('Edit Employee', $user['privileges']) || in_array('Create Employee', $user['privileges']) || $employee['id'] == $user['id']): ?>
					<div class="col-lg-3">
						<input type="submit" class="btn btn-primary btn-block btn-sm" value="Submit">
					</div>
				<?php endif; ?>
			</div>

		</form>
	</div>
</div>