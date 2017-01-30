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
    <form action="search" method="get" name="form_search">
        <div class="container" id="search" >
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div id="imaginary_container">
                        <div class="input-group stylish-input-group">
                            <input type="text" class="form-control" name="searchbar"  placeholder="Search by article name" pattern="[^'\x22]+" title="Cannot contain apostrophes"  >
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


<div class="col-lg-3">
    <div class="container" style="padding-top: 20px;">
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
                                    <i class="indicator fa fa-caret-down" aria-hidden="true"></i> Category
                                </a>
                            </h4>
                        </div>
                        <div id="collapse0" class="panel-collapse collapse" >
                            <div class="form-goup">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="cat" value="%" checked="checked">
                                            all
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="cat" value="Mountainbike">
                                            Mountainbike
                                        </label>
                                    </div>
                                    <div class="radio" >
                                        <label>
                                            <input type="radio" name="cat" value="City bike" >
                                            City bike
                                        </label>
                                    </div>
                                    <div class="radio"  >
                                        <label>
                                            <input type="radio" name="cat" value="Trekkingbike" >
                                            Trekkingbike
                                        </label>
                                    </div>
                                    <div class="radio"  >
                                        <label>
                                            <input type="radio" name="cat" value="Road bike" >
                                            Road bike
                                        </label>
                                    </div>
                                    <div class="radio"  >
                                        <label>
                                            <input type="radio" name="cat" value="Kid's bike" >
                                            Kid's bike
                                        </label>
                                    </div>
                                    <div class="radio"  >
                                        <label>
                                            <input type="radio" name="cat" value="Other" >
                                            Other
                                        </label>
                                    </div>
                            </div>
                        </div>







                        <div class="panel-heading " >
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#collapse1">
                                    <i class="indicator fa fa-caret-down" aria-hidden="true"></i> Price
                                </a>
                            </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse" >
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="form-control">
                                        <label>
                                            from
                                            <input type="number" name="price_from" min="0" max="5000" value="0">
                                            &#8364;
                                        </label>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="form-control">
                                        <label>
                                            to &nbsp &nbsp
                                            <input type="number" name="price_to" min="0" max="5000" value="5000">
                                            &#8364;
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>







                        <div class="panel-heading" >
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#collapse2"><i class="indicator fa fa-caret-down" aria-hidden="true"></i> Color</a>
                            </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="formgroup">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="clr" value="%" checked="checked">
                                            all
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="clr" value="black">
                                            black
                                        </label>
                                    </div>
                                    <div class="radio" >
                                        <label>
                                            <input type="radio"name="clr" value="white">
                                            white
                                        </label>
                                    </div>
                                    <div class="radio"  >
                                        <label>
                                            <input type="radio" name="clr" value="green" >
                                            green
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="clr" value="yellow" >
                                            yellow
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="clr" value="red" >
                                            red
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="clr" value="blue" >
                                            blue
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name ="clr" value="orange" >
                                            orange
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="clr" value="other" >
                                            other
                                        </label>
                                    </div>
                            </div>

                        </div>





                        <div class="panel-heading " >
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#collapse3">
                                    <i class="indicator fa fa-caret-down" aria-hidden="true"></i> Brand
                                </a>
                            </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse" >
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="form-control">
                                        <input type="text" name="brand" name="brand" value="" placeholder="Enter brand">
                                    </div>
                                </li>
                            </ul>
                        </div>




                        <div class="panel-heading " >
                            <h4 class="panel-title">
                                <a data-toggle="collapse" href="#collapse4">
                                    <i class="indicator fa fa-caret-down" aria-hidden="true"></i> Material
                                </a>
                            </h4>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse" >
                            <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="mat" value="%" checked="checked">
                                          all
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="mat" value="steel">
                                            Steel
                                        </label>
                                    </div>
                                    <div class="radio" >
                                        <label>
                                            <input type="radio" name="mat" value="aluminium">
                                            Aluminium
                                        </label>
                                    </div>
                                    <div class="radio"  >
                                        <label>
                                            <input type="radio" name="mat" value="carbon">
                                            Carbon
                                        </label>
                                    </div>
                                    <div class="radio"  >
                                        <label>
                                            <input type="radio" name="mat" value="titanium" >
                                            Titanium
                                        </label>
                                    </div>
                                    <div class="radio"  >
                                        <label>
                                            <input type="radio" name="mat" value="other" >
                                            Other
                                        </label>
                                    </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </form>




    <div class="col-lg-9" style="padding-top: 25px">
       <div class="panel panel-default">
           <div class="panel-body ">
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





</body>

</html>