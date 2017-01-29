<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
    $user_home->redirect('index');
}

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userId=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <?php require_once 'tags/header.php'; ?>

        <title>BikesForYou</title>

    </head>
    <body id="members">
        <?php include_once("analyticstracking.php") ?>
        <div>
            <?php require_once 'tags/navmembers.php'; ?>
        </div>

        <div class="container" id="search" >
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div id="imaginary_container">
                        <div class="input-group stylish-input-group">
                            <input type="text" class="form-control"  placeholder="What are you looking for?" >
                            <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid" style="padding-top: 20px;">
            <div class="row" style="color:#3385ff; padding-left: 40px;">
                <h4><strong>Filter your search</strong</h4>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-3">
                    <div id="accordion" class="panel panel-primary behclick-panel">
                        <div class="panel-body" >
                            <div class="panel-heading " >
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse0">
                                        <i class="indicator fa fa-caret-down" aria-hidden="true"></i> Price
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse0" class="panel-collapse collapse" >
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                0€ - 100€
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="checkbox" >
                                            <label>
                                                <input type="checkbox" value="">
                                                100€ - 200€
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="checkbox"  >
                                            <label>
                                                <input type="checkbox" value="">
                                                200€ - 300€
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="checkbox"  >
                                            <label>
                                                <input type="checkbox" value="">
                                                More Than 300€
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="panel-heading " >
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse1">
                                        <i class="indicator fa fa-caret-down" aria-hidden="true"></i> Brand
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse" >
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                KTM
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="checkbox" >
                                            <label>
                                                <input type="checkbox" value="">
                                                Trek
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="checkbox"  >
                                            <label>
                                                <input type="checkbox" value="">
                                                Scott
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="panel-heading" >
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse3"><i class="indicator fa fa-caret-down" aria-hidden="true"></i> Color</a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="">
                                                red
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="checkbox" >
                                            <label>
                                                <input type="checkbox" value="">
                                                blue
                                            </label>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="checkbox"  >
                                            <label>
                                                <input type="checkbox" value="">
                                                green
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </body>

</html>