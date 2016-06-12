<?php
// Sign in and redirect to log-in.php

session_start();
require_once("../classes/Database.php");
require_once("../classes/User.php");

if (isset($_POST['username']) && isset($_POST['pwd']))
{

    $username = trim(htmlspecialchars($_POST['username']));
    $pwd = trim(htmlspecialchars($_POST['pwd']));

    $wrong_attempts = $_SESSION['WrongAttempts'];
    if (array_key_exists($username, $wrong_attempts) && $wrong_attempts[$username] > 2)
    {
        $_SESSION['error'] = "Too many wrong attempts";
    }
    else if ($username === '')
    {
        $_SESSION['error'] = "Empty username";
    }
    elseif ($pwd === '')
    {
        $_SESSION['error'] = "Empty password";
    }
    else
    {
        try
        {
            $db = new Database();
            if ($db->matchUserPwd($username, $pwd))
            {
                $_SESSION['username'] = $username;
            }
            else
            {
                $_SESSION['error'] = "Invalid username or password";
                $_SESSION['badUsername'] = $username;
            }
        }
            catch (Exception $e) {
                $_SESSION['error'] = "Log in failure";
        }
    }
}

header("Location: http://localhost:8000/log-in.php");
?>
