<?php
    
    /* ------------------------------------- */
    /* Attempt to connect to MySQL database. */
    /* ------------------------------------- */
    
    $mysqli = @new mysqli('localhost', 'root', '', 'strips'); // Supressing the warning because too lazy to disable all php errors and create own handler.
    
    /* ----------------- */
    /* Check connection. */
    /* ----------------- */
    
    if($mysqli === false){
        header("Location: /?error=db");                             // Send to homepage with error
        die("ERROR: Could not connect. " . $mysqli->connect_error); 
    }
?>