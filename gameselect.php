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
        // Check if the form is submitted
        if (isset($_POST['start_game'])) {
            // Check if the difficulty is selected
            if (!empty($_POST['difficulty'])) {
                // Redirect to the corresponding difficulty page
                $difficulty = $_POST['difficulty'];
                $pageName = "gamepage{$difficulty}Alpha.php";
                if (file_exists($pageName)) {
                    header("Location: $pageName");
                    exit;
                } else {
                    // Display error message if corresponding difficulty page not found
                    echo '<div class="error">Error: Difficulty page not found.</div>';
                }
            } else {
                // Display error message if difficulty is not selected
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