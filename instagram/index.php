<?php include('templates/header.php'); ?>
<?php if(!isset($_SESSION['login'])): ?>
    <br>
    <section>
        <div class="container">
            <div class="row align-items-center">
                <div class="col">
                    <img src="<?= $base_url ?>images/iphone.png" alt="" class="img-fluid">
                </div>
                <div class="col">
                    <div class="row">
                        <div class="card" style="width: 23rem;">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-sm-10">
                                        <center><img class="card-img-top" src="<?= $base_url ?>images/instagram.png" alt="Card image cap" style="width: 12rem;"></center>
                                        <br>
                                        <form action="<?= $base_url ?>action/login.php" method="post">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Username or email" name="username" style="background-color: #f7f7f7;">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" placeholder="Password" name="password" style="background-color: #f7f7f7;">
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="form-control btn btn-small btn-primary" name="submit" value="Log in">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-10">
                                        <hr>
                                        <!--
                                        <div class="row justify-content-center">
                                            <div class="col">
                                                <center><p style="color: darkblue;">Log in with Facebook</p></center>
                                            </div>
                                        </div>
                                        -->
                                        <?php
                                            if(isset($_SESSION['invalid'])){
                                                echo '<center><i id="i" style="color: red">Invalid username or password.</i></center>';
                                                echo '<br/>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="card" style="width: 23rem;">
                            <div class="card-body">
                                <center><p>Don't have an account? <a href="<?= $base_url ?>signup">Sign up</a></p></center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        <?php if($_SESSION['invalid']): unset($_SESSION['invalid']); ?>
            window.onload = function(){
                    setTimeout(() => {
                        $('#i').fadeOut();
                        $('#i').hide();
                    }, 3000);
            };
        <?php endif; ?>
    </script>
<?php include('templates/foot.php'); ?>
<?php else: ?>
    <?php
        $stmt = $conn->prepare('select user_username, user_name from users where user_id = ?');
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->execute();
        $stmt->bind_result($username, $fullname);
        $stmt->fetch();
    ?>
    <br>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <!-- posts -->
                    <div class="card">
                        <div class="card-header" style="background-color: white;">
                            <a href="<?= $base_url ?>account?id=<?= $_SESSION['id'] ?>" style="color: black;">
                            <img src="<?= $base_url ?>images/default.png" alt="" class="img-fluid" style="border-radius: 50%; width: 2rem;"> <strong style="color: black;"><?= htmlspecialchars($username) ?></strong> Post something <?php if(isset($_SESSION['invalid'])){
                                echo '<p style="color: red">Error in uploading image. I think your file is not a photo. Try uploading another file with another name.</p>';
                                unset($_SESSION['invalid']);
                            } ?></a>
                        </div>
                        <form action="<?= $base_url ?>action/post.php" id="post"  enctype="multipart/form-data" name="post" method="post"></form>
                        <div class="card-body">
                            <h5 class="card-title">Select a photo</h5>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" form="post" class="custom-file-input" id="validatedCustomFile" name="fileToUpload" required>
                                    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                </div>
                            </div>
                            <p class="card-text"><small>Add a caption below</small></p>
                            <div class="form-group">
                                <textarea name="postCaption" id="" form="post" cols="30" rows="2" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="card-footer text-muted text-center" style="background-color: white;">
                            <input name="submit" form="post" class="btn btn-primary" type="submit" value="Post it.">
                        </div>
                    </div>
                    <?php
                        $stmt->close();
                        $stmt = $conn->prepare('select post_imagePath, post_caption, user_id, post_date from posts where post_public = "public" order by post_date desc');
                        $stmt->execute();
                        $result = $stmt->get_result();
                        //$stmt->bind_result($result['userid'], $result['path'], $result['caption'], $result['date']);
                        $i = 0;
                        while($obj = $result->fetch_assoc()):
                            $user_id[] = $obj['user_id'];
                            $path[] = $obj['post_imagePath'];
                            $caption[] = $obj['post_caption'];
                            $date[] = $obj['post_date'];
                        ?>
                        <br/><br/>
                        <div class="card">
                            <div class="card-header" style="background-color: white;">
                                <a href="<?= $base_url ?>account?id=<?= $user_id[$i] ?>"><img src="<?= $base_url ?>images/default.png" alt="" class="img-fluid" style="border-radius: 50%; width: 2rem;">
                                <?php
                                    $std = $conn->prepare('select user_username from users where user_id = ?');
                                    if($std === false){
                                        echo $conn->error;
                                    }else{
                                        $std->bind_param('i', $user_id[$i]);
                                        $std->execute();
                                        $std->bind_result($dem);
                                        $std->fetch();
                                    }
                                ?>
                                <strong style="color: black;"><?= htmlspecialchars($dem) ?></strong></a>
                            </div>
                            <form action="<?= $base_url ?>action/post.php" id="post"  enctype="multipart/form-data" name="post" method="post"></form>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-10 offset-sm-1 text-center">
                                        <img src="<?= $base_url . substr($path[$i], 3) ?>" alt="wut.png" class="img-fluid" style="width: cover;">
                                    </div>
                                </div>
                                <br>
                                <!-- comments -->
                                <?php if($caption[$i] !== ''): ?>
                                <p class="card-text"><small><strong><?= htmlspecialchars($dem) ?></strong> <?= htmlspecialchars($caption[$i]) ?></small></p>
                                <?php endif; ?>
                                <p class="card-text"><small><?= htmlspecialchars($date[$i]); ?></small></p>
                            </div>
                            <!--
                            <div class="card-footer text-muted" style="background-color: white;">
                                <input name="submit" form="post" class="btn btn-primary" type="submit">
                            </div>
                            -->
                        </div>
                        <?php $i++; endwhile;
                    ?>
                </div>
                <div class="col-sm-4">
                    <div style="position: sticky; top: 0; padding: 65px;">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="<?= $base_url ?>account?id=<?= $_SESSION['id'] ?>"><img src="<?= $base_url ?>images/default.png" alt="" class="img-fluid" style="border-radius: 50%; width: cover;"></a>
                            </div>
                            <div class="col-sm-8">
                                <a href="<?= $base_url ?>account?id=<?= $_SESSION['id'] ?>"><strong style="color: black;"><?= htmlspecialchars($username) ?></strong></a>
                                <br>
                                <small style="color: gray"><?= htmlspecialchars($fullname) ?></small>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <small style="color: lightgray">@2018 INSTAGRAM</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br class="my-4">
    <br class="my-4">
<?php endif; ?>
<?php include('templates/footer.php'); ?>