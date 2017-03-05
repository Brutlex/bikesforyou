<?php
session_start();
require_once 'class.user.php';
require_once 'class.article.php';

//initalize objects

$user_login = new USER();
$user_home = new USER();
$articleObj = new ARTICLE;

//support for login button in navbar, allows user to login with data entered

if(isset($_POST['btn-login']))
{
    $uemail = trim($_POST['uemail']);
    $upass = trim($_POST['upass']);

    if($user_login->login($uemail,$upass))
    {
        $user_login->redirect('/');
    }
}

//get data of the logged in user

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userId=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//get data of the user profile specified with the value "user" in the link with the get method

$stmtProfile = $user_home->runQuery("SELECT * FROM users WHERE userName=:uname");
$stmtProfile->execute(array(":uname"=>$_GET['user']));
$rowProfile = $stmtProfile->fetch(PDO::FETCH_ASSOC);

//redirect if invalid "user" is specified or the user is trying to access his profile while not logged in

if ($rowProfile=="" || !isset($_GET['user'])){
    $user_home->redirect('/');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php require_once 'tags/header.php'; ?>

    <title>Profile</title>

</head>
<body id = "profile">
<div id="members">
<?php include_once("analyticstracking.php") ?>
<div>
    <?php

    //different navbars if user is logged in or not

    if(!$user_home->is_logged_in()){
        require_once 'tags/navbar.php';
    }
    else{
        require_once 'tags/navmembers.php';
    } ?>

    <!-- set values in the profile view, received from the $rowProfile variable -->
</div>
<div class="padding">
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="media">
                <div align="center">
                    <img class="thumbnail img-responsive" src="img/hackerman.jpg" width="200px" height="200px"></div>
                <div class="media-body">
                    <hr>
                    <h5><strong>First name</strong></h5>
                    <p><?php echo $rowProfile['firstName']?></p>
                    <hr>
                    <h5><strong>Last name</strong></h5>
                    <p><?php echo $rowProfile['lastName']?></p>
                    <hr>
                    <h5><strong>Location</strong></h5>
                    <p><?php echo $rowProfile['city']?></p>
                    <hr>
                    <h5><strong>Gender</strong></h5>
                    <p><?php echo $rowProfile['sex']?></p>
                    <hr>
                    <h5><strong>Email</strong></h5>
                    <p><?php echo $rowProfile['userEmail']?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-9">
    <div class="container" style="color: #3385ff;padding-bottom: 20px; padding-top: 10px; padding-left:0px ">
        <h2><strong><?php echo $rowProfile['userName']; ?></strong></h2>
    </div>

    <?php

    //list articles posted by the user whose profile is open

        $stmtPosts = $articleObj->runQuery("SELECT * FROM articles WHERE userId =:uid");
        $stmtPosts->execute(array(":uid"=>$rowProfile['userId']));
        $results = $stmtPosts->fetchAll();

        if ($results == null){
            echo "<div class=\"jumbotron\">
                <h1 align='center'>No articles found :(</h1>      
                </div>";
        }
            foreach($results as $row2) {


                $stmt = $articleObj->runQuery("SELECT * FROM users WHERE userId = :userId");
                $stmt->execute(array(":userId" => $row2['userId']));
                $author = $stmt->fetch(PDO::FETCH_ASSOC);

                $authorName = $author['userName'];
                $articleName = $row2['articleName'];
                $price = $row2['price'];

                $pic = "//img/articlePics/" . $row2['picture'];

                if ($row2['picture'] == "") {
                    $picture = "default.png";
                } else if (file_exists($pic)) {
                    $picture = $row2['picture'];
                } else {
                    $picture = $row2['picture'];
                }
                $articleObj->printArticle($picture,$articleName,$authorName,$price);
            }
    ?>
</div>
</div>
</div>
</body>
</html>