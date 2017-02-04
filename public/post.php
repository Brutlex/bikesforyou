<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
    $user_home->redirect('register');
}

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userId=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['postIt'])) {
    $userId = $_SESSION['userSession'];
    $articleName = $_POST['articleName'];
    $articleDescription = $_POST['articleDescription'];
    $category = trim($_POST['category']);
    $material = trim($_POST['material']);
    $frameSize = trim($_POST['frameSize']);
    $price = $_POST['price'];
    $brand1 = trim($_POST['brand']);
    $colour = trim($_POST['colour']);


    if ($user_home->post($userId, $articleName, $articleDescription, $category, $material, $frameSize, $price, $brand1, $colour)) {

        $msg = "     
                    <div class='alert alert-success'>
                    <button class='close' data-dismiss='alert'>&times;</button>
                    <strong>Success!</strong>  Your post has been created. 
                    </div>
                    ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php require_once 'tags/header.php'; ?>

    <title>Post</title>

</head>

<body id="post">
<?php include_once("analyticstracking.php") ?>
<div>
    <?php require_once 'tags/navmembers.php'; ?>
</div>

<div class="col-lg-2"></div>

<div class="container col-lg-8" id="postform">
    <div class="col-md-6">

    <form class="form-horizontal" method="post">
    <?php if(isset($msg)) {
        echo $msg;
    } ?>
            <h2><strong>Post an article</strong></h2>
            <legend class="col-form-legend col-sm-12"></legend>

                <div class="container-fluid" id="form-label">

                    <div class="form-group">
                        <label for="articleName" class="col-form-label col-sm-8">Article name:</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="articleName" placeholder="Enter article name" required>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="articleName" class="col-form-label col-sm-8">Article description:</label>
                        <div class="col-sm-12">
                            <input style="height:100px ;" type="text" class="form-control" name="articleDescription" placeholder="Enter article description" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-form-label col-sm-8">Category:</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="category" required>
                                <option value="" disabled selected>Select your option</option>
                                <option value="m">Mountainbike</option>
                                <option value="c">City bike</option>
                                <option value="t">Trekkingbike</option>
                                <option value="r">Road bike</option>
                                <option value="k">Kid's bike</option>
                                <option value="o">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="material" class="col-form-label col-sm-8">Material:</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="material" >
                                <option value="" disabled selected>Select your option</option>
                                <option value="steel">Steel</option>
                                <option value="aluminium">Aluminium</option>
                                <option value="carbon">Carbon</option>
                                <option value="titanium">Titanium</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="frameSize" class="col-form-label col-sm-8">Frame size:</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="frameSize">
                                <option value="" disabled selected>Select your option</option>
                                <option value="s">S</option>
                                <option value="m">M</option>
                                <option value="l">L</option>
                                <option value="xl">XL</option>
                                <option value="xxl">XXL</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-form-label col-sm-8">Price:</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" name="price" placeholder="Enter price" min="0" max="5000" required>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="brand" class="col-form-label col-sm-8">Brand:</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="brand" placeholder="Enter brand">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="colour" class="col-form-label col-sm-8">Colour:</label>
                        <div class="col-sm-12">
                            <select class="form-control" name="colour" >
                                <option value="" disabled selected>Select your option</option>
                                <option value="black">black</option>
                                <option value="white">white</option>
                                <option value="green">green</option>
                                <option value="yellow">yellow</option>
                                <option value="red">red</option>
                                <option value="blue">blue</option>
                                <option value="orange">orange</option>
                                <option value="other">other</option>
                            </select>
                        </div>
                    </div>







                </div>
        <button class="btn btn-primary pull-right" type="submit" name="postIt">Post it</button>
    </form>
    </div>

    <div class="col-md-6">
        <div class="container-fluid">

        </div>
        <div class="container">
            <label class="control-label">Select Photo</label>
            <input id="input" name="input" type="file" multiple class="file-loading">



        </div>

    </div>

</div>


<div class="col-lg-2"></div>


</body>

</html>

