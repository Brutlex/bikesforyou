<?php
session_start();
require_once 'class.user.php';
$user_login = new USER();

if($user_login->is_logged_in()!="")
{
    $user_login->redirect('home');
}

if(isset($_POST['btn-login']))
{
    $uemail = trim($_POST['uemail']);
    $upass = trim($_POST['upass']);

    if($user_login->login($uemail,$upass))
    {
        $user_login->redirect('home');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php require_once 'tags/header.php'; ?>


    <title>BikesForYou</title>

</head>

<body id="home">
    <?php include_once("analyticstracking.php") ?>
    <div>
        <?php require_once 'tags/navbar.php'; ?>
    </div>
    <form action="search" id="searchform" method="get" name="form_search">
        <div class="container" id="search" >
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div id="imaginary_container">
                        <div class="input-group stylish-input-group">
                            <input type="text" id="textInput" class="form-control" name="searchbar"  placeholder="Search by article name" pattern="[^'\x22]+" title="Cannot contain apostrophes"  >
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


        <div class="padding">
            <div class="container" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body" >
                                <div class="form-group">
                                    <label for="category1" class="control-label">Category</label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="any">Any</option>
                                        <option value="Mountainbike">Mountainbike</option>
                                        <option value="City bike">City bike</option>
                                        <option value="Trekkingbike">Trekkingbike</option>
                                        <option value="Road bike">Road bike</option>
                                        <option value="Kids bike">Kids bike</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="brand" class="control-label">Brand</label>
                                    <div class="input-group">
                                        <input type="text" name="brand" class="form-control" id="brand" placeholder="Enter brand name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pricefrom" class="control-label">Min Price</label>
                                    <div class="input-group">
                                        <div class="input-group-addon" id="basic-addon1">€</div>
                                        <input type="number" name="price_from" min="0" max="5000" value="0" class="form-control" id="pricefrom" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="priceto" class="control-label">Max Price</label>
                                    <div class="input-group">
                                        <div class="input-group-addon" id="basic-addon2">€</div>
                                        <input type="number" name="price_to" min="0" max="5000" value="5000" class="form-control" id="priceto" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="material" class="control-label">Frame material</label>
                                    <select class="form-control" name="material" id="material">
                                        <option value="any">Any</option>
                                        <option value="Steel">Steel</option>
                                        <option value="Aluminium">Aluminium</option>
                                        <option value="Carbon">Carbon</option>
                                        <option value="Titanium">Titanium</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="colour" class="control-label">Colour</label>
                                    <select class="form-control" name="colour" id="colour">
                                        <option value="any">Any</option>
                                        <option value="Black">Black</option>
                                        <option value="White">White</option>
                                        <option value="Red">Red</option>
                                        <option value="Yellow">Yellow</option>
                                        <option value="Blue">Blue</option>
                                        <option value="Green">Green</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Search</button>
                                </div>

                            </div>
                        </div>
                    </div>




                    <div class="col-md-9">
                        <div class="panel panel-default">
                            <div class="panel-body ">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>



</body>

</html>