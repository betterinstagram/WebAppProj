<?php
	include('../templates/conn.php');
	if(!isset($_SESSION['login'])){
		header('Location: ' . $base_url);
	}
	$_SESSION['login'] = false;
	session_destroy();
	header('Location: ' . $base_url);
?>