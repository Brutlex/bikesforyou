<?php
session_start();
require_once 'class.user.php';
require_once 'class.article.php';
$user_home = new USER();
$articleObj = new ARTICLE();

if(!$user_home->is_logged_in())
{
    $user_home->redirect('login?ref=post');
}

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userId=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['btn-post'])) {
    $userId = $_SESSION['userSession'];
    $articleName = $_POST['articleName'];
    $articleDescription = $_POST['articleDescription'];
    $category = trim($_POST['category']);
    $material = trim($_POST['material']);
    $frameSize = trim($_POST['frameSize']);
    $price = $_POST['price'];
    $brand1 = trim($_POST['brand']);
    $colour = trim($_POST['colour']);
    $file = $_FILES['photoUpload'];


    if ($articleObj->post($userId, $articleName, $articleDescription, $category, $material, $frameSize, $price, $brand1, $colour)) {

        $msg = "     
                    <div class='alert alert-success'>
                    <button class='close' data-dismiss='alert'>&times;</button>
                    <strong>Success!</strong>  Your article has been created. 
                    </div>
                    ";

        if(isset($file)) {

            if ($articleObj->upload($file, $userId, $price, $articleName)) {
                $msg_upload = "     
                    <div class='alert alert-success'>
                    <button class='close' data-dismiss='alert'>&times;</button>
                    Photo uploaded. 
                    </div>
                    ";
            } else {
                $msg_upload = "     
                    <div class='alert alert-danger'>
                    <button class='close' data-dismiss='alert'>&times;</button>
                    Invalid file. 
                    </div>
                    ";
            }
        }
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


<div class="container cont-msg">

    <?php if(isset($msg)) {

        echo "<script>setTimeout(\"location.href = 'http://www.bikesforyou.at';\",3000);</script>";

        echo $msg;
    }
    if(isset($msg_upload)){
        echo $msg_upload;
    }?>

    <div class="panel panel-default ">
        <div class="panel-body" >

            <div class="form-group col-lg-6 col-lg-offset-3" >
                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="text-center">
                        <h3>Post an article</h3>
                    </div>

                    <hr/>

                    <label for="articleName" class="control-label">Article name</label>
                    <div class="input-group col-lg-12 form-padding">
                        <input type="text" class="form-control" name="articleName" placeholder="Enter article name" required>
                    </div>

                    <label for="articleDescription" class="control-label">Article description</label>
                    <div class="input-group col-lg-12 form-padding">
                        <input type="text" class="form-control" name="articleDescription" placeholder="Enter detailed article description" required>
                    </div>

                    <label for="category" class="control-label">Category</label>
                    <div class="input-group col-lg-12 form-padding">
                        <select class="form-control" name="category" id="category" required>
                            <option value="" disabled selected>Select</option>
                            <option value="Mountainbike">Mountainbike</option>
                            <option value="City bike">City bike</option>
                            <option value="Trekkingbike">Trekkingbike</option>
                            <option value="Road bike">Road bike</option>
                            <option value="Kids bike">Kids bike</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <label for="brand" class="control-label">Brand</label>
                    <div class="input-group col-lg-12 form-padding">
                        <input type="text" name="brand" class="form-control" id="brand" placeholder="Enter bicycle brand">
                    </div>

                    <label for="price" class="control-label">Price:</label>
                    <div class="input-group col-lg-12 form-padding">
                        <input type="number" class="form-control" name="price" placeholder="Enter price" min="0" max="5000" required>
                        <div class="input-group-addon" id="basic-addon"><span>€</span></div>
                    </div>

                    <label for="material" class="control-label">Frame material</label>
                    <div class="input-group col-lg-12 form-padding">
                        <select class="form-control" name="material" id="material">
                            <option value="" disabled selected>Select</option>
                            <option value="Steel">Steel</option>
                            <option value="Aluminium">Aluminium</option>
                            <option value="Carbon">Carbon</option>
                            <option value="Titanium">Titanium</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <label for="colour" class="control-label">Colour</label>
                    <div class="input-group col-lg-12 form-padding">
                        <select class="form-control" name="colour" id="colour">
                            <option value="" disabled selected>Select</option>
                            <option value="Black">Black</option>
                            <option value="White">White</option>
                            <option value="Red">Red</option>
                            <option value="Yellow">Yellow</option>
                            <option value="Blue">Blue</option>
                            <option value="Green">Green</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <label for="frameSize" class="control-label">Frame size</label>
                    <div class="input-group col-lg-12 form-padding">
                        <select class="form-control" name="frameSize" id="frameSize">
                            <option value="" disabled selected>Select</option>
                            <option value="S">S</option>
                            <option value="M">M</option>
                            <option value="L">L</option>
                            <option value="XL">XL</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>

                    <label for="photo" id="photoUpload"class="control-label">Upload a bicycle photo</label>
                    <div class="input-group form-padding">
                        <input type="file" name="photoUpload" id="photoUpload">
                    </div>

                    <div class="form-group form-padding">
                        <button class="btn btn btn-primary btn-block" id="post-submit" type="submit" name="btn-post">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


</div>



</body>

</html>

