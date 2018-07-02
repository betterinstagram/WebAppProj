<?php
    if(!isset($_POST['submit'])){
        header('Location: ../');
    }
    include('../templates/conn.php');
    $email = htmlspecialchars($_POST['email']);
    $name = htmlspecialchars($_POST['fullname']);
    $username = htmlspecialchars($_POST['username']);
    $password = md5(htmlspecialchars($_POST['password']));
    $gender = 'Not Specified';
    $public = '1';
    $bool = false;
    $stmt = $conn->prepare('select count(user_id) from users where user_email = ? and user_username = ?');
    $stmt->bind_param('ss', $email, $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    if($count > 0){
        $_SESSION['invalid'] = 'both';
        $bool = true;
        header('Location: ' . $base_url . 'signup');
    }
    $stmt->close();
    $stmt = $conn->prepare('select count(user_id) from users where user_email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    if($count > 0){
        $_SESSION['invalid'] = 'email';
        $bool = true;
        header('Location: ' . $base_url . 'signup');
    }
    $stmt->close();
    $stmt = $conn->prepare('select count(user_id) from users where user_username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    if($count > 0){
        $_SESSION['invalid'] = 'username';
        $bool = true;
        header('Location: ' . $base_url . 'signup');
    }
    $stmt->close();
    if(!$bool){
        $stmt = $conn->prepare('insert into users(user_username, user_name, user_email, user_gender, user_password, user_public) values(?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssss', $username, $name, $email, $gender, $password, $public);
        $stmt->execute();
        header('Location: ' . $base_url);
    }
?>