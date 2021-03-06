<div class="row">
	<div class="col-sm-3">
		<a class="btn btn-primary btn-block btn-sm attachment" href="#">
			<span class="filepath hidden"><?= $attachment['filepath']; ?></span>
			<span class="filename hidden"><?= $attachment['filename']; ?></span>
			<span>Current File</span>
		</a>
		<br>
		<h5 class="text-primary">Previous Versions</h5>
		<?php $ctr = count($revisions); ?>
		<?php foreach ($revisions AS $revision): ?>
			<a class="btn btn-default btn-block btn-sm attachment" href="#">
				<span class="filepath hidden"><?= $revision['filepath']; ?></span>
				<span class="filename hidden"><?= $revision['filename']; ?></span>
				<span><?= $ctr == 1 ? 'Original File' : 'Revision '.$ctr; ?></span>
				<?php $ctr--; ?>
			</a>
		<?php endforeach; ?>
	</div>
	<div class="col-sm-9">
		<div class="row small">
			<div class="col-sm-6">
				<p><strong>Date : </strong><i><?= date('F d, Y h:i:s A', strtotime($attachment['date_uploaded'])); ?></i></p>
			</div>
			<div class="col-sm-6 text-right">
				<p><strong>By : </strong><i><?= ucwords($attachment['given_name'].' '.$attachment['middle_name'].' '.$attachment['last_name'].' '.$attachment['name_suffix']); ?></i></p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<embed src="<?= '/nia/'.$attachment['filepath'].$attachment['filename']; ?>" width="100%" height="480" type="application/pdf">
			</div>
		</div>
	</div>
</div>