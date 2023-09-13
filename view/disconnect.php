<?php 
    require_once('../UserController.php');

    session_start();

    if(!isset($_SESSION['user'])){
        header('location: index.php');
    }

    $user = new UserController();
    $user->disConnect();
?>