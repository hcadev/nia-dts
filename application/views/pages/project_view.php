<?php if (empty($project)): ?>
	<?= View::factory('errors/404'); ?>
<?php else: ?>
	<?php $attachment_progress = floor(($project['file_count'] / $project['total_file_count']) * 100); ?>
	<?php $pa_progress = $project['pa_progress']; ?>
	<?php $fr_progress = $project['fr_progress']; ?>
	<?php $overall_progress = ($attachment_progress * .5) + ($pa_progress * .25) + ($fr_progress * .25); ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<h5 class="text-primary">PROJECT INFO</h5>
						</div>
						<div class="col-lg-4 col-lg-offset-5 text-right">
							<?php if (
								(
									(empty($project['recipient_id']) && $user['id'] == $project['sender_id'])
									|| ($project['recipient_id'] == $user['id'] && preg_match('/Approved|Declined/', $project['transition_status']) && $project['recipient_position'] == 'Head of Planning & Design Unit')
									|| ($project['recipient_id'] == $user['id'] && preg_match('/Approved|Declined/', $project['transition_status']) && $project['recipient_position'] == 'Head of Planning & Design Section')
									|| ($project['recipient_id'] == $user['id'] && preg_match('/Approved|Declined/', $project['transition_status']) && $project['recipient_position'] == 'Division Manager')
									|| ($project['recipient_id'] == $user['id'] && preg_match('/Approved|Declined/', $project['transition_status']) && $project['recipient_position'] == 'Regional Irrigation Manager')
									|| ($project['recipient_id'] == $user['id'] && preg_match('/Received/', $project['transition_status']) && $project['recipient_position'] == 'Regional Irrigation Manager\'s Secretary' && (strpos(trim($project['remarks']), 'Proceed with project.') > 0 || strpos(trim($project['remarks']), 'For correction.') === 0))
								) && $project['file_count'] == $project['total_file_count']): ?>
								<a id="project-send" class="btn btn-primary btn-sm" href="#"><span class="glyphicon glyphicon-envelope"></span> Send</a>
							<?php elseif ($project['recipient_id'] == $user['id'] && $project['transition_status'] == 'Sent'): ?>
								<a id="project-receive" class="btn btn-primary btn-sm" href="#"><span class="glyphicon glyphicon-open-file"></span> Receive</a>
							<?php endif; ?>
							<?php if ($project['recipient_id'] == $user['id'] && preg_match('/Received/', $project['transition_status'])
								&& ($project['recipient_position'] == 'Head of Planning & Design Unit'
								|| $project['recipient_position'] == 'Head of Planning & Design Section'
								|| $project['recipient_position'] == 'Division Manager'
								|| $project['recipient_position'] == 'Regional Irrigation Manager'
								)): ?>
								<a id="project-approve" class="btn btn-success btn-sm" href="#"><span class="glyphicon glyphicon-ok"></span> Approve</a>
								<a id="project-decline" class="btn btn-danger btn-sm" href="#"><span class="glyphicon glyphicon-thumbs-down"></span> Decline</a>
							<?php endif; ?>
							<a id="project-history" class="btn btn-primary btn-sm" href="#"><span class="glyphicon glyphicon-list"></span> History</a>
