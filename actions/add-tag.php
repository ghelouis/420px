<?php
// Add a tag to the database

session_start();
require_once("../classes/Database.php");

if (isset($_POST['tag']) && isset($_POST['imageName']))
{
    $image = htmlspecialchars($_POST['imageName']);
    $tag = htmlspecialchars($_POST['tag']);
    $db = new Database();
    $db->addTag($tag);

    header("Location: http://localhost:8000/image.php?image=$image");
}
else
{
    header("Location: http://localhost:8000/index.php");
}
