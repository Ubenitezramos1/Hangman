<?php
session_start();

function initializeGame() {
    $selectedWords = ["DISCOVERY", "ELEPHANT", "MOLECULE", "BUTTERFLY", "COMPUTER", "TELEPHONE"]; // Your selected words

    if (!isset($_SESSION['winCount']) || isset($_POST['resetWinCount'])) {
        $_SESSION['winCount'] = 0;
        $_SESSION['startTime'] = time(); // Start the timer when the first game starts
    }

    if (!isset($_SESSION['wordIndex'])) {
        $_SESSION['wordIndex'] = 0;
    } else {
        $_SESSION['wordIndex'] = ($_SESSION['wordIndex'] + 1) % count($selectedWords);
    }

    $_SESSION['word'] = strtoupper($selectedWords[$_SESSION['wordIndex']]);
    $_SESSION['guessedLetters'] = [];
    $_SESSION['attemptsLeft'] = 6;
    $_SESSION['gameOver'] = false;
    $_SESSION['gameWon'] = false;
}

if (!isset($_SESSION['word']) || isset($_POST['newGame'])) {
    initializeGame();
}

if (isset($_POST['guess']) && !$_SESSION['gameOver']) {
    $guess = strtoupper($_POST['guess']);
    if (!in_array($guess, $_SESSION['guessedLetters'])) {
        $_SESSION['guessedLetters'][] = $guess;
        if (strpos($_SESSION['word'], $guess) === false) {
            --$_SESSION['attemptsLeft'];
        }
    }

    $_SESSION['gameOver'] = $_SESSION['attemptsLeft'] <= 0;
    if (!$_SESSION['gameOver'] && !in_array('_', str_split(getDisplayedWord()))) {
        $_SESSION['gameWon'] = true;
        $_SESSION['winCount']++;
        if ($_SESSION['winCount'] >= 6) {
            // Stop the timer when all six wins are completed
            $endTime = time();
            $timeScore = $endTime - $_SESSION['startTime']; // Calculate time score
            // Store username and time score in easyLeader.txt
            $username = isset($_COOKIE['username']) ? $_COOKIE['username'] : 'Guest';
            $leaderData = "$username,$timeScore\n";
            file_put_contents('easyLeader.txt', $leaderData, FILE_APPEND);
        }
    }
}

function getDisplayedWord() {
    $display = '';
    foreach (str_split($_SESSION['word']) as $char) {
        $display .= in_array($char, $_SESSION['guessedLetters']) ? $char : '_';
        $display .= ' ';
    }
    return trim($display);
}

function displayLetterButtons() {
    $alphabet = range('A', 'Z');
    echo "<div class='button-row'>";
    foreach ($alphabet as $letter) {
        if (in_array($letter, $_SESSION['guessedLetters'])) {
            echo "<button disabled class='alphabet-btn guessed'>$letter</button>";
        } else {
            echo "<button type='submit' name='guess' value='$letter' class='alphabet-btn'>$letter</button>";
        }
    }
    echo "</div>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hangman Game</title>
    <link href="gamepage.css" rel="stylesheet">
</head>
<body id="body">
<?php include 'header.php'; ?>
<div id="hangman">
    <div class="gallows-top"></div>
    <div class="gallows-stand"></div>
    <div class="rope"></div>
    <div class="head" style="<?= $_SESSION['attemptsLeft'] < 1 ? 'display: none;' : '' ?>"></div>
    <div class="body" style="<?= $_SESSION['attemptsLeft'] < 2 ? 'display: none;' : '' ?>"></div>
    <div class="arm right-arm" style="<?= $_SESSION['attemptsLeft'] < 3 ? 'display: none;' : '' ?>"></div>
    <div class="arm left-arm" style="<?= $_SESSION['attemptsLeft'] < 4 ? 'display: none;' : '' ?>"></div>
    <div class="leg left-leg" style="<?= $_SESSION['attemptsLeft'] < 5 ? 'display: none;' : '' ?>"></div>
    <div class="leg right-leg" style="<?= $_SESSION['attemptsLeft'] < 6 ? 'display: none;' : '' ?>"></div>
</div>
<form method="post">
    <div id="dashes">
        <?= getDisplayedWord() ?>
    </div>
    <div id="alphabet-buttons">
        <?php if ($_SESSION['gameWon']): ?>
            <div>Game Finished!</div>
            <?php if ($_SESSION['winCount'] >= 6): 
                //reset the win count
                $_SESSION['winCount'] = 0;
            ?>
                <div>Exit now. You have won 6 times!</div>
                <a href="leaderboard.php" class="button">Go to Leaderboard</a>
            <?php else: ?>
                <button type="submit" name="newGame">Start New Game</button>
            <?php endif; ?>
        <?php elseif ($_SESSION['gameOver']): ?>
            <div>Game Over! The word was: <?= htmlspecialchars($_SESSION['word']) ?></div>
            <button type="submit" name="newGame">Start New Game</button>
        <?php else: ?>
            <?= displayLetterButtons() ?>
        <?php endif; ?>
    </div>
    <div>Attempts left: <?= $_SESSION['attemptsLeft'] ?></div>
</form>
</body>
</html>