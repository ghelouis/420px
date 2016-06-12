<?php
// Upload a user's image and resize it to 420px (keeping the ratio)

session_start();
require_once('../classes/Database.php');

$uploaddir = '../images/'.$_SESSION['username'].'/';
$imageName = $_FILES['userfile']['name'];
$uploadfile = $uploaddir.basename($imageName);

$image_extensions_allowed = array('jpg', 'jpeg', 'png', 'bmp');
$ext = strtolower(substr(strrchr($imageName, "."), 1));

if (file_exists($uploadfile))
{
    $_SESSION['error'] = 'file already exists';

}
elseif(!in_array($ext, $image_extensions_allowed))
{
    $_SESSION['error'] = 'file upload failed (invalid format)';
}
elseif (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
{
    $_SESSION['upload_success'] = $_FILES['userfile']['name'];
    $image = new Imagick($uploadfile);
    $image->thumbnailImage(420, 0);
    $image->writeImage();

    $username = $_SESSION['username'];
    $db = new Database();
    $db->addImage($username, $imageName);
}
else
{
    $_SESSION['error'] = 'file upload failed (might be too big)';
}

header("Location: http://localhost:8000/index.php");
