<!--Gamepage: this is where the game will be played depending on the difficulty chosen-->
<?php
// Set the API URL
$apiUrl = "https://random-word-api.herokuapp.com/word";

// Make an HTTP request to the API
$response = file_get_contents($apiUrl);

// Check if the request was successful
if ($response !== false) {
    // Parse the JSON response
    $data = json_decode($response, true);

    // Check if the response contains the expected data
    if (is_array($data) && !empty($data)) {
        // Get the random word from the response
        $randomWord = $data[0];

        // Use the random word in your PHP code
        echo "Random word: " . $randomWord;
    } else {
        echo "Invalid response from the API.";
    }
} else {
    echo "Failed to retrieve data from the API.";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="gamepage.css" rel="stylesheet">
    </head>
    <body id="body">
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
            <div class="dash"></div>
            <div class="dash"></div>
            <div class="dash"></div>
            <div class="dash"></div>
        </div>
        <div id="alphabet-buttons">
        <?php
        $rows = [
            ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'],
            ['J', 'K', 'L', 'M', 'N', 'O', 'P'],
            ['Q', 'R', 'S', 'T', 'U'],
            ['V', 'W', 'X'],
            ['Y', 'Z']
        ];
        
        foreach ($rows as $letters) {
            echo "<div class='button-row'>";
            foreach ($letters as $letter) {
                echo "<button class='alphabet-btn'>$letter</button>";
            }
            echo "</div>";
        }
        ?>
    </div>
    </body>
</html>