<?php
    /* ----------------------------------------------------------------------------------------------------------- */
    /* If a logged in user tries to visit a page with this file included, they will be redirected to the atc page. */
    /* ----------------------------------------------------------------------------------------------------------- */

    if (isset($_SESSION['LoggedIn'])) {     // Checks if user is logged.
        header('Location: /atc');           // Redirects to atc page.
    }
?>