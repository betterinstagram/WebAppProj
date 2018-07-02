<?php include('../templates/header.php'); ?>
<?php if(isset($_SESSION['id'])) header('Location: ' . $base_url); ?>
	<div class="container">
		<br><br><br>
		<div class="row align-items-center">
			<div class="col-sm-10 offset-sm-1 card justify-content-center" style="padding: 50px">
				<div class="row">
					<div class="col-sm-8 offset-sm-2">
						<h5 class="card-title">Reset Password</h5>
						<p class="card-text">We can help you reset your password using your Instagram username or the email address you linked to your account.</p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-sm-3 offset-sm-1">
						<label for=""><strong>Email or Username</strong></label>
					</div>
					<div class="col-sm-7">
						<form action="<?= $base_url ?>action/reset.php" method="post">
							<div class="form-group">
								<input type="email" class="form-control" name="email" required>
							</div>
							<div class="form-group">
								<input type="submit" class="btn btn-primary btn-small" name="submit">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include('../templates/foot.php'); ?>
<?php include('../templates/footer.php'); ?>