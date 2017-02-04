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

$dbhost = "bikesforyou.at.mysql";
$dbname="bikesforyou_at";
$dbuser="bikesforyou_at";
$dbpass="verynoobs";

$con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if($con->connect_error){
    die("geht nicht");
}

if (!isset($_GET['searchbar'])){
    $article_name = ""%"";
}
else {
    $article_name = '%' . $_GET['searchbar'] . '%';
}
$category = $_GET['cat'];
$price_from = $_GET['price_from'];
$price_to = $_GET['price_to'];
$colour = $_GET['clr'];
$material = $_GET['mat'];

if (!isset($_GET['brand'])) {
    $brand = "%";
}
else{
    $brand = trim($_GET['brand']);
}

$abfrage = "SELECT * FROM articles WHERE articleName LIKE '$article_name' AND category LIKE '$category' AND colour LIKE '$colour' AND material LIKE '$material' AND price BETWEEN '$price_from' AND '$price_to'";
$ergebnis = mysqli_query($con, $abfrage);

while ($fetch=mysqli_fetch_assoc($ergebnis)) {
    $articleId1= $fetch['$articleId'];
    $picture1= $fetch['picture'];
    $articleName1= $fetch['articleName'];
    $price1= $fetch['price'];
    $category1= $fetch['category'];
    $colour1= $fetch['colour'];
    $material1= $fetch['material'];
    $brand1= $fetch['brand'];
    $description1= $fetch['description'];
    $userId1= $fetch['userId'];


    $abfrage2 = "SELECT * FROM users WHERE userId = '$userid' ";
    $ergebnis2 = mysqli_query($con, $abfrage2);
    $fetch2 = mysqli_fetch_assoc($ergebnis2);

    $userName1= $fetch2['userName'];

    echo'<div class="container">';
    echo '<div class="col-lg-1"></div>
    <div class=" container-fluid col-lg-10">
        <ul>
            <li>
                <div class="container col-md-4" >
                    <img src="img/articlePics/' . $picture1 . ' " class="thumbnail img-responsive">
                </div>
                <div class="col-md-8">
                    <div class="col-sm-4">
                        <p>' . $articleName1 . '</p>
                        <br>
                        <p>' . $material1 . '</p>
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <p>' . $category1 . '</p>
                        <br>
                        <p>' . $brand1 . '</p>
                    </div>
                    <div class="col-md-4">
                        <p>' . $price1 . '</p>
                        <br>
                        <p>' . $colour1 . '</p>
                        <br>
                        <p>posted by ' . $userName1 . '</p>
    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-lg-1"></div>';
    echo '</div>';

}
/*


while($fetch = mysqli_fetch_assoc($ergebnis)) { //wenn ich 10 einträge habe geht die schleife 10mal

    $id = $fetch['articleId'];


    $bild = $fetch['picture'];

    $userid = $fetch['userId'];
    $abfrage2 = "SELECT * FROM User WHERE ID = '$userid' ";
    $ergebnis2 = mysqli_query($con, $abfrage2);
    $fetch2 = mysqli_fetch_assoc($ergebnis2);

    echo $id;
}
*/
/*
$stmt = $user_home->runQuery($abfrage);
$stmt->execute(array(
    ':article_name' => $article_name,
    ':category' => $category,
    ':colour' => $colour,
    ':material' => $material,
    ':price_from' => $price_from,
    ':price_to' => $price_to));
$row = $stmt->fetch(PDO::FETCH_ASSOC);


while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { //wenn ich 10 einträge habe geht die schleife 10mal

    $id = $row['articleId'];

    echo $id;
}

*/
?>

