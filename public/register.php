<?php

session_start();
require_once 'class.user.php';

//initalize objects

$reg_user = new USER();
$user_login = new USER();

//check if user is logged in, logged in users can't access the register page

if($reg_user->is_logged_in()!="")
{
    $reg_user->redirect('/');
}

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

//check if sign up button is pressed, if yes, prepare the variables received from form to use in query

if(isset($_POST['btn-signup'])) {
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

    //check if email already exists

    $stmt = $reg_user->runQuery("SELECT userEmail FROM users WHERE userEmail=:email_id");
    $stmt->execute(array(":email_id" => $uemail));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //check if username already exists

    $stmt2 = $reg_user->runQuery("SELECT userName FROM users WHERE userName=:uname");
    $stmt2->execute(array(":uname" => $uname));
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    //set messages if validation failed

    if ($stmt->rowCount() > 0) {
        $msg_err = "
                    <div class='alert alert-danger'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        <strong>Email</strong> is already registered. Please log in or choose another one.
                    </div>
                    ";
    }
    elseif ($stmt2->rowCount() > 0) {
        $msg_err = "
                    <div class='alert alert-danger'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        <strong>Username</strong> is already in use. Please choose another one.
                    </div>
                    ";
    }


     elseif ($upass!= $upass2)
        {
            $msg_err = "
                        <div class='alert alert-danger'>
                            <button class='close' data-dismiss='alert'>&times;</button>
                            <strong>Passwords</strong> do not match. Please try again.
                        </div>
                        ";

    }

    //if everything is ok with the input and registration was successful, log the user in, and set the message to notify user

    else {
        if ($reg_user->register($uname, $uemail, $upass, $sex, $firstname, $lastname, $city, $zip, $phone)) {
            /*




                    $id = $reg_user->lastID();
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

            $reg_user->login($uemail,$upass);

            $msg = "
                    <div class='alert alert-success'>
                        <button class='close' data-dismiss='alert'>&times;</button>
                        <strong>Success!</strong>  Your account has been created. You will be redirected back to the home page. If it doesn't work <a href=\"home\" class=\"alert-link\">click here</a>. 
                    </div>
                    ";

        } else {
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
        <div class="container cont-msg col-lg-6 col-lg-offset-3">

            <?php

            //print the messages set before, redirect after successful registration with 5 sec delay

            if(isset($msg)) {
                echo "<script>setTimeout(\"location.href = 'http://www.bikesforyou.at';\",5000);</script>";
                echo $msg;
            }
            if(isset($msg_err)){
                echo $msg_err;
            }?>


            <div class="panel panel-default ">
                <div class="panel-body" >
                    <div class="form-group col-lg-6 col-lg-offset-3" >
                        <form class="form-horizontal" method="post">
                            <div class="text-center">
                                <h3>Please enter your data</h3>
                            </div>
                            <hr/>

                            <label for="username" class="control-label">Username</label>
                            <div class="input-group col-lg-12 form-padding">
                                <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" pattern=".{5,}" title="Must contain 5 or more characters" required>
                            </div>

                            <label for="email" class="control-label">Email</label>
                            <div class="input-group col-lg-12 form-padding">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="Please enter a valid email adress" required>
                            </div>

                            <label for="pwd" class="control-label">Password</label>
                            <div class="input-group col-lg-12 form-padding">
                                <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Enter password" pattern=".{6,}" title="Must contain 6 or more characters" required>
                            </div>

                            <label for="pwd2" class="control-label">Confirm password</label>
                            <div class="input-group col-lg-12 form-padding">
                                <input type="password" name="pwd2" class="form-control" id="pwd2" placeholder="Confirm password" pattern=".{6,}" title="Must contain 6 or more characters" required>
                            </div>

                            <label for="gender" class="control-label"">Gender</label>
                            <div class="input-group col-lg-12 form-padding">
                                <label class="radio-inline">
                                    <input type="radio" name="title" value="M" required> Male
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="title" value="F" required> Female
                                </label>
                            </div>

                            <label for="firstname" class="control-label">First name</label>
                            <div class="input-group col-lg-12 form-padding">
                                <input type="text" name="firstName" class="form-control" id="firstName" placeholder="Enter first name" pattern="[A-Za-z]{2,}" title="Invalid input. Letters only." required>
                            </div>

                            <label for="lastname" class="control-label">Last name</label>
                            <div class="input-group col-lg-12 form-padding">
                                <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Enter last name" pattern="[A-Za-z]{2,}" title="Invalid input. Letters only." required>
                            </div>

                            <hr/>

                            <label for="city" class="control-label">City</label>
                            <div class="input-group col-lg-12 form-padding">
                                <input type="text" name="city" class="form-control" id="city" placeholder="Enter city" pattern="[A-Za-z]{2,}" title="Invalid input. Letters only.">
                            </div>

                            <label for="zip" class="control-label">ZIP</label>
                            <div class="input-group col-lg-12 form-padding">
                                <input type="text" name="zip" class="form-control" id="zip" placeholder="Enter ZIP code" pattern="[0-9]{2,}" title="Invalid input. Numbers only.">
                            </div>

                            <label for="phone" class="control-label">Phone number</label>
                            <div class="input-group col-lg-12 form-padding">
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Enter phone number" pattern="[0-9]{6,32}" title="Invalid input. Numbers only. Replace '+' with '00'">
                            </div>

                            <div class="form-group form-padding">
                                <button class="btn btn btn-primary btn-block" id="reg-submit" type="submit" name="btn-signup">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>