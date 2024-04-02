<!--Login page-->
<!DOCTYPE html>
<html>
    <head>
        <title>Hangman Login Page</title>
        <link href="hangman.css" rel="stylesheet">
    </head>
    <body>
        <?php
            session_start();

            $username = $_POST['username'];
            $password = $_POST['password'];
            $file_path = "users.txt";

            if (isset($_POST['username']) && isset($_POST['password'])){

                if(!userCheck($username, $password, $file_path)){
                    $failed = true;
                }else{
                    header("Location: gamepage.html");
                    exit();
                }
            }

            function userCheck($username, $password, $file_path){
                $file_contents = file_get_contents($file_path);
                $lines = explode("\n", $file_contents);

                foreach ($lines as $line) {
                    $data = explode(",", $line);
                    //checks if user exists
                    if (isset($data[0]) && strtolower(trim($data[0])) === strtolower(trim($username))) {
                        //checks if passwords match
                        if(isset($data[1]) && $data[1] === $password) {
                            return true;
                        }
                    }
                }

                return false;
            }

        ?>
        <h1 id="title">Web Wizard's Hangman</h1>
        
        <div id="content">
            <legend>Login</legend>
            <form method="post">
                <?php
                    if (isset($failed) && $failed == true) { 
                        echo '<div class="loginError">Invalid Username or Password</div>';
                    }
                ?>
                <div id="inputBox">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div id="inputBox">
                    <input type="password" name="password" placeholder="Password" required>
                </div>   
                <div id="links">             
                    <a href="signup.php">Signup?</a>
                    <input type="submit" value="Login">
                </div>
            </form>
        </div>
    </body>
</html>