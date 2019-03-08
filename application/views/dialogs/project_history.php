<table class="table table-bordered table-striped table-hover small">
	<tr>
		<th class="text-center col-lg-2">Date</th>
		<th class="text-center col-lg-3">Sender</th>
		<th class="text-center col-lg-3">Recipient</th>
		<th class="text-center col-lg-2">Remarks</th>
		<th class="text-center col-lg-2">Status</th>
	</tr>
	<?php if (empty($history)): ?>
		<tr>
			<td colspan="5" class="text-center text-danger">No records found.</td>
		</tr>
	<?php else: ?>
		<?php foreach ($history AS $transition): ?>
			<tr>
				<td class="text-center"><?= date('F d, Y<\b\r>h:i:s A', strtotime($transition['date_recorded'])); ?></td>
				<td>
					<strong><?= $transition['sender_last_name'].', '.$transition['sender_given_name'].' '.$transition['sender_middle_name'].' '.$transition['sender_name_suffix']; ?></strong>
					<br>
					<i><?= $transition['sender_position']; ?></i>
				</td>
				<td>
					<strong><?= $transition['recipient_last_name'].', '.$transition['recipient_given_name'].' '.$transition['recipient_middle_name'].' '.$transition['recipient_name_suffix']; ?></strong>
					<br>
					<i>	<?= $transition['recipient_position']; ?></i>
				</td>
				<td><?= $transition['remarks']; ?></td>
				<td class="text-center"><?= $transition['status']; ?></td>
			</tr>
		<?php endforeach; ?>
	<?php endif; ?>
</table>