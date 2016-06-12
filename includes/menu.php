<?php
    require_once('classes/Database.php');
?>

<nav class="top-bar" data-topbar role="navigation">
    <ul class="title-area">
        <li class="name">
            <h1><a href="index.php">420px</a></h1>
        </li>
    </ul>

    <!-- Right: Log in, Sign up or Log out -->
    <section class="top-bar-section">
        <ul class="right">
            <?php
            if (isset($_SESSION['username']))
            {
                echo '<li><a href="">Logged in as <strong>'.$_SESSION['username'].'</strong></a></li>';
                echo '<li class="has-form">';
                echo '<a href="actions/logout.php" class="button">Logout</a>';
                echo '</li>';
            }
            else
            {
            ?>
            <li><a href="log-in.php">Log in</a></li>
            <li><a href="sign-up.php">Sign up</a></li>
            <?php
            }
            ?>
        </ul>

        <!-- Left: My images (if logged in), Random image, Search -->
        <ul class="left">
            <?php
            if (isset($_SESSION['username']))
            {
                echo '<li><a href="images.php">My images</a></li>';
            }
            ?>

            <li><a href="random.php">Random image</a></li>

            <li class="has-form">
                <div class="row collapse">
                    <form action="images.php" method="post">
                        <div class="large-8 small-9 columns">
                            <input type="text" name="tag" placeholder="Write a tag">
                        </div>
                        <div class="large-4 small-3 columns">
                            <input type="submit" class="alert button expand" value="Search" />
                        </div>
                    </form>
                </div>
            </li>
        </ul>
    </section>
</nav>

<div class="row">
    <div class="large-12 columns">
