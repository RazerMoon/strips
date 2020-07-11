<?php
    /* ---------------------------------------------------------------------------------------------------------------------*/
    /* Used to check what is stored in your PHP session, REMOVE THIS SCRIPT IF ACTUALLY PLANNING ON USING THE STRIPS SYSTEM */
    /* ---------------------------------------------------------------------------------------------------------------------*/

    /* classes included to prevent __PHP_Incomplete_Class error */
    include __DIR__.'/classes/Validate.php';
    include __DIR__.'/classes/AirInfo.php';
    include __DIR__.'/classes/Plan.php';

    session_start();    // Start the session.

    echo "<pre>";       // Nicer Formatting
    print_r($_SESSION); // Display everything stored in session.
    echo "</pre>";      // Nicer Formatting
?>