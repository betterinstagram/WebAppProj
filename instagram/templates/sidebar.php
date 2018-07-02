
						<ul class="list-group list-group-flush">
							<li class="list-group-item <?php if($last === 'edit_profile') echo 'font-weight-bold'; ?>" style="<?php if($last === 'edit_profile') echo 'border-left: 0.5px solid black;'; ?>"><a href="<?= $base_url ?>account/edit_profile?id=<?= $_GET['id'] ?>" style="color: black">Edit Profile</a></li>
							<li class="list-group-item <?php if($last === 'change_password') echo 'font-weight-bold'; ?>" style="<?php if($last === 'change_password') echo 'border-left: 0.5px solid black;'; ?>"><a href="<?= $base_url ?>account/change_password?id=<?= $_GET['id'] ?>" style="color: black; ">Change Password</a></li>
							<li class="list-group-item"><a href="<?= $base_url ?>action/signout.php" style="color: black;">Sign Out</a></li>
						</ul>