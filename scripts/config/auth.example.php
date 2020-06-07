<?php
    /* -----------------------------------------------------------------------------------------------------------------------------*/
    /* RENAME THIS FILE TO auth.php AFTER ENTERING YOUR DISCORD APPLICATION DETAILS.                                                */
    /* This file must contain the details of your discord application, make sure it includes the same scopes as the credentials do. */
    /* -----------------------------------------------------------------------------------------------------------------------------*/

    define('AUTH_CLIENT_ID', '');                                                   // Client ID.
    define('AUTH_CLIENT_SECRET', '');                                               // Client secret.
    define('AUTH_GRANT_TYPE', '');                                                  // Grant type.
    define('AUTH_REDIRECT_URL', 'http://localhost/scripts/logreg.php');             // The URL that ouath redirects to - DONT CHANGE THIS.
    define('AUTH_SCOPE', 'identify');                                               // Scopes - YOU AT LEAST NEED IDENTIFY.
    define('AUTH_TOKEN_URL', 'https://discordapp.com/api/oauth2/token');            // Token URL - DONT CHANGE THIS.
    define('AUTH_EXCHANGE_URL', 'https://discordapp.com/api/v7/users/@me');         // Token exchange URL - DONT CHANGE THIS.
    define('AUTH_URL', 'Location: https://discordapp.com/api/oauth2/authorize?');   // Authentication URL.
?>
