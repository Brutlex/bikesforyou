<?php

//main class containing basic functions for handling the user system such as login and registration


require_once 'config.php';

class USER
{
    //initialize the database connection variable

    private $conn;

    //constructor function, established database connections using the Database class, executed every time on include

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    //prepares the query given in the $sql parameter for execution with PDO, query still needs to have variables bound and be executed

    public function runQuery($sql)
{
    $stmt = $this->conn->prepare($sql);
    return $stmt;
}

    //a simple function just to make redirecting easier, redirects the user to the url specified in the parameter

    public function redirect($url)
    {
        header("Location: $url");
    }

    //gets the last id set in the table with id set on auto increment, PDO function

    public function lastID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }

    //registers a new user, creating a new row in the database
    //parameters passed are the user information from the registration form
    //includes the password hashing function which improves the security of the user accounts
    //returns a boolean for success/failed registration

    public function register($uname,$uemail,$upass,$sex,$firstname,$lastname,$city,$zip,$phone)
    {
        $pwhash = password_hash($upass,PASSWORD_DEFAULT);
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO users(userName,userEmail,userPass,sex,firstName,lastName,city,zip,phoneNumber,registrationDate) 
                                                VALUES(:user_name, :user_mail, :user_pass, :sex, :first_name, :last_name, :city, :zip, :phone_number, NOW())");
            $stmt->bindparam(":user_name",$uname);
            $stmt->bindparam(":user_mail",$uemail);
            $stmt->bindparam(":user_pass",$pwhash);
            $stmt->bindparam(":sex",$sex);
            $stmt->bindparam(":first_name",$firstname);
            $stmt->bindparam(":last_name",$lastname);
            $stmt->bindparam(":city",$city);
            $stmt->bindparam(":zip",$zip);
            $stmt->bindparam(":phone_number",$phone);

            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    //function which logs the user in with the data passed in the parameters
    //if validation is successful, starts a new session with the session id being the user id
    //returns a boolean for success/failed and redirects the user to the corresponding page

    public function login($uemail,$upass)
    {
        try
        {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id"=>$uemail));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

            if($stmt->rowCount() == 1)
            {
                if($userRow['userStatus']=="Y")
                {
                    if(password_verify($upass,$userRow['userPass']))
                    {
                        $_SESSION['userSession'] = $userRow['userId'];
                        return true;
                    }
                    else
                    {
                        header("Location: login?ref=incorrect");
                        exit;
                    }
                }
                else
                {
                    header("Location: login");
                    exit;
                }
            }
            else
            {
                header("Location: login?ref=incorrect");
                exit;
            }
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    //checks if user is logged in (if user session is set)

    public function is_logged_in()
    {
        if(isset($_SESSION['userSession']))
        {
            return true;
        }
    }

    //logs the user out, destroys user session

    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }

    //function for sending confirmation mails, doesn't work since web server provider has blocked phpmailer

/*    function send_mail($uemail,$message,$subject)
    {
        require_once('libs/PHPMailer/PHPMailerAutoload.php');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 1;
        $mail->SMTPAuth   = false;
        $mail->SMTPSecure = false;
        $mail->Host       = "mailout.one.com";
        $mail->Port       = 25;
        $mail->AddAddress($uemail);
        $mail->Username="noreply@bikesforyou.at";
        $mail->Password="verynoobs";
        $mail->SetFrom('noreply@bikesforyou.at','BikesForYou');
        $mail->AddReplyTo("noreply@bikesforyou.at","BikesForYou");
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }*/
}