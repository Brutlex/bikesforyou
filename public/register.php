<?php

session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="")
{
    $reg_user->redirect('home.php');
}


if(isset($_POST['btn-signup']))
{
    $uname = trim($_POST['username']);
    $uemail = trim($_POST['email']);
    $upass = trim($_POST['pwd']);
    $upass2 = trim($_POST['pwd2']);
    $sex = $_POST['title'];
    $firstname = trim($_POST['firstName']);
    $lastname = trim($_POST['lastName']);
    $city = trim($_POST['city']);
    $zip = trim($_POST['zip']);
    $phone = trim($_POST['phone']);
    $pwhash = password_hash($upass, PASSWORD_BCRYPT);

//  $code = md5(uniqid(rand()));

    $stmt = $reg_user->runQuery("SELECT * FROM users WHERE userEmail=:email_id");
    $stmt->execute(array(":email_id"=>$uemail));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($stmt->rowCount() > 0)
    {
        $msg = "
        <div class='alert alert-error'>
    <button class='close' data-dismiss='alert'>&times;</button>
     <strong>Sorry !</strong>  email already exists , Please Try another one
     </div>
     ";
    }
    else
    {
        if($reg_user->register($uname,$uemail,$upass,$sex,$firstname,$lastname,$city,$zip,$phone))
        {
/*          $id = $reg_user->lastID();
            $key = base64_encode($id);
            $id = $key;*/

 /*           $message = "
      Hello $uname,
      <br /><br />
      Welcome to BikesForYou!<br/>
      To complete your registration  please , just click following link<br/>
      <br /><br />
      <a href='http://www.bikesforyou.at/verify?id=$id&code=$code'>Click HERE to Activate :)</a>
      <br /><br />
      Thanks,";

            $subject = "Confirm Registration";

            $reg_user->send_mail($uemail, $message, $subject);

            $msg = "
     <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Success!</strong>  We've sent an email to $uemail.
                    Please click on the confirmation link in the email to create your account. 
       </div>
   ";*/

            $msg = "     
     <div class='alert alert-success'>
      <button class='close' data-dismiss='alert'>&times;</button>
      <strong>Success!</strong>  Your accout has been created. You will be redirected back to the home page. 
       </div>
       ";

        }
        else
        {
            echo "Sorry, could not execute.";
        }
    }
}
?>
<html>
    <head>

        <?php require_once 'tags/header.php'; ?>

        <title>Sign Up</title>

    </head>
    <body id="register">
        <?php include_once("analyticstracking.php") ?>
        <div>
            <?php require_once 'tags/navbar.php'; ?>
        </div>
        <div class="container-fluid">
            <?php if(isset($msg)) echo $msg;  ?>
        <div class="container" id="regform">

            <form class="form-horizontal" method="post">
                <h3>Please enter your data</h3>
                <legend class=" col-form-legend col-sm-6"></legend>
                <div class="container-fluid" id="form-label">
                <div class="form-group">
                    <label class="col-form-label col-sm-2" for="username">Username:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="username" placeholder="Enter username" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-form-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="email" placeholder="Enter email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-form-label col-sm-2" name="pwd">Password:</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" name="pwd" placeholder="Enter password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-form-label col-sm-2" name="pwd2">Confirm Password:</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" name="pwd2" placeholder="Confirm password" required>
                    </div>
                </div>

                    <div class="form-group">
                        <label class="col-form-label col-sm-2" for="title">Title:</label>
                        <div class="col-sm-4">
                        <label class="radio-inline">
                            <input type="radio" name="title" value="M" required> Mr.
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="title" value="F" required> Mrs.
                        </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label col-sm-2" for="firstName">First Name:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="firstName" placeholder="Enter first name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label col-sm-2" for="lastName">Last Name:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="lastName" placeholder="Enter last name" required>
                        </div>
                    </div>
                </div>
                <h3>Additional data</h3>
                <legend class="col-form-legend col-sm-6"></legend>
                <div class="container-fluid" id="form-label">

                      <div class="form-group">
                        <label class="col-form-label col-sm-2" for="city">City:</label>
                          <div class="col-sm-3">
                             <input type="text" class="form-control" name="city" placeholder="Enter city">
                          </div>
                     </div>

                        <div class="form-group">
                            <label class="col-form-label col-sm-2" for="zip">ZIP:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="zip" placeholder="Enter ZIP code">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-form-label col-sm-2" for="phone">Phone number:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="phone" placeholder="Enter phone number">
                            </div>
                        </div>
                    </div>
                <button class="btn btn-lg btn-primary" type="submit" name="btn-signup">Sign Up</button>
            </form>
        </div>
        </div>
    </body>
</html>