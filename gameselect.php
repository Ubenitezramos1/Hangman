<!--Game selection page: user can select a difficulty and start the game-->
<!DOCTYPE html>
<html>

<head>
    <title>Game Select Page</title>
    <link href="hangman.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <img src="hangman.png" alt="Swinging Image" class="swinging-image">
        <h1 id="title">Web Wizard's Hangman</h1>
        <div id="selectMode">
        <h2>Select Difficulty Mode</h2>

        <?php
        if (isset($_POST['start_game'])) {
            if (!empty($_POST['difficulty'])) {
                $difficulty = $_POST['difficulty'];
                $pageName = "gamepage{$difficulty}.php";
                if (file_exists($pageName)) {
                    header("Location: $pageName");
                    exit;
                } else {
                    echo '<div class="error">Error: Difficulty page not found.</div>';
                }
            } else {
                echo '<div class="error">Please select a difficulty.</div>';
            }
        }
        ?>

        <form method="post" action="">

            <select name="difficulty" class="difficulty">
                <option value="Easy">Easy</option>
                <option value="Medium">Medium</option>
                <option value="Hard">Hard</option>
            </select>
            <button type="submit" name="start_game" class="start-button">Start Game</button>
        </form>
        <a href="leaderboard.php" class="leaderboardLink">Leaderboard Page</a>
    </div>

</body>

</html>