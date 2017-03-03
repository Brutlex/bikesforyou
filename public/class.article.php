<?php

require_once 'config.php';

class ARTICLE
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

    public function search($article_name,$category,$price_from,$price_to,$colour,$material,$brand)
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
    public function post($userId,$articleName,$articleDescription,$category,$material,$frameSize,$price,$brand,$colour)
    {
        try
        {
            $stmt = $this->conn->prepare("INSERT INTO articles(userId,articleName,description,category,material,frameSize,price,brand,colour,time) 
                                                VALUES(:user_id, :article_name, :article_description, :category, :material, :frame_size, :price, :brand, :colour, NOW())");
            $stmt->bindparam(":user_id",$userId);
            $stmt->bindparam(":article_name",$articleName);
            $stmt->bindparam(":article_description",$articleDescription);
            $stmt->bindparam(":category",$category );
            $stmt->bindparam(":material",$material);
            $stmt->bindparam(":frame_size",$frameSize);
            $stmt->bindparam(":price",$price);
            $stmt->bindparam(":brand",$brand);
            $stmt->bindparam(":colour",$colour);

            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
}