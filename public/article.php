<?php

//not yet finished or directly included

session_start();
require_once 'class.user.php';


$user_home = new USER();
$user_login = new USER();

if(isset($_POST['btn-login']))
{
    $uemail = trim($_POST['uemail']);
    $upass = trim($_POST['upass']);

    if($user_login->login($uemail,$upass)) {
        $user_login->redirect('/');
    }
}
$stmt = $user_home->runQuery("SELECT * FROM users WHERE userId=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <?php require_once 'tags/header.php'; ?>

    <title><?php echo $row['articleName'] ?></title>

</head>

<body id="article">
    <?php include_once("analyticstracking.php") ?>
    <div>
        <?php
        if(!$user_home->is_logged_in()){
            require_once 'tags/navbar.php';
        }
        else{
            require_once 'tags/navmembers.php';
        }

        ?>
    </div>
    <div class="container-fluid " style="color: #3385ff;padding-bottom: 20px; padding-top: 10px; padding-left:10px; text-align: center">
        <h2><strong>#</strong></h2>
    </div>
    <div class="col-lg-5 col-md-5 hidden-sm hidden-xs">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div align="center">
                        <img class="thumbnail img-responsive" src="img/bikeTest.jpg">
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div align="center">
                        <div class="media-body">
                            <hr>
                            <h5><strong>Price</strong></h5>
                            <p>#</p>
                            <hr>
                            <h5><strong>Category</strong></h5>
                            <p>#</p>
                            <hr>
                            <h5><strong>Colour</strong></h5>
                            <p>#</p>
                            <hr>
                            <h5><strong>Material</strong></h5>
                            <p>#</p>
                            <hr>
                            <h5><strong>Seller</strong></h5>
                            <p>#</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>



</body>