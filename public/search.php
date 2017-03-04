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


if($_GET['category'] == "any"){
    $category = "%";
}
else{
    $category = $_GET['category'];
}


$price_from = $_GET['price_from'];
$price_to = $_GET['price_to'];


if($_GET['colour'] == "any"){
    $colour = "%";
}
else{
    $colour = $_GET['colour'];
}


if($_GET['material'] == "any"){
    $material = "%";
}
else{
    $material = $_GET['material'];
}


if (!isset($_GET['brand'])) {
    $brand = "%";
}
else{
    $brand ='%' . trim($_GET['brand']) . '%';
}


$result = $articleObj->search($article_name,$category,$price_from,$price_to,$colour,$material,$brand);

echo '<div class="padding">';

if ($result == null){
    echo "<div class=\"jumbotron\" s>
            <h1 align='center'>No results found :(</h1>      
            <strong><a href=\"index\" class=\"alert-link\"><p align = 'center'>Try a different search</p></a></strong>
            </div>";
}


foreach($result as $row){


    $stmt = $articleObj->runQuery("SELECT * FROM users WHERE userId = :userId");
    $stmt->execute(array(":userId" => $row['userId']));
    $author = $stmt->fetch(PDO::FETCH_ASSOC);

    $author_name = $author['userName'];


    echo'<div class="container">';
    echo '<div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="panel panel-default">
        <div class="panel-body">
        <ul style="list-style: none">
            <li>
                <div class="container col-sm-4" >
                    <img src="img/articlePics/' . $row['picture'] . ' " class="thumbnail img-responsive">
                </div>
                <div class="col-sm-8">
                    <div class="col-sm-8">
                        <p>' . $row['articleName'] . '</p>
                        <br>
                        <br>
                        <br>
                        <p>posted by ' . $author_name . '</p>
                    </div>
                    <div class="col-sm-4">
                        <h3 class="pull-right">'. $row['price'] .' &#8364;</h3>
                    </div>
                </div>
            </li>
        </ul>
        </div>
        </div>
    </div>
    
    <div class="col-lg-1"></div>';
    echo '</div>';

}
echo '</div>';
?>

