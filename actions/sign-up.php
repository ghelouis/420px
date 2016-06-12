<?php
// Sign up and redirect to sign-up.php

session_start();
require_once("../classes/Database.php");
require_once("../classes/User.php");

if (isset($_POST['username']) && isset($_POST['pwd']))
{
    $username = trim(htmlspecialchars($_POST['username']));
    $pwd = trim(htmlspecialchars($_POST['pwd']));
    if ($username === '')
    {
        $_SESSION['error'] = "empty user name";
    }
    elseif ($pwd === '')
    {
        $_SESSION['error'] = "empty password";
    }
    else
    {
        try {
            $db = new Database();
            $db->createUser($username, $pwd);
            mkdir('../images/'.$username);
            $_SESSION['username'] = $username;
        } catch (Exception $e) {
            $_SESSION['error'] = "username already in use";
        }
    }
}

header("Location: http://localhost:8000/sign-up.php");
?>
