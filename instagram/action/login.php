<?php
    if(!isset($_POST['submit'])){
        header('Location: ../');
    }
    include('../templates/conn.php');
    $username = htmlspecialchars($_POST['username']);
    $email = $username;
    $password = md5(htmlspecialchars($_POST['password']));
    $stmt = $conn->prepare('select count(user_id) from users where (user_username = ? or user_email = ? ) and user_password = ?');
    $stmt->bind_param('sss', $username, $email, $password);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    if($count > 0){
        $_SESSION['login'] = true;
        $stmt->close();
        $stmt = $conn->prepare('select user_id from users where user_username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        $_SESSION['id'] = $id;
        header('Location: ' . $base_url);
        die();
    }else{
        $_SESSION['invalid'] = true;
        header('Location: ' . $base_url);
    }
?>