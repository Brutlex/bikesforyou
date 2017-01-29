<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
    $user_home->redirect('index');
}

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userId=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php require_once 'tags/header.php'; ?>

    <title>Profile</title>

</head>
<body id="members">
<?php include_once("analyticstracking.php") ?>
<div>
    <?php require_once 'tags/navmembers.php'; ?>
</div>
</body>
</html>