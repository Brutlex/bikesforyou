<?php
session_start();
require_once 'class.user.php';

//initalize objects

$user = new USER();

//check if user is logged in, if not, simply redirect to home (can't log out if not logged in)

if(!$user->is_logged_in())
{
    $user->redirect('/');
}

//if user was logged in and clicked on log out, session is destroyed and user is redirected to home

if($user->is_logged_in()!="")
{
    $user->logout();
    $user->redirect('/');
}
?>