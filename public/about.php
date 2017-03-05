<?php
session_start();
require_once 'class.user.php'
;

//initialize objects

$user_home = new USER();
$user_login = new USER();

//support for login button in navbar, allows user to login with data entered

if(isset($_POST['btn-login']))
{
    $uemail = trim($_POST['uemail']);
    $upass = trim($_POST['upass']);

    if($user_login->login($uemail,$upass)) {
        $user_login->redirect('/');
    }
}

//get data of the logged in user

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userId=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php require_once 'tags/header.php'; ?>

    <title>About</title>

</head>

<body id="contact">
    <?php include_once("analyticstracking.php") ?>
    <div>
        <?php

        //include different navbar if user is logged in or not

        if(!$user_home->is_logged_in()){
            require_once 'tags/navbar.php';
        }
        else{
            require_once 'tags/navmembers.php';
        }

        ?>
    </div>
    <div class="padding">
    <div id="email" class="container text-center">
        <div class="panel panel-default">
            <div class="panel-body" >
                <h1>Questions & Support</h1>
                <p>If You have questions or need our help, write an email to:</p>
                <a href="mailto:support@bikesforyou.at">support@bikesforyou.at</a>
            </div>
        </div>
    </div>
    </div>
</body>

</html>

