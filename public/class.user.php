<?php

require_once 'config.php';

class USER
{

    private $conn;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    public function lastID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }

    public function register($uname,$uemail,$upass,$sex,$firstname,$lastname,$city,$zip,$phone)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO users(userName,userEmail,userPass,sex,firstName,lastName,city,zip,phoneNumber) 
                                                VALUES(:user_name, :user_mail, :user_pass, :sex, :first_name, :last_name, :city, :zip, :phone_number)");
            $stmt->bindparam(":user_name",$uname);
            $stmt->bindparam(":user_mail",$uemail);
            $stmt->bindparam(":user_pass",$upass );
//          $stmt->bindparam(":active_code",$code);
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
                    if($userRow['userPass']==$upass)
                    {
                        $_SESSION['userSession'] = $userRow['userId'];
                        return true;
                    }
                    else
                    {
                        header("Location: login");
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
                header("Location: login");
                exit;
            }
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }


    public function is_logged_in()
    {
        if(isset($_SESSION['userSession']))
        {
            return true;
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }

    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }

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