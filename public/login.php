<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
    $user_login->redirect('home');
}

if(isset($_POST['btn-login']))
{
    $uemail = trim($_POST['uemail']);
    $upass = trim($_POST['upass']);

    if($user_login->login($uemail,$upass))
    {
        $user_login->redirect('home');
    }
}
?>
<html>
<head>

    <?php require_once 'tags/header.php'; ?>

    <title>Log In</title>

</head>
<body id="login">
<?php include_once("analyticstracking.php") ?>
<div>
    <?php require_once 'tags/navbar.php'; ?>
</div>

<div class="container" style="margin-top:20px;">
    <div class='alert alert-danger'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Incorrect email/password!</strong>
    </div>

    <form class="form-horizontal"  method="post" accept-charset="UTF-8">
        <div class="form-group">
            <label class="col-form-label col-sm-2" for="email">Email:</label>
            <div class="col-sm-5">
                <input id="uname" class="form-control login" type="text" name="uemail" placeholder="Username" />
            </div>
        </div>
        <div class="form-group">
            <label class="col-form-label col-sm-2" for="pass">Password:</label>
            <div class="col-sm-5">
                <input id="pass" class="form-control login" type="password" name="upass" placeholder="Password"/>
            </div>
        </div>
        <input class="btn btn-lg btn-primary" type="submit" name="btn-login" value="Log in" />

    </form>
</div>

</body>
</html>