<?php include('../templates/header.php'); ?>
<?php if(isset($_SESSION['id'])) header('Location: ' . $base_url); ?>
<br>
<div class="container">
    <div class="row align-items-center">
        <div class="col-sm-4 offset-sm-4">
            <div class="card" style="width: 23rem;">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-sm-10">
                            <center><img class="card-img-top" src="<?= $base_url ?>images/instagram.png" alt="Card image cap" style="width: 12rem;"></center>
                            <center><p style="color: gray">Sign up to see photos and videos from your friends</p></center>
                            <br>
                            <?php
                                if(isset($_SESSION['invalid'])){
                                    echo '
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error!</strong> That ';
                                    if($_SESSION['invalid'] == 'both'){
                                        echo 'email and username are ';
                                    }elseif($_SESSION['invalid'] == 'email'){
                                        echo 'email is ';
                                    }else{
                                        echo 'username is ';
                                    }
                                    echo 'already taken.</div>';
                                    echo '<br/>';
                                }
                            ?>
                            <form action="<?= $base_url ?>action/signup.php" method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" name="email" style="background-color: #f7f7f7;">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Full Name" name="fullname" style="background-color: #f7f7f7;">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Username" name="username" style="background-color: #f7f7f7;">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" name="password" style="background-color: #f7f7f7;">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="form-control btn btn-small btn-primary" name="submit" value="Sign up">
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-sm-10 offset-sm-1">
                                    <center><p style="color: gray;"><small>By signing up, you agree to our Terms, Data Policy, and Cookies Policy</small></p></center>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="row justify-content-center">
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-5"><hr></div>
                                <div class="col-sm-2"><center><small style="color: grey;"><strong>OR</strong></small></center></div>
                                <div class="col-sm-5"><hr></div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col">
                                    <center><p style="color: darkblue;">Log in with Facebook</p></center>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col">
                                    <center><a href="" style="color: darkblue;"><small>Forgot password?</small></a></center>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <div class="card" style="width: 23rem;">
                <div class="card-body">
                    <center><p>Have an account? <a href="<?= $base_url ?>">Log in</a></p></center>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function(){
        <?php if(isset($_SESSION['invalid'])): unset($_SESSION['invalid']); ?>
            
            setTimeout(() => {
                $('.alert').fadeOut();
                $('.alert').hide();
            }, 3000);
        <?php endif;
        ?>
    };
</script>
<?php include('../templates/foot.php'); ?>
<?php include('../templates/footer.php'); ?>