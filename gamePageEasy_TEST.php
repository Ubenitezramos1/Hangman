<?php
session_start();

// Set the API URL
$apiUrl = "https://random-word-api.herokuapp.com/word";
$response = file_get_contents($apiUrl);

// Check if the request was successful
if ($response !== false) {
    // Parse the JSON response
    $data = json_decode($response, true);

    // Check if the response contains the expected data
    if (is_array($data) && !empty($data)) {
        // Get the random word from the response
        $word = strtoupper($data[0]);
        $word_length = strlen($word);

        // Store the word in session to track it throughout the game
        $_SESSION['word'] = $word;

        // Initialize blank spaces based on word length
        $blank_spaces = str_repeat("_", $word_length);
    } else {
        echo "Invalid response from the API.";
        exit; // Exit if response is invalid
    }
} else {
    echo "Failed to retrieve data from the API.";
    exit; // Exit if request fails
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guess = strtoupper($_POST["guess"]);

    // Check if the guessed letter is in the word
    if (strpos($word, $guess) !== false) {
        // Update blank spaces with guessed letter
        for ($i = 0; $i < strlen($word); $i++) {
            if ($word[$i] == $guess) {
                $blank_spaces[$i] = $guess;
            }
        }
    } else {
        // Implement logic to handle incorrect guess
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hangman Game</title>
    <link href="gamepage.css" rel="stylesheet">
</head>
<body>
<div id="hangman">
    <div class="gallows-top"></div>
    <div class="gallows-stand"></div>
    <div class="rope"></div>
    <div class="head"></div>
    <div class="body"></div>
    <div class="arm left-arm"></div>
    <div class="arm right-arm"></div>
    <div class="leg left-leg"></div>
    <div class="leg right-leg"></div>
</div>
<div id="dashes">
    <?php
    // Display the blank spaces
    foreach (str_split($blank_spaces) as $char) {
        echo "<div class='dash'>$char</div>";
    }
    ?>
</div>
<div id="alphabet-buttons">
    <?php
    // Display the alphabet buttons
    foreach (range('A', 'Z') as $letter) {
        echo "<button class='alphabet-btn' name='guess' value='$letter'>$letter</button>";
    }
    ?>
</div>
</body>
</html>