<!--							<a class="btn btn-primary btn-sm" href="#" onclick="location.reload();"><span class="glyphicon glyphicon-repeat"></span> Refresh</a>-->
							<?php if (in_array('Edit Project', $user['privileges']) && ((empty($project['recipient_id']) && $user['id'] == $project['sender_id']) || ($project['recipient_id'] == $user['id'] && $project['transition_status'] == 'Received'))): ?>
								<a id="project-edit" class="btn btn-primary btn-sm" href="#"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row small">
						<div class="col-lg-6">
							<p class="row">
								<span class="col-lg-4"><strong>ID :</strong></span>
								<span class="col-lg-8" id="project-id"><?= $project['id']; ?></span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Date Proposed :</strong></span>
								<span class="col-lg-8" id="project-id"><?= date('F d, Y', strtotime($project['date_proposed'])); ?></span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Fund Source :</strong></span>
								<span class="col-lg-8"><?= $project['title']; ?></span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Name :</strong></span>
								<span class="col-lg-8" id="project-name"><?= $project['name']; ?></span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Category :</strong></span>
								<span class="col-lg-8"><?= $project['category']; ?></span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Description :</strong></span>
								<span class="col-lg-8"><?= $project['description']; ?></span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Municipality :</strong></span>
								<span class="col-lg-8"><?= $project['municipality_name']; ?></span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Cost :</strong></span>
								<span class="col-lg-8">&#8369;<?= number_format($project['cost'], 2, '.', ','); ?></span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Service Area :</strong></span>
								<span class="col-lg-8"><?= number_format($project['area'], 2, '.', ',').' '.$project['area']; ?></span>
							</p>
						</div>
						<div class="col-lg-6">
							<p class="row">
								<span class="col-lg-4"><strong>Current Location : </strong></span>
								<span class="col-lg-8">
									<?= empty($project['transition_status']) ? $project['sender_name'] : ($project['transition_status'] == 'Received' ? $project['recipient_name'] : 'Sent to '.$project['recipient_name']); ?>
									<br>
									<i><?= empty($project['transition_status']) ? $project['sender_name'] : ($project['transition_status'] == 'Received' ? $project['recipient_position'] : $project['recipient_position']); ?></i>
								</span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Remarks : </strong></span>
								<span class="col-lg-8 <?= strpos($project['remarks'], 'For correction') === 0 ? 'text-danger' : ''; ?>">
									<?= $project['remarks']; ?>
								</span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Approvals : </strong></span>
								<span class="col-lg-8">
									<span>Head of Planning & Design Unit</span> <span class="label label-success pull-right"><?= $project['approvals'] > 0 ? 'APPROVED' : ''; ?></span>
									<br>
									<span>Head of Planning & Design Section</span> <span class="label label-success pull-right"><?= $project['approvals'] > 1 ? 'APPROVED' : ''; ?></span>
									<br>
									<span>Division Manager</span> <span class="label label-success pull-right"><?= $project['approvals'] > 2 ? 'APPROVED' : ''; ?></span>
									<br>
									<span>Regional Irrigation Manager</span> <span class="label label-success pull-right"><?= $project['approvals'] > 3 ? 'APPROVED' : ''; ?></span>
								</span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Status : </strong></span>
								<span class="col-lg-8">
									<?= $project['status']; ?>
								</span>
							</p>
							<p class="row">
								<span class="col-lg-4"><strong>Duration : </strong></span>
								<span class="col-lg-8">
									<?= preg_match('/Ongoing Construction|Completed/', $project['status']) ? date('F d, Y', strtotime($project['start_date'])).'  &mdash;  '.date('F d, Y', strtotime($project['completion_date'])) : ''; ?>
								</span>
							</p>
							<div class="row">
								<div class="col-lg-4"><strong>Attachment Progress : </strong></div>
								<div class="col-lg-7">
									<div class="progress progress-striped progress-popover active">
										<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $attachment_progress.'%'; ?>;">
										</div>
									</div>
								</div>
								<div class="col-lg-1 text-primary">
									<?= $attachment_progress.'%'; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4"><strong>Physical Accomplishment Progress: </strong></div>
								<div class="col-lg-7">
									<div class="progress progress-striped progress-popover active">
										<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $pa_progress.'%'; ?>;">
										</div>
									</div>
								</div>
								<div class="col-lg-1 text-primary">
									<?= $pa_progress.'%'; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4"><strong>Financial Reports Progress : </strong></div>
								<div class="col-lg-7">
									<div class="progress progress-striped progress-popover active">
										<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $fr_progress.'%'; ?>;">
										</div>
									</div>
								</div>
								<div class="col-lg-1 text-primary">
									<?= $fr_progress.'%'; ?>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4"><strong>Overall Progress : </strong></div>
								<div class="col-lg-7">
									<div class="progress progress-striped progress-popover active">
										<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?= $overall_progress.'%'; ?>;">
										</div>
									</div>
								</div>
								<div class="col-lg-1 text-success">
									<?= $overall_progress.'%'; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-3">
							<h5 class="text-primary">DETAILS</h5>
						</div>
						<div class="col-lg-4 col-lg-offset-5 text-right">

						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-10 col-lg-offset-1">
							<h6 class="row text-primary">
								<div class="col-lg-3">
									<strong>ATTACHMENTS</strong>
								</div>
							</h6>

							<hr>

							<!--							--><?php //var_dump($attachments); ?>
							<?php $set_a_complete = TRUE; ?>
							<div class="row small">
								<div class="col-lg-12">
									<strong>1. Program of Work</strong>
								</div>
							</div>
							<div class="row small">
								<div class="col-lg-12">
									<table class="table table-bordered table-striped table-hover">
										<tr>
											<th class="text-center col-lg-2">Date</th>
											<th class="text-center col-lg-7">Title</th>
											<th class="text-center col-lg-1">Revisions</th>
											<th class="text-center col-lg-2"></th>
										</tr>
										<?php foreach ($attachments AS $attachment): ?>
											<?php if ($attachment['category'] == 'Program of Work'): ?>
												<tr>
													<td class="text-center"><?= empty($attachment['date_uploaded']) ? 'N/A' : date('F d, Y h:i:s A', strtotime($attachment['date_uploaded'])); ?></td>
													<td>
														<?php if (empty($attachment['filename'])): ?>
															<span class="hidden attachment-id"><?= $attachment['attachment_id']; ?></span>
															<span class="attachment-name"><?= $attachment['name']; ?></span>
														<?php else: ?>
															<a class="view-attachment text-primary" href="#">
																<span class="hidden attachment-id"><?= $attachment['attachment_id']; ?></span>
																<span class="attachment-name"><?= $attachment['name']; ?></span>
															</a>
														<?php endif; ?>
													</td>
													<td class="text-center"><?= $attachment['revisions']; ?></td>
													<td class="text-center">
														<?php if (empty($project['recipient_id']) || $project['recipient_id'] == $user['id'] && $project['status'] != 'Completed'): ?>
															<?php if (empty($attachment['filename']) && in_array('Upload Attachment', $user['privileges'])): ?>
																<?php $set_a_complete = FALSE; ?>
																<a class="upload-attachment text-primary" href="#"><span class="glyphicon glyphicon-upload"></span> Upload</a>
															<?php elseif ( ! empty($attachment['filename']) && in_array('Delete Attachment', $user['privileges'])): ?>
																<a class="replace-attachment text-primary" href="#"><span class="glyphicon glyphicon-upload"></span> Replace</a>
															<?php endif; ?>
														<?php endif; ?>
													</td>
												</tr>
											<?php endif; ?>
										<?php endforeach; ?>
									</table>
								</div>
							</div>

							<?php $set_c_complete = TRUE; ?>
							<div class="row small">
								<div class="col-lg-12">
									<strong>2. Public Bidding</strong>
								</div>
							</div>
							<div class="row small">
								<div class="col-lg-12">
									<table class="table table-bordered table-striped table-hover">
										<tr>
											<th class="text-center col-lg-2">Date</th>
											<th class="text-center col-lg-7">Title</th>
											<th class="text-center col-lg-1">Revisions</th>
											<th class="text-center col-lg-2"></th>
										</tr>
										<?php foreach ($attachments AS $attachment): ?>
											<?php if ($attachment['category'] == 'Public Bidding'): ?>
												<tr>
													<td class="text-center"><?= empty($attachment['date_uploaded']) ? 'N/A' : date('F d, Y h:i:s A', strtotime($attachment['date_uploaded'])); ?></td>
													<td>
														<?php if (empty($attachment['filename'])): ?>
															<span class="hidden attachment-id"><?= $attachment['attachment_id']; ?></span>
															<span class="attachment-name"><?= $attachment['name']; ?></span>
														<?php else: ?>
															<a class="view-attachment text-primary" href="#">
																<span class="hidden attachment-id"><?= $attachment['attachment_id']; ?></span>
																<span class="attachment-name"><?= $attachment['name']; ?></span>
															</a>
														<?php endif; ?>
													</td>
													<td class="text-center"><?= $attachment['revisions']; ?></td>
													<td class="text-center">
														<?php if (empty($project['recipient_id']) || $project['recipient_id'] == $user['id'] && $project['status'] != 'Completed'): ?>
															<?php if (empty($attachment['filename']) && $set_a_complete && in_array('Upload Attachment', $user['privileges'])): ?>
																<?php $set_c_complete = FALSE; ?>
																<a class="upload-attachment text-primary" href="#"><span class="glyphicon glyphicon-upload"></span> Upload</a>
															<?php elseif ( ! empty($attachment['filename']) && in_array('Delete Attachment', $user['privileges'])): ?>
																<a class="replace-attachment text-primary" href="#"><span class="glyphicon glyphicon-upload"></span> Replace</a>
															<?php endif; ?>
														<?php endif; ?>
													</td>
												</tr>
											<?php endif; ?>
										<?php endforeach; ?>
									</table>
								</div>
							</div>
						</div> <!-- End Attachments -->
					</div>

					<br><br>

					<div class="row">
						<div class="col-lg-10 col-lg-offset-1">
							<div class="row">
								<div class="col-lg-12">
									<?php if ($project['status'] == 'Approved' && empty($project['start_date']) && $set_a_complete && $set_c_complete && in_array('Start Project', $user['privileges']) && (empty($project['recipient_id']) || ($project['recipient_id'] == $user['id']) && $project['transition_status'] == 'Received')): ?>
										<div id="project-start-error"></div>
										<form id="project-start" class="form-horizontal">
											<div class="form-group form-group-sm">
												<label class="col-lg-3 control-label">Completion Date : </label>
												<div class="col-lg-5">
													<input class="form-control text-center" type="date" name="completion_date" value="<?= date('Y-m-d'); ?>" min="<?= date('Y-m-d'); ?>">
												</div>
												<div class="col-lg-4">
													<input class="btn btn-primary btn-block btn-sm" type="submit" value="Start Project">
												</div>
										</form>
									<?php elseif ($project['status'] == 'Ongoing Construction' || $project['status'] == 'Completed'): ?>
										<!--										<div class="row small">-->
										<!--											<div class="col-lg-12 text-right">-->
										<!--												--><?php //if (empty($project['recipient_id']) || $project['recipient_id'] == $user['id']): ?>
										<!--													--><?php //if ($project['status'] == 'Ongoing Construction'): ?>
										<!--														--><?php //if (in_array('Edit Project Progress', $user['privileges'])): ?>
										<!--															<a id="project-progress" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-pencil small"></span> <small>Set Project Progress</small></a>-->
										<!--														--><?php //endif; ?>
										<!--														--><?php //if (in_array('Extend Project', $user['privileges'])): ?>
										<!--															<a id="project-extend" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus small"></span> <small>Extend Project</small></a>-->
										<!--														--><?php //endif; ?>
										<!--														--><?php //if (in_array('Complete Project', $user['privileges']) && $overall_progress == 100): ?>
										<!--															<a id="project-complete" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok small"></span> <small>Complete Project</small></a>-->
										<!--														--><?php //endif; ?>
										<!--													--><?php //endif; ?>
										<!--												--><?php //endif; ?>
										<!--											</div>-->
										<!--										</div>-->
										<div class="row small">
											<div class="col-lg-3">
												<h6 class="row text-primary">
													<div class="col-lg-3">
														<strong>REPORTS</strong>
													</div>
												</h6>
											</div>
											<div class="col-lg-9 text-right">
												<?php if (empty($project['recipient_id']) || $project['recipient_id'] == $user['id']): ?>
													<?php if (in_array('Upload Report', $user['privileges']) && $project['status'] == 'Ongoing Construction'): ?>
														<a id="report-upload" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-upload small"></span> <small>Upload Report</small></a>
													<?php endif; ?>
													<?php if (in_array('Extend Project', $user['privileges'])): ?>
														<a id="project-extend" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-plus small"></span> <small>Extend Project</small></a>
													<?php endif; ?>
													<?php if (in_array('Complete Project', $user['privileges']) && $overall_progress == 100): ?>
														<a id="project-complete" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok small"></span> <small>Complete Project</small></a>
													<?php endif; ?>
												<?php endif; ?>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-lg-12">
												<table class="table table-bordered table-striped table-focus small">
													<tr>
														<th class="text-center col-lg-2">Date</th>
														<th class="text-center col-lg-5">Title</th>
														<th class="text-center col-lg-1">PA Progress</th>
														<th class="text-center col-lg-1">FR Progress</th>
														<th class="text-center col-lg-1">Revisions</th>
														<th class="text-center col-lg-2"></th>
													</tr>
													<?php if (empty($reports)): ?>
														<tr>
															<td colspan="4" class="text-center text-danger">No reports found.</td>
														</tr>
													<?php else: ?>
														<?php foreach ($reports AS $report): ?>
															<tr>
																<td class="text-center"><?= date('F d, Y h:i:s A', strtotime($report['date_uploaded'])); ?></td>
																<td>
																	<a class="report-view text-primary" href="#">
																		<span class="hidden report-id"><?= $report['id']; ?></span>
																		<span class="report-name"><?= $report['title']; ?></span>
																	</a>
																</td>
																<td class="text-center"><?= $report['pa_progress'].'%'; ?></td>
																<td class="text-center"><?= $report['fr_progress'].'%'; ?></td>
																<td class="text-center"><?= $report['revisions']; ?></td>
																<td class="text-center">
																	<?php if (in_array('Delete Report', $user['privileges']) && (empty($project['recipient_id']) || $project['recipient_id'] == $user['id']) && $project['status'] == 'Ongoing Construction'): ?>
																		<a class="report-replace text-primary" href="#"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
																	<?php endif; ?>
																</td>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>
												</table>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div> <!-- End Reports -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
