<?php
session_start();
require_once 'class.user.php';
require_once 'config.php';

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

    <title>Search</title>

</head>

<body id="search">
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

<?php

$con = $this->conn;

$category = $_GET['cat'];
$price_from = $_GET['price_from'];
$price_to = $_GET['price_to'];
$colour = $_GET['clr'];
$material = $_GET['mat'];

if (!isset($_GET['brand'])) {
    $brand = ""%"";
}
else{
    $brand = trim($_GET['brand']);
}

$abfrage = "SELECT * FROM articles WHERE category LIKE '$category' AND colour LIKE '$colour' AND material LIKE '$material' AND price BETWEEN '$price_from' AND '$price_to'";

$stmt = $reg_user->runQuery($abfrage);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { //wenn ich 10 einträge habe geht die schleife 10mal

    $id = $row['articleId'];

    echo $id;
}


?>
</body>
</html>