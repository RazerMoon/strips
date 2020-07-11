<?php
    /* ---------------------------------------------------------- */
    /* This script destroys the user's session, logging them out. */
    /* ---------------------------------------------------------- */

    session_start();        // Starts the session.

    if (isset($_SESSION['Discord'])) {
        require_once "config/config.php";   // Database details.
        
        if ($stmt = $mysqli->prepare("UPDATE users SET loggedIn = 0, airport='', position='' WHERE discord = ?")){

            $stmt->bind_param("s", $param_username);
            $param_username = $_SESSION['Discord'];

            if($stmt->execute()){

                $stmt->store_result();

                if($stmt->affected_rows == 1){
                    //echo "Success";
                } else {
                    //echo "Fail";
                    //print_r($stmt);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        $stmt->close();
        $mysqli->close();
    }

    session_destroy();      // Destroys the session.

    header('Location: /')   // Redirects to homepage.
?> 