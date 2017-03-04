<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
    $user_home->redirect('/');
}

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userId=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php require_once 'tags/header.php'; ?>

    <title>Profile</title>

</head>
<body id="members">
<?php include_once("analyticstracking.php") ?>
<div>
    <?php require_once 'tags/navmembers.php'; ?>
</div>
<div>
<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="media">
                <div align="center">
                    <img class="thumbnail img-responsive" src="img/hackerman.jpg" width="200px" height="200px">
                    <!---<a href="photoupload" class="btn btn-primary btn-info" style="background-color: #3385ff"><span class="glyphicon glyphicon-camera"></span></a>--->
                </div>
                <div class="media-body">
                    <hr>
                    <h5><strong>First name</strong></h5>
                    <p><?php echo $row['firstName']?></p>
                    <hr>
                    <h5><strong>Last name</strong></h5>
                    <p><?php echo $row['lastName']?></p>
                    <hr>
                    <h5><strong>Location</strong></h5>
                    <p><?php echo $row['city']?></p>
                    <hr>
                    <h5><strong>Gender</strong></h5>
                    <p><?php echo $row['sex']?></p>
                    <hr>
                    <h5><strong>Email</strong></h5>
                    <p><?php echo $row['userEmail']?></p>
                    <hr>
                    <button class="btn btn-primary pull-right" type="submit" name="updateProfile">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-9">
    <div class="container" style="color: #3385ff;padding-bottom: 20px; padding-top: 10px; padding-left:0px ">
        <h2><strong><?php echo $row['userName']; ?></strong></h2>
    </div>
    <div class="panel panel-default">
        <div class="panel-body ">
            <h3 style="padding-bottom:20px; padding-left: 10px"><strong>Meine Inserate</strong></h3>
            <div class="col-md-4">
                <img src="#" class="thumbnail" width="283" height="230">
                <hr>
                <img src="#" class="thumbnail" width="283" height="230">
            </div>
            <div class="col-md-4">
                <img src="#" class="thumbnail" width="283" height="230">
                <hr>
                <img src="#" class="thumbnail" width="283" height="230">
            </div>
            <div class="col-md-4">
                <img src="#" class="thumbnail" width="283" height="230">
                <hr>
                <img src="#" class="thumbnail" width="283" height="230">
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>