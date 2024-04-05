<?php
    session_start();
    // Destroy the session and remove the cookie
    session_destroy();
    setcookie("username", "", time() - 3600, "/");
    header("Location: login.php");
    exit();
?>