<?php
session_start();

function fetchRandomWord() {
    $apiUrl = 'https://random-word-api.vercel.app/api?words=1&length=6';

    do {
        $json = file_get_contents($apiUrl);
        $words = json_decode($json, true);

        foreach ($words as $word) {
            $vowelCount = preg_match_all('/[aeiou]/i', $word);
            if ($vowelCount >= 2) {
                return strtoupper($word);
            }
        }
    } while (true);
}

function initializeGame() {
    if (!isset($_SESSION['winCount']) || isset($_POST['resetWinCount'])) {
        $_SESSION['winCount'] = 0;
        $_SESSION['startTime'] = time();
    }

    $_SESSION['word'] = fetchRandomWord();
    $_SESSION['guessedLetters'] = [];
    $_SESSION['attemptsLeft'] = 12;
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
            $endTime = time();
            $timeScore = $endTime - $_SESSION['startTime'];
            $username = isset($_COOKIE['username']) ? $_COOKIE['username'] : 'Guest';
            $leaderData = "\n$username,$timeScore";
            file_put_contents('mediumLeader.txt', $leaderData, FILE_APPEND);
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

$attemp = 0;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Hangman Game</title>
    <link href="gamepage.css" rel="stylesheet">
</head>
<body id="body">
<?php include 'header.php'; ?>
<div class="mode">MEDIUM</div>
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
            <div class="game-message">Level Finished!</div>
            <?php if ($_SESSION['winCount'] >= 6): 
                $_SESSION['winCount'] = 0;
                $attemp = 1;?>
                <div class="game-message">Game is finished. You have won 6 times!</div>
                <a href="leaderboard.php" class="leaderboardLink">Go to Leaderboard</a>
            <?php else: ?>
                <button id="newGame" type="submit" name="newGame">Start Next Level</button>
            <?php endif; ?>
        <?php elseif ($_SESSION['gameOver']): ?>
            <div class="game-message">Game Over! The word was: <?= htmlspecialchars($_SESSION['word']) ?></div>
            <button id="newGame" type="submit" name="newGame">Retry?</button>
        <?php else: ?>
            <?= displayLetterButtons() ?>
        <?php endif; ?>
    </div>
    <?php if ($attemp == 0): ?>
    <div class="attempts">Attempts left: <?= $_SESSION['attemptsLeft'] ?></div>
    <?php endif; ?>
</form>
</body>
</html>