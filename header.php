<?php
    session_start();

    $currentPage = basename($_SERVER['PHP_SELF']);

    if (isset($_COOKIE['username'])) {
        $loggedInUser = $_COOKIE['username'];
    } else {
        $loggedInUser = null;
    }
?>
<div id="header">
    <?php if ($currentPage !== 'gameselect.php') { ?>
    <div id="goBack">
            <a href="goBack.php">
                <span>Go Back</span>
            </a>
    </div>
    <?php } ?>

    <div id="logout">
        <?php if ($loggedInUser) { ?>
            <a href="logout.php">
                <span>Logout from <?php echo $loggedInUser; ?></span>
            </a>
        <?php } else { ?>
            <a href="login.php">Login</a>
        <?php } ?>
    </div>
</div>