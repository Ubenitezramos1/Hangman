<!--Leaderboard page: displays username, difficulty, level, and time and sort them-->
<!DOCTYPE html>
<html>

<head>
    <title>Leaderboard</title>
    <link href="hangman.css" rel="stylesheet">
</head>

<body>
    <h1 id="title">Leaderboard</h1>
    <div class="leaderboard">
        <div id="easyLeader">
            <h2>Easy Leaderboard</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Username</th>
                        <th>Time Score</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Read data from easyLeader.txt and sort by time score
                    $leaderboardData = file('easyLeader.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    // Sorting based on time score
                    usort($leaderboardData, function($a, $b) {
                        $timeA = explode(',', $a)[1];
                        $timeB = explode(',', $b)[1];
                        return $timeA - $timeB;
                    });
                    // Display leaderboard data
                    $rank = 1;
                    foreach ($leaderboardData as $line) {
                        list($username, $timeScore) = explode(',', $line);
                        $formattedTime = gmdate("H:i:s", $timeScore);
                        echo "<tr>
                                <td>$rank</td>
                                <td>$username</td>
                                <td>$formattedTime</td>
                            </tr>";
                        $rank++;
                    }
                ?>
                </tbody>
            </table>
        </div>
        <div id="mediumLeader">
            <h2>Medium Leaderboard</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Username</th>
                        <th>Time Score</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // Read data from easyLeader.txt and sort by time score
                    $leaderboardData = file('mediumLeader.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    // Sorting based on time score
                    usort($leaderboardData, function($a, $b) {
                        $timeA = explode(',', $a)[1];
                        $timeB = explode(',', $b)[1];
                        return $timeA - $timeB;
                    });
                    // Display leaderboard data
                    $rank = 1;
                    foreach ($leaderboardData as $line) {
                        list($username, $timeScore) = explode(',', $line);
                        $formattedTime = gmdate("H:i:s", $timeScore);
                        echo "<tr>
                                <td>$rank</td>
                                <td>$username</td>
                                <td>$formattedTime</td>
                            </tr>";
                        $rank++;
                    }
                ?>
                </tbody>
            </table>
        </div>
        <div id="hardLeader">
            <h2>Hard Leaderboard</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Username</th>
                        <th>Time Score</th>
                    </tr>
                </thead>
                <?php
                    // Read data from hardLeader.txt if the file exists
                    if (file_exists('hardLeader.txt')) {
                        $leaderboardData = file('hardLeader.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                        if ($leaderboardData !== false) {
                            // Sorting based on time score
                            usort($leaderboardData, function($a, $b) {
                                $timeA = explode(',', $a)[1];
                                $timeB = explode(',', $b)[1];
                                return $timeA - $timeB;
                            });
                            // Display leaderboard data
                            $rank = 1;
                            foreach ($leaderboardData as $line) {
                                list($username, $timeScore) = explode(',', $line);
                                $formattedTime = gmdate("H:i:s", $timeScore);
                                echo "<tr>
                                        <td>$rank</td>
                                        <td>$username</td>
                                        <td>$formattedTime</td>
                                    </tr>";
                                $rank++;
                            }
                        } else {
                            echo "<tr><td colspan='3'>Error reading hardLeader.txt</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>hardLeader.txt not found</td></tr>";
                    }
                ?>
            </table>
        </div>
    </div>
</body>

</html>