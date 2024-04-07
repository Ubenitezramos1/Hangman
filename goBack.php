<?php
    session_start();

    $_SESSION['winCount'] = null;
    $_SESSION['startTime'] = null;
    $_SESSION['wordIndex'] = null;
    $_SESSION['word'] = null;
    $_SESSION['guessedLetters'] = [];
    $_SESSION['attemptsLeft'] = 6;
    $_SESSION['gameOver'] = false;
    $_SESSION['gameWon'] = false;

    header("Location: gameselect.php");
    exit();
?>
