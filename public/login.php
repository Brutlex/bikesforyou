<?php
session_start();
require_once 'class.user.php';

//initialize objects

$user_login = new USER();

//check if already logged in

if($user_login->is_logged_in()!="")
{
    $user_login->redirect('/');
}

//support for login button in navbar, allows user to login with data entered

if(isset($_POST['btn-login']))
{
    $uemail = trim($_POST['uemail']);
    $upass = trim($_POST['upass']);

    if($user_login->login($uemail,$upass))
    {
        if ($_GET['ref'] == "post"){
            $user_login->redirect('post');
        }
        else {
            $user_login->redirect('/');
        }
    }
    else{
        $user_login->redirect('login?ref=incorrect');
    }
}

//set different messages for user based on the page they came from ("ref" value passed by get method)

if(!isset($_GET['ref'])){
    $msg = "<div class='alert alert-info'>
                    <button class='close' data-dismiss='alert'>&times;</button>
                    Please enter Your email and password!
                </div>";
}
else{
    switch($_GET['ref']){
        case "post":
            $msg = "<div class='alert alert-danger'>
                          <button class='close' data-dismiss='alert'>&times;</button>
                          Please Log in or <strong><a href=\"register\" class=\"alert-link\"> Sign up</a></strong> to continue!
                    </div>";
            break;
        case "incorrect":
            $msg = "<div class='alert alert-danger'>
                          <button class='close' data-dismiss='alert'>&times;</button>
                          <strong>Incorrect</strong> email or password!
                    </div>";
            break;
        default:
            $msg = "<div class='alert alert-info'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        Please enter Your email and password!
                    </div>";
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

<div class="container cont-msg">

<?php

    //print the message previously set

    echo $msg;
?>
<div class="panel panel-default">
    <div class="panel-body" >
        <div class="padding">
            <form class="form-horizontal"  method="post" accept-charset="UTF-8">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="email">Email:</label>
                            <div class="col-sm-9">
                                <input id="uname" class="form-control login" type="text" name="uemail" placeholder="Username" />
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-sm-3" for="pass">Password:</label>
                        <div class="col-sm-9">
                            <input id="pass" class="form-control login" type="password" name="upass" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group">
                            <input class="btn btn-md btn-primary btn-block" type="submit" name="btn-login" id="log-submit" value="Log in" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

</body>
</html>