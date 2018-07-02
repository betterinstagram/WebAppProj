<?php
	include('../templates/conn.php');
	
	if(!isset($_POST['submit'])){
		header('Location: ' . $base_url);
		echo isset($_POST['submit']);
		die();
	}
	
	$target_dir = '../images/';
	$now = date('Y-m-d H:i:s');
	$target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	if(isset($_POST['submit'])){
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. $imageFileType. ";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
		$_SESSION['invalid'] = true;
		header('Location: ' . $base_url);
		die();
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			$stmt = $conn->prepare('insert into posts(post_imagePath, post_caption, user_id, post_date, post_public) values(?, ?, ?, ?, "public")');
			$stmt->bind_param('ssis', $path, $caption, $user_id, $date);
			$path = $target_file;
			$caption = $_POST['postCaption'];
			$user_id = $_SESSION['id'];
			$date = $now;
			$stmt->execute();
			$stmt->close();
			header('Location: ' . $base_url);
			die();
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}
?>