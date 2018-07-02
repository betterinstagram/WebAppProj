<?php
	include('../templates/conn.php');
	if(!isset($_POST['submit'])){
		header('Location: ' . $base_url);
		die();
	}
	$new = $_POST['new'];
	$confirm = $_POST['new1'];
	$stmt = '';
	$email = $_GET['email'];
	$stmt = $conn->prepare('select count(user_id) from users where user_email = ?');
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	if($count > 0 && $new === $confirm){
		$stmt = $conn->prepare('update users set user_password = ? where user_email = ?');
		$stmt->bind_param('ss', md5($new), $email);
		$stmt->execute();
		$_SESSION['update'] = true;
		header('Location: ' . $base_url);
	}else{
		$_SESSION['update'] = false;
		header('Location: ' . $base_url);
	}
?>