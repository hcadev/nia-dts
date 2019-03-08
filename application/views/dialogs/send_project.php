<?php if (isset($error)): ?>
	<div class="alert alert-danger small"><?= $error; ?></div>
<?php endif; ?>

<?php if (empty($employee)): ?>
	<div class="alert alert-danger small">
		<?php if (empty($project['recipient_id'])): ?>
			Head of Planning & Design Unit position is currently vacant, can't send project.
		<?php elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Head of Planning & Design Unit'): ?>
			Head of Planning & Design Section position is currently vacant, can't send project.
		<?php elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Head of Planning & Design Section'): ?>
			Division Manager position is currently vacant, can't send project.
		<?php elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Division Manager'): ?>
			Regional Irrigation Manager position is currently vacant, can't send project.
		<?php elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Regional Irrigation Manager'): ?>
			Regional Irrigation Manager's Secretary position is currently vacant, can't send project.
		<?php elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Head of Planning & Design Section'): ?>
			Regional Irrigation Manager's Secretary position is currently vacant, can't send project.
		<?php elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Division Manager'): ?>
			Head of Planning & Design Section
		<?php elseif ($project['transition_status'] == 'Declined' && $project['recipient_position'] == 'Regional Irrigation Manager'): ?>
			Division Manager position is currently vacant, can't send project.
		<?php endif; ?>
	</div>
<?php else: ?>
	<form  id="project-send" class="form-horizontal">
		<div class="form-group form-group-sm">
			<div class="col-lg-4">
				<label class="control-label">Recipient</label>
				<p id="recipient" class="form-control-static">
					<span id="recipient-id" class="hidden"><?= $employee['id']; ?></span>
					<strong><?= $employee['last_name'].', '.$employee['given_name'][0].'.'; ?></strong>
					<?= ' ('.$employee['position'].')'; ?>
				</p>
			</div>

			<div class="col-lg-2">
				<label class="control-label">Purpose</label>
				<p id="purpose" class="form-control-static">
					<?php if (empty($project['recipient_id']) || (strpos(trim($project['remarks']), 'For correction.') === 0 && $project['recipient_position'] == 'Regional Irrigation Manager\'s Secretary')): ?>
						For Checking.
					<?php elseif ($project['transition_status'] == 'Approved' &&  $project['recipient_position'] == 'Head of Planning & Design Unit'): ?>
						For Checking.
					<?php elseif ($project['transition_status'] == 'Approved' &&  $project['recipient_position'] == 'Head of Planning & Design Section'): ?>
						Recommending Approval.
					<?php elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Division Manager'): ?>
						For Approval.
					<?php elseif ($project['transition_status'] == 'Approved' && $project['recipient_position'] == 'Regional Irrigation Manager'): ?>
						Proceed with project.
					<?php elseif ($project['transition_status'] == 'Declined'): ?>
						For correction.
					<?php endif; ?>
				</p>
			</div>
			<div class="col-lg-4">
				<label class="control-label">Remarks</label>
				<textarea name="remarks" class="form-control">
					<?= isset($transition['remarks']) ? $transition['remarks'] : ''; ?>
				</textarea>
			</div>
			<div class="col-lg-2">
				<label style="visibility: hidden;">x</label>
				<input class="btn btn-primary btn-block btn-sm" type="submit" value="Send">
			</div>
		</div>
	</form>
<?php endif; ?>