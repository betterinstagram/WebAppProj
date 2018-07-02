<?php
	include('../templates/conn.php');
	if(!isset($_POST['submit'])){
		header('Location: ' . $base_url);
		die();
	}
	$old = $_POST['old'];
	$new = $_POST['new'];
	$confirm = $_POST['new1'];
	$stmt = '';
	$stmt = $conn->prepare('select count(user_id) from users where user_id = ? and user_password = ?');
	$stmt->bind_param('is', $_POST['id'], md5($old));
	$stmt->execute();
	$stmt->bind_result($count);
	$stmt->fetch();
	$stmt->close();
	if($count > 0 && $new === $confirm){
		$stmt = $conn->prepare('update users set user_password = ? where user_id = ?');
		$stmt->bind_param('si', md5($new), $_POST['id']);
		$stmt->execute();
		$_SESSION['update'] = true;
		header('Location: ' . $base_url . 'account/change_password?id=' . $_POST['id']);
	}else{
		$_SESSION['update'] = false;
		header('Location: ' . $base_url . 'account/change_password?id=' . $_POST['id']);
	}
?>