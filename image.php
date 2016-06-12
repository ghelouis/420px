<?php
// Single image: delete / apply filter / manage tags

require_once("includes/header.php");
require_once("includes/menu.php");
require_once("classes/User.php");

if (isset($_SESSION['username']) && isset($_GET['image']))
{
    $username = $_SESSION['username'];
    $image = htmlspecialchars($_GET['image']);
    echo '<div class="panel">';
    echo '<h1>'.$image.'</h1>';
    echo '</div>';

    $user = new User($username);

    if (!$user->hasImage($image))
    {
        header("Location: http://localhost:8000/index.php");
    }

    // apply filter
    if (isset($_POST['imageToFilter']) && isset($_POST['selectFilter']))
    {
        $image = htmlspecialchars($_POST['imageToFilter']);
        $filter = htmlspecialchars($_POST['selectFilter']);
        $user->applyFilter($image, $filter);
    }

    // associate with tag
    if (isset($_POST['selectTag']))
    {
        $tag = $_POST['selectTag'];
        $db = new Database();
        $db->associateTagWithImage($tag, $image);
    }

    $img = $user->getImage($image);
    $img->show();

    // Apply filter
    echo '<div class="large-3 columns left">';
    echo '<form action="image.php?image='.$image.'" method="post">';
    echo '<input type="hidden" name="imageToFilter" value="'.$image.'" />';
    echo '<select name="selectFilter">';
    foreach ($img->getFilters() as $filter)
    {
        echo "<option value=\"$filter\">$filter</option>";
    }
    echo '</select>';
    echo '<input type="submit" class="button radius tiny" value="Apply filter" />';
    echo '</form>';

    // Delete
    echo '<form action="images.php" method="post">';
    echo '<input type="hidden" name="imageToDelete" value="'.$image.'" />';
    echo '<input type="submit" class="button radius tiny alert" value="Delete image" />';
    echo '</form>';
    echo '</div>';
?>

<!-- Current tags -->
<div class="row">
    <div class="row large-6">
            <div class="large-6 columns">
            <p>
                Tags<br/>
                <?php
                $db = new Database();
                $tags = $db->getTagsForImage($image);
                foreach ($tags as $tag)
                {
                    echo '<span class="label">'.$tag->name.'</span> ';
                }
                ?>
            </p>
            </div>
        </div>
</div>

<!-- Add tag to image -->
<form action="image.php?image=<?php echo $image; ?>" method="post">
    <div class="row">
        <div class="small-6">
            <div class="row">
                <div class="small-3 columns">
                    <label class="right inline">Tag</label>
                </div>
                <div class="small-3 columns">
                    <select name="selectTag">
                    <?php
                    $db = new Database();
                    $tags = $db->getAllTags();
                    foreach ($tags as $tag)
                    {
                        $name = $tag->name;
                        echo "<option value=\"$name\">$name</option>";
                    }
                    ?>
                    </select>
                </div>
                <input type="submit" class="button radius tiny" value="Add to image" />
            </div>
        </div>
    </div>
</form>

<!-- Create new tag -->
<form action="actions/add-tag.php" method="post">
    <div class="row">
        <div class="small-6">
            <div class="row">
                <div class="small-3 columns">
                    <label for="tagInput" class="right inline">Create new tag</label>
                </div>
                <div class="small-2 columns">
                    <input type="hidden" name="imageName" value="<?php echo $image; ?>" />
                    <input id="tagInput" type="text" name="tag" />
                </div>
                <input type="submit" class="button radius tiny" value="Save" />
            </div>
        </div>
    </div>
</form>

<?php
}
// Not logged in: redirect to home
else
{
    header("Location: http://localhost:8000/index.php");
}
require_once("includes/footer.php");
?>
