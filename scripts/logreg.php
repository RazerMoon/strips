<?php
    session_start();

    require_once "config/auth.php"; // Loads discord application detials.
    include 'logblock.php';         // Redirects if logged in.

    //echo "<pre>";
    //print_r($_SESSION);
    //echo "</pre>";

    function clean($string) {
        $string = trim($string);                                // Removes outside spaces.
        preg_replace('/[^A-Za-z0-9\-]/', '', $string);          // Removes special chars.
        $string = str_replace(' ', '', $string);                // Replaces all spaces with hyphens.
    
        return $string;
    }

    function login() {
        require_once "config/config.php";   // Database details.

        $sql = "SELECT activated FROM users WHERE discord = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $_SESSION["Discord"];
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                mysqli_stmt_bind_result($stmt, $activated);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    if (mysqli_stmt_fetch($stmt) == TRUE) {
                        if ($activated == 1) {
                            $_SESSION['LoggedIn'] = TRUE;
                            mysqli_stmt_close($stmt);
                            /* Set loggedIn to true*/
                            $sql = 'UPDATE `users` SET `loggedIn`= 1, `airport` = ?, `position` = ? WHERE `discord` = ?';
                            if($stmt = mysqli_prepare($link, $sql)){ 
                                
                                mysqli_stmt_bind_param($stmt, "sss", $_SESSION['Airport_ICAO'], mysqli_real_escape_string($link, $_SESSION["Position"]), $param_username);

                                if(mysqli_stmt_execute($stmt)){

                                    mysqli_stmt_store_result($stmt);

                                    /* If row was affected (Value changed) */
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

                            header('Location: /atc');
                        } else {
                            session_destroy();
                            header('Location: /login?error=notactivated');
                        }
                    }
                } else{
                    session_destroy();
                    header('Location: /login?error=nomatch');
                }
            } else {
                session_destroy();
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        mysqli_close($link);
    }

    function register() {
        require_once "config/config.php";   // Database details.

        $sql = "SELECT id FROM users WHERE discord = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_discord);
            
            // Set parameters
            $param_discord = mysqli_escape_string($link, $_SESSION["Discord"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $taken = true;
                    header('Location: /register?error=taken');
                } else {
                    mysqli_stmt_close($stmt);

                    $sql = "INSERT INTO users (username, discriminator, discord) VALUES (?, ?, ?)";

                    if($stmt = mysqli_prepare($link, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "sis", $param_username, $param_discriminator, $param_discord);
                        
                        // Set parameters
                        $param_username = mysqli_escape_string($link, $_SESSION['Username']);
                        $param_discriminator = $_SESSION['Discriminator'];
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            header('Location: /register?error=success');
                        } else{
                            header('Location: /register?error=error');
                        }
                    }
                }
            } else {
                header('Location: /register?error=error');
            }
        } else {
            header('Location: /register?error=error');
        }

        mysqli_stmt_close($stmt);
        session_destroy();
        mysqli_close($link);

    }

    // Exchange the access token for discord credentials.

    function getData($access_token) {
        // Open connection
        $ch = curl_init();
        
        // Set request URL and authorization type.
        curl_setopt($ch, CURLOPT_URL, AUTH_EXCHANGE_URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer {$access_token}",
            "Content-Type: application/json"
        ));
        // So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        
        // Execute post
        $jsonData = json_decode(curl_exec($ch), true);
        
        curl_close($ch);

        // Store details in session.
        $_SESSION['Discord'] = $jsonData['id'];
        $_SESSION['Username'] = clean($jsonData['username']);
        $_SESSION['Discriminator'] = $jsonData['discriminator'];

        //echo "<pre>";
        //print_r($_SESSION);
        //echo "</pre>";

        $mode = $_SESSION['Mode'];
        unset($_SESSION['Mode']);

        switch($mode) {
            case 'register':
                register();
                break;

            case 'login':
                login();
                break;

            default:
                break;
        }
    }

    if (isset($_GET['code']) && isset($_SESSION['Mode'])) {  
        // Sending application data in the POST request.
        $fields = [
            'client_id'      => AUTH_CLIENT_ID,
            'client_secret'  => AUTH_CLIENT_SECRET,
            'grant_type'     => AUTH_GRANT_TYPE,
            'code'           => $_GET['code'],
            'redirect_uri'   => AUTH_REDIRECT_URL,
            'scope'          => AUTH_SCOPE
        ];
        
        // Open connection.
        $ch = curl_init();
        
        // Set the URL, POST variables and POST data
        curl_setopt($ch, CURLOPT_URL, AUTH_TOKEN_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded'
        ));
        
        // So that curl_exec returns the contents of the cURL; rather than echoing it.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    
        // Turn result into JSON
        $jsonData = json_decode(curl_exec($ch), true);
    
        curl_close($ch);
    
        //echo "<pre>";
        //print_r($jsonData);
        //echo "<pre>";
    
        if (isset($jsonData['error'])) {                            // If the data reutrned an error.
            $error = $jsonData['error'];
        
        if ($_SESSION['Mode'] == 'login') {
            header("Location: /login?error={$error}");            // Send back to login page with an error.
        } else {
                header("Location: /register?error={$error}");       // Send back to register page with an error.
            }
        } else {
            getData($jsonData['access_token']);                     // Exchange the access token for discord credentials.
        }
    }
    elseif (isset($_GET['action'])) { 
        switch($_GET['action']) {               // If user is trying to login or register.
            case 'login':
                header(AUTH_URL);               // Redirect to auth URL.
                $_SESSION['Mode'] = 'login';    // Set session action.
                break;
            case 'register':
                header(AUTH_URL);
                $_SESSION['Mode'] = 'register';
                break;
            default:
                break;
        }
    } else {
        echo "Error, are you trying to use this page without going through login or register first?";
    }
?>