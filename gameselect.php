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
        <p class="instructions"><span class="bold">Instructions:</span><br>Choose a difficulty mode. <span class="bold">Easy</span> will have 
        <span class="bold">4</span> letter words, <span class="bold">Medium</span> will have <span class="bold">6</span>, and <span class="bold">Hard</span> will have <span class="bold">8</span>. 
        You will have <span class="bold">12</span> attempts to guess a word correctly. To be scored on the leaderboard, you will have to win a total of <span class="bold">6</span> times. 
        <span class="bold">Hint:</span> You are scored by the amount of time it takes for you to complete all <span class="bold">6 wins</span>. 
        Don't worry if you miss a word. Missed words will not reset your win count. The clock is still ticking, so keep guessing!</p>

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