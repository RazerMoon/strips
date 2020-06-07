<?php
    /* ---------------------------------------------------------------------------------------------------------------------*/
    /* Used to check what is stored in your PHP session, REMOVE THIS SCRIPT IF ACTUALLY PLANNING ON USING THE STRIPS SYSTEM */
    /* ---------------------------------------------------------------------------------------------------------------------*/

    session_start();    // Start the session.

    echo "<pre>";       // Nicer Formatting
    print_r($_SESSION); // Display everything stored in session.
    echo "</pre>";      // Nicer Formatting
?>