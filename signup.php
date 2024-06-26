<?php
session_start();

if (isset($_COOKIE['username'])) {
    header("Location: gameselect.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $file_path = "users.txt";
        $file_contents = file_get_contents($file_path);
        $lines = explode("\n", $file_contents);
        $found = false;
        foreach ($lines as $line) {
            $data = explode(",", $line);
            if (strtolower(trim($data[0])) === strtolower(trim($username))) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $file_contents .= "\n" . $username . "," . $password;
            file_put_contents($file_path, $file_contents);
            setcookie("username", $username, time() + (86400 * 30), "/");
            header("Location: gameselect.php");
            exit();
        } else {
            $error = "Username already exists.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hangman Signup Page</title>
    <link href="hangman.css" rel="stylesheet">
</head>
<body>
    <img src="hangman.png" alt="Swinging Image" class="swinging-image">
    <h1 id="title">Web Wizard's Hangman</h1>
    <div id="content">
        <legend>Signup</legend>
        <form method="post">
            <?php if (isset($error)) { echo '<div class="error">' . $error . '</div>'; } ?>
            <div id="inputBox">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div id="inputBox">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div id="inputBox">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <div id="links">
                <a href="login.php">Login?</a>
                <input type="submit" value="Signup">
            </div>
        </form>
    </div>
</body>
</html>