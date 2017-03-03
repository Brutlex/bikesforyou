<?php
session_start();
require_once 'class.user.php';
require_once 'class.article.php';

$user_home = new USER();
$user_login = new USER();
$articleObj = new ARTICLE();

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

if (!isset($_GET['searchbar'])){
    $article_name = "%";
}
else {
    $article_name = '%' . trim($_GET['searchbar']) . '%';
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
    $brand ='%' . trim($_GET['brand']) . '%';
}

$result = $articleObj->search($article_name,$category,$price_from,$price_to,$colour,$material,$brand);

if ($result == null){
    echo "No matches found!";
}
foreach($result as $row){


    $stmt = $articleObj->runQuery("SELECT * FROM users WHERE userId = :userId");
    $stmt->execute(array(":userId" => $row['userId']));
    $author = $stmt->fetch(PDO::FETCH_ASSOC);

    $author_name = $author['userName'];


    echo'<div class="container">';
    echo '<div class="col-lg-1"></div>
    <div class=" container-fluid col-lg-10">
        <ul>
            <li>
                <div class="container col-md-4" >
                    <img src="img/articlePics/' . $row['picture'] . ' " class="thumbnail img-responsive">
                </div>
                <div class="col-md-8">
                    <div class="col-sm-4">
                        <p>' . $row['articleName'] . '</p>
                        <br>
                        <p>' . $row['material'] . '</p>
                        <br>
                    </div>
                    <div class="col-sm-4">
                        <p>' . $row['category'] . '</p>
                        <br>
                        <p>' . $row['brand'] . '</p>
                    </div>
                    <div class="col-md-4">
                        <p>' . $row['price'] . '</p>
                        <br>
                        <p>' . $row['colour'] . '</p>
                        <br>
                        <p>posted by ' . $author_name . '</p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-lg-1"></div>';
    echo '</div>';
}

?>

