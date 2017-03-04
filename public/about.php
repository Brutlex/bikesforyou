<?php
session_start();
require_once 'class.user.php'
;
$user_home = new USER();
$user_login = new USER();

if(isset($_POST['btn-login']))
{
    $uemail = trim($_POST['uemail']);
    $upass = trim($_POST['upass']);

    if($user_login->login($uemail,$upass)) {
        $user_login->redirect('home');
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

    <title>About</title>

</head>

<body id="contact">
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
    <div class="padding">
    <div id="email" class="container text-center">
        <div class="panel panel-default">
            <div class="panel-body" >
                <h1>Fragen & Support</h1>
                <p>Wenn Sie Fragen haben oder unsere Hilfe brauchen, schreiben Sie uns eine Email an:</p>
                <a href="mailto:support@bikesforyou.at">support@bikesforyou.at</a>
            </div>
        </div>
    </div>
    </div>
</body>

</html>

