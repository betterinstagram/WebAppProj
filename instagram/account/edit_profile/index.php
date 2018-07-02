<?php include('../../templates/header.php'); ?>
<?php
	if(!isset($_SESSION['id'])){
		header('Location: ' . $base_url);
		die();
	}
?>
<section>
	<br><br><br>
	<div class="container">
		<div class="row">
			<div class="col-sm-10 offset-sm-1 card" style="border: none;">
				<div class="row">
					<div class="col-sm-3" style="border: 1px solid lightgray">
						<?php include('../../templates/sidebar.php'); ?>
					</div>
					<div class="col-sm-9" style="border: 1px solid lightgray">
						<br>
						<div class="row">
							<div class="col-sm-3 offset-sm-2 text-right">
								<?php
									$stmt = '';
									$stmt = $conn->prepare('select user_username, user_name, user_bio, user_imagePath, user_email from users where user_id = ?');
									$stmt->bind_param('i', $_GET['id']);
									$stmt->execute();
									$stmt->bind_result($username, $fullname, $bio, $imagePath, $email);
									$stmt->fetch();
									$stmt->close();
								?>
								<img src="<?php if($imagePath == ''){ echo '../../images/default.png'; }else{
									echo '../../images/'.$imagePath;
								} ?>" alt="" class="img-fluid rounded-circle" style="width: 50px;">
							</div>
							<div class="col-sm-7">
								<p class="lead"><?= $username ?><br/></p>
							</div>
						</div>
						<br class="my-4">
						<?php if(isset($_SESSION['update'])): ?>
						<div class="row align-items-center">
							<div class="col-sm-10 offset-sm-1 text-center">
								<?php if($_SESSION['update']): ?>
									<i class="text-success">Successfully updated.</i>
								<?php else: ?>
									<i class="text-danger">Unsuccessful in updating your data. Try again.</i>
								<?php endif; ?>
							</div>
						</div>
						<br class="my-4">
						<?php unset($_SESSION['update']); endif; ?>
						<div class="row align-items-center">
							<div class="col-sm-3 offset-sm-2 text-right justify-content-center">
								<div class="form-group">
									<label for=""><strong>Name</strong></label>
								</div>
								<br>
								<div class="form-group">
									<label for=""><strong>Bio</strong></label>
								</div>
							</div>
							<div class="col-sm-7">
								<form action="<?= $base_url ?>action/edit.php" id="form1" method="post"></form>
								<div class="form-group">
									<input form="form1" type="text" class="form-control" name="fullname" value="<?= $fullname ?>">
								</div>
								<div class="form-group">
									<textarea form="form1" name="bio" id="" cols="30" rows="3" class="form-control"><?= $bio ?></textarea>
								</div>
							</div>
						</div>
						<br class="my-4">
						<div class="row align-items-center">
							<div class="col-sm-3 offset-sm-2 text-right">
								<div class="form-group">
									<label for=""><strong>Email</strong></label>
								</div>
							</div>
							<div class="col-sm-7">
								<div class="form-group">
									<input form="form1" type="email" class="form-control" name="email" value="<?= $email ?>">
									<input type="hidden" form="form1" name="id" value="<?= $_GET['id']; ?>">
								</div>
							</div>
						</div>
						<br class="my-4">
						<div class="row align-items-center">
							<div class="col-sm-3 offset-sm-2 text-right">
							</div>
							<div class="col-sm-7">
								<div class="form-group">
									<input form="form1" type="submit" class="btn btn-small btn-primary" name="submit" value="Submit">
								</div>
							</div>
						</div>
						<br class="my-4">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include('../../templates/footer.php'); ?>