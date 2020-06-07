<?php
    /* ---------------------------------- */
    /* Function used to sanitize strings. */
    /* ---------------------------------- */
    
    function clean($string) {
        $string = trim($string);                                // Removes outside spaces.
        $string = str_replace(' ', '', $string);                // Replaces all spaces with hyphens.
    
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);   // Removes special chars.
    }
    
    /* ------------------------------------------------------------------------------------------------------------------------------------------------ */
    /* Database credentials. Assuming you are running MySQL server with default setting (user 'root' with no password). Check out README for structure. */
    /* ------------------------------------------------------------------------------------------------------------------------------------------------ */
    
    define('DB_SERVER', 'localhost');   // Database server.
    define('DB_USERNAME', 'root');      // Username.
    define('DB_PASSWORD', '');          // Password.
    define('DB_NAME', 'strips');        // Database name.
    
    /* ------------------------------------- */
    /* Attempt to connect to MySQL database. */
    /* ------------------------------------- */
    
    $link = @mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); // Supressing the warning because too lazy to disable all php errors and create own handler.
    
    /* ----------------- */
    /* Check connection. */
    /* ----------------- */
    
    if($link === false){
        header("Location: /?error=db");                             // Send to homepage with error
        die("ERROR: Could not connect. " . mysqli_connect_error()); 
    }
?>