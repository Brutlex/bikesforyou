<?php
require_once ('class.article.php');

$articleObj = new ARTICLE();

$stmt = $articleObj->runQuery("SELECT * FROM articles ORDER BY articleId ASC LIMIT 4");
$stmt->execute();
$results = $stmt->fetchAll();


foreach($results as $row){


    $stmt = $articleObj->runQuery("SELECT * FROM users WHERE userId = :userId");
    $stmt->execute(array(":userId" => $row['userId']));
    $author = $stmt->fetch(PDO::FETCH_ASSOC);

    $author_name = $author['userName'];


    echo '
        <div class="panel panel-default">
        <div class="panel-body">
        <ul style="list-style: none">
            <li>
                <div class="container col-sm-4" >
                    <img src="img/articlePics/' . $row['picture'] . ' " class="thumbnail img-responsive">
                </div>
                <div class="col-sm-8">
                    <div class="col-sm-8">
                        <p>' . $row['articleName'] . '</p>
                        <br>
                        <br>
                        <br>
                        <p>posted by ' . $author_name . '</p>
                    </div>
                    <div class="col-sm-4">
                        <h3 class="pull-right">'. $row['price'] .' &#8364;</h3>
                    </div>
                </div>
            </li>
        </ul>
        </div>
        </div>
    
';
}
?>