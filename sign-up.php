<?php
require_once("includes/header.php");
require_once("includes/menu.php");

if (!isset($_SESSION['username']))
{
?>

<form name="sign-up" method="post" action="actions/sign-up.php">
    <fieldset>
    <legend>Sign up</legend>
    <div class="row">
        <div class="small-4 columns">
            <label>Username</label>
            <input type="text" name="username"/>
            <label>Password</label>
            <input type="text" name="pwd"/>
            <?php
            if (isset($_SESSION['error']))
            {
                echo '<small class="error">'.$_SESSION['error'].'</small>';
                unset($_SESSION['error']);
            }
            ?>
        </div>
    </div>
    <input type="submit" class="button radius tiny" name="validate" value="OK"/>
</form>

<?php
}
else
{
    header("Location: http://localhost:8000/index.php");
}

require_once("includes/footer.php");
?>
