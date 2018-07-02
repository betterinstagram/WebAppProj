<?php include('../templates/header.php'); ?>
<?php if(!isset($_SESSION['id'])) header('Location: ' . $base_url); ?>
<br><br><br>
<style>
	a, a:hover, a:focus, a:active{
		text-decoration: none;
	}
</style>
<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <img src="" class="enlargeImageModalSource" style="width: 100%;">
        </div>
      </div>
    </div>
</div>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-2 offset-sm-2 text-center">
				<img src="<?= $base_url ?>images/default.png" alt="" class="img-fluid" style="border-radius: 50%; width: 100px;">
			</div>
			<div class="col-sm-6">
				<?php
					$stmt = '';
					$stmt = $conn->prepare('select user_username, user_name, user_bio, user_imagePath from users where user_id = ?');
					$stmt->bind_param('i', $_GET['id']);
					$stmt->execute();
					$stmt->bind_result($username, $fullname, $bio, $imagePath);
					$stmt->fetch();
					$stmt->close();
					$stmt = $conn->prepare('select count(post_id) from posts where user_id = ?');
					$stmt->bind_param('i', $_GET['id']);
					$stmt->execute();
					$stmt->bind_result($count);
					$stmt->fetch();
					$stmt->close();
				?>
				
				<p><?= $username ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--<button class="btn btn-small btn-outline-secondary">Edit Profile</button>-->&nbsp;&nbsp;<?php if($_GET['id'] == $_SESSION['id']): ?><a class="lead" href="<?= $base_url ?>account/edit_profile?id=<?= $_GET['id']; ?>"><span style="color: black;" class="fas fa-cog"></span></a><?php endif; ?><br/><small><b><?= $count ?></b> posts</small></p>
				
				<small><b><?= $fullname ?></b> <?= $bio; ?></small>
			</div>
		</div>
		<br><br><br>
		<div class="row">
			<div class="col text-center">
				<hr class="my-0">
				<div class="row">
					<div class="col-sm-2 offset-sm-5">
						<hr style="background-color: #222">
						<small><span class="fas fa-newspaper"></span> Posts</small>
					</div>
				</div>
			</div>
		</div>
		<br class="my-1"/>
		<div class="row text-center">
			<?php
				$stmt = $conn->prepare('select post_imagePath from posts where user_id = ? order by post_date desc');
				$stmt->bind_param('i', $_GET['id']);
				$stmt->execute();
				$result = $stmt->get_result();
				$stmt->close();
				$i = 0;
				while($obj = $result->fetch_assoc()){
					$path[] = $obj['post_imagePath'];
					if($i%3 == 0){
						echo '</div><br/><div class="row text-center">';
						echo '<div class="col-sm-3 offset-sm-1">';
					}else{
						echo '<div class="col-sm-3">';
					}
					echo '<img src="'.$base_url.substr($path[$i], 3).'" class="img-fluid">'; 
					echo '</div>';
					$i++;
				}
				
				for($i = 0; $i < $count; $i++){
					if($i%3 == 0){
						echo '</div><br/><div class="row text-center">';
						echo '<div class="col-sm-3 offset-sm-1">';
					}else{
						echo '<div class="col-sm-3">';
					}
				}
			?>
		</div>
		<br class="my-4">
		<br class="my-4">
	</div>
</section>
<script>
	window.onload = function(){
    	$('img').on('click', function() {
			$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
			$('#enlargeImageModal').modal('show');
		});
	};
</script>
<?php include('../templates/footer.php'); ?>