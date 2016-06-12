<?php
// Random image

require_once("includes/header.php");
require_once("includes/menu.php");
require_once("classes/User.php");
require_once("classes/Database.php");
require_once("classes/Image.php");

echo '<div class="panel">';
echo '<h1>Random image</h1>';
echo '</div>';

$db = new Database();
$users = $db->getAllUsers();
if (count($users) > 0)
{
    // get random user with at least 1 image
    $nb_imgs = 0;
    while ($nb_imgs == 0)
    {
        $rand = array_rand($users);
        $random_username = $users[$rand]->login;
        $user = new User($random_username);
        $nb_imgs = $user->getImages()->getNumberImages();
    }

    $rand = rand(0, $user->getImages()->getNumberImages() - 1);
    $img = $user->getImages();
    $img->setIteratorIndex($rand);
    $image = new Image($img, $user->getImagesPath());
    $image->show();
}

require_once("includes/footer.php");
?>
