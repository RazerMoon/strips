<?php
    /* ---------------------------------------------------------- */
    /* This script destroys the user's session, logging them out. */
    /* ---------------------------------------------------------- */

    require_once "config/config.php";   // Database details.

    session_start();        // Starts the session.

    $sql = "UPDATE `users` SET `loggedIn`= 0, `airport`='', `position`='' WHERE `discord` = ?";

    if($stmt = mysqli_prepare($link, $sql)){

        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $_SESSION['Discord'];

        if(mysqli_stmt_execute($stmt)){

            mysqli_stmt_store_result($stmt);

            if(mysqli_stmt_affected_rows($stmt) == 1){
                //echo "Success";
            } else {
                //echo "Fail";
                //print_r($stmt);
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($link);

    session_destroy();      // Destroys the session.

    header('Location: /')   // Redirects to homepage.
?> 