<?php
require_once("includes/header.php");
require_once("includes/menu.php");

if (!isset($_SESSION['username']))
{
?>

<form name="sign-in" method="post" action="actions/sign-in.php">
    <fieldset>
    <legend>Log in</legend>
    <div class="row">
        <div class="small-4 columns">
            <label>Username</label>
            <input type="text" name="username"/>
            <label>Password</label>
            <input type="text" name="pwd"/>
            <?php
            if (isset($_SESSION['error']))
            {
                $bad_username = $_SESSION['badUsername'];
                unset($_SESSION['badUsername']);
                $wrong_attempts = $_SESSION['WrongAttempts'];
                if (array_key_exists($bad_username, $wrong_attempts))
                {
                    $wrong_attempts[$bad_username] = $wrong_attempts[$bad_username] + 1;
                    $attempt_nb = $wrong_attempts[$bad_username];
                }
                else
                {
                    $wrong_attempts[$bad_username] = 1;
                    $attempt_nb = 1;
                }
                $_SESSION['WrongAttempts'] = $wrong_attempts;

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