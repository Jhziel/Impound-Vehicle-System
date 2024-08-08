<!DOCTYPE html>
<html lang="en">
<?php require_once('../config.php'); ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <?php require_once("inc/header.php") ?>

</head>
<style>
    body{
        background-color: black;
    }
    #signup {
        background: rgb(2, 0, 36);
        background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(6, 69, 161, 1) 0%, rgba(145, 145, 200, 1) 28%, rgba(0, 212, 255, 1) 100%);
    }
</style>

<body>
    <div class="container d-flex justify-content-center mt-3">
        <div class="card card-outline card-primary w-50 ">
            <div class="card-body ">
                <div class="container-fluid">
                    <div id="msg"></div>
                    <div class="h2 text-center mt-3 mb-3">Create Account</div>
                    <form action="" id="manage-user">
                        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
                        <input type="hidden" name="unique_id" value="">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="name">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname'] : '' ?>" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="name">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname'] : '' ?>" required>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username'] : '' ?>" required autocomplete="off">
                        </div>
                        <label for="password">Password</label>
                        <div class="input-group mb-2">
                            <input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" <?php echo isset($meta['id']) ? "" : 'required' ?>>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i id="icon" class="fas fa-eye"></i>
                                </span>
                            </div>
                            <?php if (isset($_GET['id'])) : ?>
                                <small><i>Leave this blank if you dont want to change the password.</i></small>
                            <?php endif; ?>
                        </div>
                        <div class="form-group ">
                            <label for="" class="control-label">Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group  d-flex justify-content-center">
                            <img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
                        </div>
                    </form>
                    <button class="btn btn-lg btn-block mt-4 text-light" id="signup" form="manage-user">SIGN UP</button>
                    <!--  <a class="btn btn-sm btn-secondary" href="./login.php">Cancel</a> -->
                    <div class="text-center mt-3">
                        <span>Already have an Account?</span><a class="ml-auto " href="./login.php"><u>Login here</u></a>
                    </div>
                </div>

            </div>
        </div>
        <?php require_once("inc/footer.php") ?>
</body>

</html>
<style>
    img#cimg {
        height: 15vh;
        width: 15vh;
        object-fit: cover;
        border-radius: 100% 100%;
    }
</style>

<script src="/../traffic_offense/assets/js/displayImg.js"></script>
<script src="/../traffic_offense/assets/js/passwordVisibility.js"></script>

<script>
    $('#manage-user').submit(function(e) {
        e.preventDefault();
        start_loader()
        $.ajax({
            url: _base_url_ + 'classes/Users.php?f=save_d',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    location.href = './login.php';
                } else {
                    $('#msg').html('<div class="alert alert-danger">Username already exist</div>')
                }
                end_loader()
            }
        })
    })
</script>