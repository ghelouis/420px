<?php
require_once("includes/header.php");
require_once("includes/menu.php");

/*
 * Author: heloui_g
 */
?>

<!-- View images by user -->
<form action="images.php" method="post">
    <fieldset>
    <legend>View images by user</legend>
    <div class="row">
        <div class="small-6">
            <div class="row">
                <div class="small-3 columns">
                    <label class="right inline">User</label>
                </div>
                <div class="small-3 columns">
                    <select name="selectUser">
                    <?php
                    $db = new Database();
                    $users = $db->getAllUsers();
                    foreach ($users as $user)
                    {
                        $name = $user->login;
                        echo "<option value=\"$name\">$name</option>";
                    }
                    ?>
                    </select>
                </div>
                <input type="submit" class="button radius tiny" value="Show images" />
            </div>
        </div>
    </div>
    </fieldset>
</form>

<?php
if (isset($_SESSION['username']))
{
?>
    <!-- Upload image -->
<form enctype="multipart/form-data" action="actions/upload_file.php" method="POST">
    <fieldset>
    <legend>Import an image</legend>
    <div class="row">
        <div class="small-6">
            <div class="row">
                <div class="small-8 columns">
                    <input id="uploadImage" name="userfile" type="file" />
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                </div>
            </div>
            <input type="submit" class="button radius tiny" value="Submit" />
        </div>
    </div>
    </fieldset>
</form>

<!-- Success / error notifications -->
<?php
    if (isset($_SESSION['upload_success']))
    {
        $file = $_SESSION['upload_success'];
        echo '<div data-alert class="alert-box success radius">';
        echo "File $file successfully uploaded.";
        echo '</div>';
        unset($_SESSION['upload_success']);
    }

    if (isset($_SESSION['error']))
    {
        $error = $_SESSION['error'];
        echo '<div data-alert class="alert-box alert radius">';
        echo "Error: $error.";
        echo '</div>';
        unset($_SESSION['error']);
    }
}
?>

<?php
require_once("includes/footer.php");
?>
