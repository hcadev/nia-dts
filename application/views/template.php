<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>NIA Document Tracking System</title>

	<!-- Bootstrap -->
	<link href="<?= URL::base().'assets/css/bootstrap.min.css'; ?>" rel="stylesheet">
	<link href="<?= URL::base().'assets/css/custom.css'; ?>" rel="stylesheet">
</head>
<body>
<?php if (isset($user)): ?>
	<header>
		<nav class="navbar navbar-default navbar-static-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?= URL::site('home'); ?>">NIA DTS</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="<?= preg_match('/Home/', $active_page) ? 'active' : ''; ?>"><a href="<?= URL::site('home'); ?>">Home</a></li>
					<li class="<?= preg_match('/Projects/', $active_page) ? 'active' : ''; ?>"><a href="<?= URL::site('project/list'); ?>">Projects</a></li>
					<?php if (in_array('Create Employee', $user['privileges'])): ?>
						<li class="<?= preg_match('/Employees/', $active_page) ? 'active' : ''; ?>"><a href="<?= URL::site('employee/list'); ?>">Employees</a></li>
					<?php endif; ?>
					<?php if (in_array('Generate Report', $user['privileges'])): ?>
						<li class="<?= preg_match('/Reports/', $active_page) ? 'active' : ''; ?>"><a href="<?= URL::site('report'); ?>">Reports</a></li>
					<?php endif; ?>
					<?php if ($user['position'] == 'System Administrator'): ?>
						<li class="<?= preg_match('/Audit Trail/', $active_page) ? 'active' : ''; ?>"><a href="<?= URL::site('audit/activities'); ?>">Audit Trail</a></li>
						<li class="<?= preg_match('/Backup/', $active_page) ? 'active' : ''; ?>"><a href="<?= URL::site('backup/list'); ?>">Backup & Restore</a></li>
					<?php endif; ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle  btn btn-xs" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-flag"></span></a><span class="badge badge-notify"><?= count($incoming) > 0 ? count($incoming) : ''; ?></span>
						<ul id="notification" class="dropdown-menu">
							<?php if (empty($incoming)): ?>
								<li><a href="#">No incoming projects.</a></li>
							<?php else: ?>
								<?php foreach ($incoming AS $project): ?>
									<li><a href="<?= URL::site('project/view/'.$project['project_id']); ?>"><?= date('F d, Y h:i:s A', strtotime($project['date_recorded'])).' - '.$project['name']; ?></a></li>
								<?php endforeach; ?>
							<?php endif; ?>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $user['username']; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?= URL::site('help'); ?>">Help</a></li>
							<li><a href="<?= URL::site('employee/view/'.$user['id']); ?>">Account Settings</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?= URL::site('logout'); ?>">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>

	<main class="container-fluid">
		<?= $content; ?>
	</main>
<?php else: ?>
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="inner_wrap">
						<div class="content">
							<div class="logo text-center"><img src="<?= URL::base().'assets/img/logo-dark.png'; ?>" alt="Klorofil Logo"></div>
							<?php if (isset($login_error)): ?>
								<div class="alert alert-danger small"><?= $login_error; ?></div>
							<?php endif; ?>
							<form class="form-horizontal" method="POST">
								<div class="form-group form-group-sm">
									<input type="text" class="form-control text-center" name="username" placeholder="Username or Email">
								</div>
								<div class="form-group form-group-sm">
									<input type="password" class="form-control text-center" name="password" placeholder="Password">
								</div>
								<div class="form-group form-group-sm">
									<button type="submit" class="btn btn-primary btn-block btn-sm">LOGIN</button>
								</div>
								<div class="form-group form-group-sm">
									<div class="col-lg-12 text-center">
										<a href="#" class="text-primary"><span class="glyphicon glyphicon-lock"></span> Forgot Password?</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<div id="smallModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm form-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn btn-sm" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Close</span></button>
				<h4 class="modal-title text-primary text-center"></h4>
			</div>
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>

<div id="largeModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close btn btn-sm" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Close</span></button>
				<h4 class="modal-title text-primary text-center"></h4>
			</div>
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>

<script src="<?= URL::base().'assets/js/jquery-1.12.4.min.js'; ?>"></script>
<script src="<?= URL::base().'assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?= URL::base().'assets/js/jspdf.min.js'; ?>"></script>
<script src="<?= URL::base().'assets/js/html2canvas.js'; ?>"></script>
<script src="<?= URL::base().'assets/js/notification.js'; ?>"></script>

<?php if (isset($js)) foreach ($js AS $file) {echo HTML::script('assets/js/'.$file.'.js');} ?>
</body>
</html>