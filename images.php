<?php
require_once("includes/header.php");
require_once("includes/menu.php");
require_once("classes/User.php");
require_once("classes/Database.php");

$tag = null;

// Images of a specific user
if (isset($_POST['selectUser']))
{
    $username = htmlspecialchars($_POST['selectUser']);
    echo '<div class="panel">';
    echo "<h1>$username's images</h1>";
    echo '</div>';
    echo '<form action="images_rss.php" method="post">';
    echo '<input type="hidden" name="username" value="'.$username.'" />';
    echo '<input type="submit" class="tiny button radius" value="Rss feed"/>';
    echo '</form>';
}
// Images with a specific tag
elseif (isset($_POST['tag']) && $_POST['tag'] != '')
{
    $tag = htmlspecialchars($_POST['tag']);
    echo '<div class="panel">';
    echo '<h1>Images with tag '.$tag.'</h1>';
    echo '</div>';
}
// Logged in user images
elseif (isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    echo '<div class="panel">';
    echo '<h1>My images</h1>';
    echo '</div>';
    echo '<form action="images.php" method="post">';
    echo '<input type="hidden" name="makeGif" value="true" >';
    echo '<input type="submit" class="tiny button radius" value="Make gif" />';
    echo '</form>';
}
// Redirect to home
else
{
    header("Location: http://localhost:8000/index.php");
}

if ($tag != null)
{
    $db = new Database();
    $imagesArray = $db->getImagesForTag($tag);
    foreach ($imagesArray as $i)
    {
        $path = 'images/'.$i->login.'/';
        $img = new Image(new Imagick($path.$i->name), $path);
        $img->show();
    }
}
else
{
    $user = new User($username);
    if (isset($_POST['imageToDelete']))
    {
        $image = htmlspecialchars($_POST['imageToDelete']);
        $user->deleteImage($image);
    }
    if (isset($_POST['makeGif']))
        $user->displayImagesGif();
    $user->displayImages();
}

require_once("includes/footer.php");
?>
