<?php
    session_start();

    // Check if the user is logged in
    if (isset($_COOKIE['username'])) {
        $loggedInUser = $_COOKIE['username'];
    } else {
        $loggedInUser = null;
    }
?>

<div id="logoutHeader">
    <?php if ($loggedInUser) { ?>
        <a href="logout.php">
            <span>Logout from <?php echo $loggedInUser; ?></span>
        </a>
    <?php } else { ?>
        <a href="login.php">Login</a>
    <?php } ?>
</div>