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
            <strong><a href=\"/\" class=\"alert-link\"><p align = 'center'>Try a different search</p></a></strong>
            </div>";
}


foreach($result as $row){

    $stmt = $articleObj->runQuery("SELECT * FROM users WHERE userId = :userId");
    $stmt->execute(array(":userId" => $row['userId']));
    $author = $stmt->fetch(PDO::FETCH_ASSOC);

    $author_name = $author['userName'];
    $articleName = $row['articleName'];
    $price = $row['price'];

    $pic = "//img/articlePics/" . $row['picture'];

    if($row['picture'] == ""){
        $picture = "default.png";
    }
    else if (file_exists($pic)){
        $picture = $row['picture'];
    }
    else{
        $picture = $row['picture'];
    }

    echo'<div class="container">
            <div class="col-lg-1"></div>
                <div class="col-lg-10">';

    $articleObj->printArticle($picture,$articleName,$author_name,$price);

    echo'       </div>
            <div class="col-lg-1"></div>
        </div>';

}
echo '</div>';
?>

