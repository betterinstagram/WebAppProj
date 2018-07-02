<?php
	$base_url = 'http://localhost/instagram/';
    session_start();

    $default_userpassword = md5('laboratory');

    $serverName = 'localhost';
	$phpmyadmin_username = 'root';
	$phpmyadmin_password = '';
	$db_name = '';
    $conn = new mysqli($serverName, $phpmyadmin_username, $phpmyadmin_password, $db_name);
    $db_name = 'instagram';
    $query = 'create database if not exists ' . $db_name;
    $conn->select_db($db_name);
    $conn->query($query);
    $query = 'create table if not exists admin(
        admin_id int auto_increment,
        admin_username varchar(255),
        admin_password varchar(255),
        primary key (admin_id)
    )';
    $conn->query($query);
    $query = 'create table if not exists log(
        log_id int auto_increment,
        user_id int,
        admin_id int,
		log_action text,
        primary key (log_id)
    )';
    $conn->query($query);
    $query = 'create table if not exists posts(
        post_id int auto_increment,
        post_imagePath text,
        post_caption text,
        user_id int,
        post_date datetime,
        post_public varchar(255),
        primary key (post_id)
    )';
    $conn->query($query);
    $query = 'create table if not exists comments(
        comment_id int auto_increment,
        comment_content text,
        post_id int,
        user_id int,
        primary key (comment_id)
    )';
    $conn->query($query);
    $query = 'create table if not exists users(
        user_id int auto_increment,
        user_username varchar(255),
        user_name varchar(255),
        user_website varchar(255),
        user_bio text,
        user_email varchar(255),
        user_gender varchar(255),
        user_password varchar(255),
        user_imagePath text,
        user_public varchar(1),
        primary key (user_id)
    )';
    $conn->query($query);
    $query = 'select count(admin_username) as count from admin where admin_username = "12007"';
    $result = $conn->query($query);
    $row = $result->fetch_object();
    if($row->count < 1){
        $stmt = $conn->prepare('insert into admin(admin_username, admin_password) values (?, ?)');
        $stmt->bind_param('ss', $admin_username, $admin_password);
        $admin_username = '12007';
        $admin_password = md5('root');
        $stmt->execute();
        $stmt->close();

        $stmt = $conn->prepare('insert into users(user_username, user_name, user_email, user_gender, user_password, user_public) values(?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssss', $username, $name, $email, $gender, $password, $public);
        $username = 'charliebautistaa';
        $name = 'Charlie Bautista';
        $email = 'csbautista@fit.edu.ph';
        $gender = 'Not Specified';
        $password = md5('password');
        $public = 'public';
        $stmt->execute();
        $stmt->close();
        
    }
    $uri = $_SERVER['REQUEST_URI'];
    //echo $uri; // Outputs: URI
    
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $uriSegments = explode('/', $url);
    /*
    echo $url; // Outputs: Full URL
    echo '<br/>';
    echo json_encode($uriSegments);
    /*
    foreach($uriSegments as $r){
        echo $r;
    }
    echo '<br/>';
    $last = end($uriSegments);
    echo $last;
    //$last = '';
    */
    $last = $uriSegments[count($uriSegments)-2];
?>
