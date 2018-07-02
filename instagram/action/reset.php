<?php
	include('../templates/conn.php');
	if(!isset($_POST['submit'])){
		header('Location: ' . $base_url);
		die();
	}
	$email = $_POST['email'];
	$stmt = '';
	$stmt = $conn->prepare('select count(user_id) from users where user_email = ?');
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	if($count > 0){
		header('Location: ' . $base_url . 'reset/reset_password?email=' . $email);
		die();
	}else{
		header('Location: ' . $base_url . 'reset');
		die();
	}
?>