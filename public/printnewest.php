<?php
require_once ('class.article.php');

$articleObj = new ARTICLE();

$stmt = $articleObj->runQuery("SELECT * FROM articles ORDER BY articleId DESC LIMIT 4");
$stmt->execute();
$results = $stmt->fetchAll();


foreach($results as $row){


    $stmt = $articleObj->runQuery("SELECT * FROM users WHERE userId = :userId");
    $stmt->execute(array(":userId" => $row['userId']));
    $author = $stmt->fetch(PDO::FETCH_ASSOC);

    $author_name = $author['userName'];
    $articleName = $row['articleName'];
    $price = $row['price'];

    $pic = "//img/articlePics/" . $row['picture'];

    if($row['picture'] == ""){
        $picture = "default.png";
    }
    else if (file_exists($pic)){
        $picture = $row['picture'];
    }
    else{
        $picture = $row['picture'];
    }


    $articleObj->printArticle($picture,$articleName,$author_name,$price);
}
?>