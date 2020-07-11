<?php
    /* ----------------------------------------------------------------------------------------------------------- */
    /* If a logged in user tries to visit a page with this file included, they will be redirected to the atc page. */
    /* ----------------------------------------------------------------------------------------------------------- */

    if (isset($_SESSION['LoggedIn'])) {     // Checks if user is logged in.
        header('Location: /atc');           // Redirects to atc page.
    } elseif (isset($_SESSION['PlanID'])) { // Checks if user has a currently active plan.
        header('Location: /plan');           // Redirects to plan page.
    }
?>