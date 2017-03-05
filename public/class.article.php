<?php

//main class containing basic functions for handling articles such as search and article posting

require_once 'config.php';

class ARTICLE
{
    //initialize the connection variable

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

    //gets the last id set in the table with id set on auto increment, PDO function

    public function lastID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }

    //executes the search with the given parameters as the search filters
    //returns a two dimensional array containing all the result rows matching the search query

    public function search($article_name, $category, $price_from, $price_to, $colour, $material, $brand)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM articles 
                                                        WHERE articleName LIKE :article_name 
                                                        AND category LIKE :category 
                                                        AND colour LIKE :colour 
                                                        AND material LIKE :material 
                                                        AND brand LIKE :brand
                                                        AND price BETWEEN :price_from AND :price_to");
            $stmt->bindparam(":article_name", $article_name);
            $stmt->bindparam(":category", $category);
            $stmt->bindparam(":colour", $colour);
            $stmt->bindparam(":material", $material);
            $stmt->bindparam(":brand", $brand);
            $stmt->bindparam(":price_from", $price_from);
            $stmt->bindparam(":price_to", $price_to);

            $stmt->execute();

            $result = $stmt->fetchAll();
            return $result;

        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    //executes the posting of a new article with the input parameters being the article data from the post form
    //inserts a new row in the articles table with the data in the parameters
    //returns a boolean telling if post was executed well or not

    public function post($userId, $articleName, $articleDescription, $category, $material, $frameSize, $price, $brand, $colour)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO articles(userId,articleName,description,category,material,frameSize,price,brand,colour,time) 
                                                VALUES(:user_id, :article_name, :article_description, :category, :material, :frame_size, :price, :brand, :colour, NOW())");
            $stmt->bindparam(":user_id", $userId);
            $stmt->bindparam(":article_name", $articleName);
            $stmt->bindparam(":article_description", $articleDescription);
            $stmt->bindparam(":category", $category);
            $stmt->bindparam(":material", $material);
            $stmt->bindparam(":frame_size", $frameSize);
            $stmt->bindparam(":price", $price);
            $stmt->bindparam(":brand", $brand);
            $stmt->bindparam(":colour", $colour);

            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }

    //uploads the image from the post an article form, image name is changed to a unique timestamp before upload to avoid same name images
    //parameters passed are the file set for upload, and criteria for updating the value of the column
    //checks if file is an image, image size, and extension
    //if everything is ok, saves the image in the given directory and updates the picture column with the name of the image
    //returns boolean for success/failed

    public function upload($file, $uid, $price, $articleName)
    {
        $target_dir = "img/articlePics/";
        $target_file = $target_dir . basename($file["name"]);
        $template = explode(".", $file["name"]);
        $newfilename = round(microtime(true)) . '.' . end($template);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);


        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }


        if ($file["size"] > 500000) {
            return false;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($file["tmp_name"], "img/articlePics/" . $newfilename)) {

                try {
                    $stmt = $this->conn->prepare("UPDATE articles SET picture = :picture WHERE userId = :uid AND price = :price AND articleName= :articleName");
                    $stmt->bindparam(":picture", $newfilename);
                    $stmt->bindparam(":uid", $uid);
                    $stmt->bindparam(":price", $price);
                    $stmt->bindparam(":articleName", $articleName);

                    $stmt->execute();

                } catch (PDOException $ex) {
                    echo $ex->getMessage();
                }
                return true;
            } else {
                return false;
            }
        }
    }

    //function that prints the html code containing all the data passed in the parameters

    public function printArticle($picture, $articleName, $authorName, $price)
    {
        echo '
        <div class="panel panel-default">
        <div class="panel-body">
        <ul style="list-style: none">
            <li>
                <div class="container col-sm-4" >
                    <img src="img/articlePics/' . $picture . ' " class="img-responsive">
                </div>
                <div class="col-sm-8">
                    <div class="col-sm-8">
                        <p>' . $articleName . '</p>
                        <br>
                        <br>
                        <br>
                        <p>Posted by: <strong><a href="profile?user=' . $authorName . '" class="alert-link">' . $authorName . '</a></strong></p>
                    </div>
                    <div class="col-sm-4">
                        <h3 class="pull-right">'. $price .' &#8364;</h3>
                    </div>
                </div>
            </li>
        </ul>
        </div>
        </div>
    
';
    }
}