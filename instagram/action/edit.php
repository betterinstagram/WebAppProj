<?php
	include('../templates/conn.php');
	if(!isset($_POST['submit'])){
		header('Location: ' . $base_url);
		die();
	}
	$id = $_POST['id'];
	$fullname = $_POST['fullname'];
	$bio = $_POST['bio'];
	$email = $_POST['email'];
	$stmt = '';
	$stmt = $conn->prepare('select count(user_id) from users where user_email = ?');
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	if($count == 1){
		$stmt = $conn->prepare('update users set user_name = ?, user_bio = ?, user_email = ? where user_id = ?');
		$stmt->bind_param('sssi', $fullname, $bio, $email, $_POST['id']);
		$stmt->execute();
		$_SESSION['update'] = true;
		header('Location: ' . $base_url . 'account/edit_profile?id=' . $_POST['id']);
	}else{
		$_SESSION['update'] = false;
		header('Location: ' . $base_url . 'account/edit_profile?id=' . $_POST['id']);
	}
?>