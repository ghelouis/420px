<?php
require_once("classes/User.php");
require_once("classes/Database.php");

$db = new Database();

if (!isset($_POST['username']) || !$db->findUser($_POST['username']))
{
    header("Location: http://localhost:8000/index.php");
}
$username = $_POST['username'];

header("Content-Type: application/xml; charset=ISO-8859-1");

echo '<?xml version="1.0" encoding="UTF-8" ?>';
echo '<rss version="2.0">';
echo '<channel>';
echo "<title>$username's images</title>";
echo '<link>http://localhost:8000/images_rss.php</link>';
echo '<language>en</language>';

$user = new User($username);
$images = $user->getImages();
$path = $user->getImagesPath();
if ($images->getNumberImages() != 0)
{
    foreach ($images as $image)
    {
        $name = basename($image->getImageFilename());
        $link = $path.$name;
        $img = '<img src="'.$link.'" alt="'.$name.'">';
        echo '<item>';
        echo "<title>$name</title>";
        echo "<link>$link</link>";
        echo "<description><![CDATA['$img']]></description>";
        echo '</item>';
    }
}
echo '</channel>';
echo '</rss>';
?>
