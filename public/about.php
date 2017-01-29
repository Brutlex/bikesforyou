<?php

require_once 'class.user.php';

$user_login = new USER();

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


<!DOCTYPE html>
<html lang="en">

<head>

    <?php require_once 'tags/header.php'; ?>

    <title>About</title>

</head>

<body id="contact">
    <?php include_once("analyticstracking.php") ?>
    <div>
        <?php require_once 'tags/navbar.php'; ?>
    </div>
    <div id="email" class="container-fluid text-center">
        <h1>Fragen & Support</h1>
        <p>Wenn Sie Fragen haben oder unsere Hilfe brauchen, schreiben Sie uns eine Email an:</p>
        <a href="mailto:support@bikesforyou.at">support@bikesforyou.at</a>
    </div>
</body>

</html>

