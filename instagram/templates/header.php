<?php include('conn.php'); ?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <link rel="shortcut icon" type="image/png" href="<?= $base_url ?>images/logo.png" />
        <link rel="stylesheet" href="<?= $base_url ?>style/main.css">
        <title>
        <?php
            if($last == 'signup') echo 'Sign up • ';
            elseif($last === 'reset') echo 'Reset Password • ';
            elseif($last === 'edit_profile') echo 'Edit Profile • ';
            elseif($last === 'account'){
                $stmt = $conn->prepare('select user_name, user_username from users where user_id = ?');
                $d = '';
                if(isset($_GET['id'])){
                    $d = $_GET['id'];
                }else{
                    $d = $_SESSION['id'];
                }
                $stmt->bind_param('i', $d);
                $stmt->execute();
                $stmt->bind_result($user, $username);
                $stmt->fetch();
                echo $user . ' (' . $username . ') • ';
            }
            echo 'Better Instagram';
        ?>
        </title>
    </head>
    <body style="background-color: #f7f7f7;">
    <?php if(isset($_SESSION['login']) || $last === 'reset' || $last === 'change_password'): ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light container-fluid sticky-top" style="background-color: white; border: 1px solid lightgray;">
        <div class="container">
            <a class="navbar-brand" href="<?= $base_url ?>"><img src="<?= $base_url ?>images/logo_bw.png" alt="" class="img-fluid" style="width: 2rem;"><img src="<?= $base_url; ?>images/instagram.png" alt="" class="img-fluid" style="width: 5rem;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <!--
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                </ul>
                -->
                <ul class="navbar-nav ml-auto">
                    <?php if(!isset($_SESSION['login'])): ?>
                        <a href="<?= $base_url ?>" class="btn btn-small btn-primary">Log In</a>
                        <a href="<?= $base_url ?>signup" class="btn btn-small">Sign Up</a>
                    <?php else: ?>
                        <a href="<?= $base_url ?>account?id=<?= $_SESSION['id'] ?>" class="fas fa-user" style="color: black;"></a>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>