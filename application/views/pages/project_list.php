<div class="row">
	<div class="col-lg-10 col-lg-offset-1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-3"><h5>Projects</h5></div>
					<div class="col-lg-5">
						<form>
							<div class="input-group input-group-sm">
								<input class="form-control" type="text" name="keyword" value="<?= isset($keyword) ? $keyword : ''; ?>" placeholder="Enter search keyword here. . .">
								<div class="input-group-btn">
									<input class="btn btn-default" type="submit" value="Go!">
								</div>
							</div>
						</form>
					</div>
					<div class="col-lg-4 text-right">
<!--						<a id="refresh-employee-list" class="btn btn-default btn-sm" onclick="location.reload();" href="#"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>-->
						<?php if (in_array('Create Project', $user['privileges'])): ?>
							<a id="new-project" class="btn btn-default btn-sm" href="#"><span class="glyphicon glyphicon-plus"></span> Add</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<table class="table table-bordered table-striped table-hover small">
					<tr>
						<th class="text-center col-lg-1">#</th>
						<th class="text-center col-lg-1">ID</th>
						<th class="text-center col-lg-2">Date Proposed</th>
						<th class="text-center col-lg-3">Name</th>
						<th class="text-center col-lg-2">Status</th>
						<th class="text-center col-lg-3"></th>
					</tr>
					<?php if (empty($projects)): ?>
						<tr>
							<td colspan="5" class="text-center text-danger">No records found.</td>
						</tr>
					<?php else: ?>
						<?php $counter = 0; ?>
						<?php foreach ($projects AS $project): ?>
							<?php $counter++; ?>
							<?php $attachment_progress = floor(($project['file_count'] / $project['total_file_count']) * 100); ?>
							<?php $pa_progress = $project['pa_progress']; ?>
							<?php $fr_progress = $project['fr_progress']; ?>
							<?php $overall_progress = ($attachment_progress * .5) + ($pa_progress * .25) + ($fr_progress * .25); ?>
							<?php if ($project['deleted'] == 0 || ($project['deleted'] == 1 && in_array('Restore Project', $user['privileges']))): ?>
								<div class="pop-content-<?=$project['id']; ?> hidden">
									<h5 class="text-center text-primary">PROJECT PREVIEW</h5>
									<hr>
									<div class="row popover-row small">
										<span class="col-xs-4"><strong>ID :</strong></span>
										<span class="col-xs-8"><?= $project['id']; ?></span>
									</div>
									<div class="row popover-row small">
										<span class="col-xs-4"><strong>Date Proposed :</strong></span>
										<span class="col-xs-8"><?= date('F d, Y', strtotime($project['date_proposed'])); ?></span>
									</div>
									<div class="row popover-row small">
										<span class="col-xs-4"><strong>Fund Source :</strong></span>
										<span class="col-xs-8"><?= $project['title']; ?></span>
									</div>
									<div class="row popover-row small">
										<span class="col-xs-4"><strong>Name of System :</strong></span>
										<span class="col-xs-8"><?= $project['name']; ?></span>
									</div>
									<div class="row popover-row small">
										<span class="col-xs-4"><strong>Systems Category :</strong></span>
										<span class="col-xs-8"><?= $project['category']; ?></span>
									</div>
									<div class="row popover-row small">
										<span class="col-xs-4"><strong>Project Description :</strong></span>
										<span class="col-xs-8"><?= $project['description']; ?></span>
									</div>
									<div class="row popover-row small">
										<span class="col-xs-4"><strong>Current Location : </strong></span>
										<span class="col-xs-8"><?= empty($project['transition_status']) ? $project['sender_name'] : ($project['transition_status'] == 'Received' ? $project['recipient_name'] : 'Sent to '.$project['recipient_name']); ?></span>
									</div>
									<div class="row popover-row small">
										<span class="col-xs-4"><strong>Remarks : </strong></span>
										<span class="col-xs-8 <?= strpos($project['remarks'], 'For correction') === 0 ? 'text-danger' : ''; ?>"><?= $project['remarks']; ?></span>
									</div>
									<div class="row popover-row small">
										<div class="col-xs-4"><strong>Attachments :</strong></div>
										<div class="col-xs-6">
											<div class="progress progress-striped progress-popover active">
												<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $attachment_progress.'%'; ?>;"></div>
											</div>
										</div>
										<div class="col-xs-1 text-primary"><?= $attachment_progress.'%'; ?></div>
									</div>
									<div class="row popover-row small">
										<div class="col-xs-4"><strong>Physical Accomplishment :</strong></div>
										<div class="col-xs-6">
											<div class="progress progress-striped progress-popover active">
												<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $pa_progress.'%'; ?>;"></div>
											</div>
										</div>
										<div class="col-xs-1 text-primary"><?= $pa_progress.'%'; ?></div>
									</div>
									<div class="row popover-row small">
										<div class="col-xs-4"><strong>Financial Report :</strong></div>
										<div class="col-xs-6">
											<div class="progress progress-striped progress-popover active">
												<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $fr_progress.'%'; ?>;"></div>
											</div>
										</div>
										<div class="col-xs-1 text-primary"><?= $fr_progress.'%'; ?></div>
									</div>
									<div class="row popover-row small">
										<div class="col-xs-4"><strong>Overall Progress :</strong></div>
										<div class="col-xs-6">
											<div class="progress progress-striped progress-popover active">
												<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $overall_progress.'%'; ?>;"></div>
											</div>
										</div>
										<div class="col-xs-1 text-primary"><?= $overall_progress.'%'; ?></div>
									</div>
								</div>
								<tr>
									<td class="text-center"><?= $counter; ?></td>
									<td class="text-center"><?= $project['id']; ?></td>
									<td class="text-center"><?= date('F d, Y', strtotime($project['date_proposed'])); ?></td>
									<td>
										<a class="project-name text-primary" href="#" data-toggle="popover"><?= strtoupper($project['name']); ?></a>
									</td>
									<td class="text-center"><?= $project['status']; ?></td>
									<td>
											<a class="btn btn-primary btn-xs" href="<?= URL::site('project/view/'.$project['id']); ?>"><span class="glyphicon glyphicon-eye-open"></span> <small>More Info</small></a>
										<?php if (
											(
												(empty($project['recipient_id']) && $user['id'] == $project['sender_id'])
												|| ($project['recipient_id'] == $user['id'] && preg_match('/Approved|Declined/', $project['transition_status']) && $project['recipient_position'] == 'Head of Planning & Design Unit')
												|| ($project['recipient_id'] == $user['id'] && preg_match('/Approved|Declined/', $project['transition_status']) && $project['recipient_position'] == 'Head of Planning & Design Section')
												|| ($project['recipient_id'] == $user['id'] && preg_match('/Approved|Declined/', $project['transition_status']) && $project['recipient_position'] == 'Division Manager')
												|| ($project['recipient_id'] == $user['id'] && preg_match('/Approved|Declined/', $project['transition_status']) && $project['recipient_position'] == 'Regional Irrigation Manager')
												|| ($project['recipient_id'] == $user['id'] && preg_match('/Received/', $project['transition_status']) && $project['recipient_position'] == 'Regional Irrigation Manager\'s Secretary' && (strpos(trim($project['remarks']), 'Proceed with project.') > 0 || strpos(trim($project['remarks']), 'For correction.') === 0))
											) && $project['file_count'] == $project['total_file_count']): ?>
												<a class="btn btn-primary btn-xs send-project" href="#"><span class="glyphicon glyphicon-envelope"></span> <small>Send</small></a>
											<?php elseif ($project['recipient_id'] == $user['id'] && $project['transition_status'] == 'Sent'): ?>
												<a class="btn btn-primary btn-xs receive-project" href="#"><span class="glyphicon glyphicon-open-file"></span> <small>Receive</small></a>
											<?php endif; ?>
											<?php if (in_array('Edit Project', $user['privileges']) && ((empty($project['recipient_id']) && $user['id'] == $project['sender_id']) || ($project['recipient_id'] == $user['id'] && $project['transition_status'] == 'Received'))): ?>
												<a class="btn btn-warning btn-xs edit-project" href="#"><span class="glyphicon glyphicon-pencil"></span> <small>Edit</small></a>
											<?php endif; ?>
										<?php if (in_array('Delete Project', $user['privileges']) && ((empty($project['recipient_id']) && $user['id'] == $project['sender_id']) || ($project['recipient_id'] == $user['id'] && $project['transition_status'] == 'Received'))): ?>
											<a class="btn btn-danger btn-xs delete-project" href="#"><span class="glyphicon glyphicon-remove"></span> <small>Delete</small></a>
										<?php elseif (in_array('Restore Project', $user['privileges']) && $project['deleted'] == 1): ?>
											<a class="btn btn-success btn-xs restore-project" href="#"><span class="glyphicon glyphicon-repeat"></span> <small>Restore</small></a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</table>
			</div>
		</div>
	</div>
</div>