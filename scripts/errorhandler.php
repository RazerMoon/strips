<?php
    function displayError() {
        if(isset($_GET['error'])) {

        $title = '';
        $info = '';

        switch ($_GET['error']) {
            case 'success':
                $title = "Regsitration successful!";
                $info = "You have registered successfully! Contact a moderator to activate your account.";
            break;

            case 'nomatch':
                $title = "Account not found!";
                $info = "No account was found with those details! Please register or contact a moderator if you need help.";
            break;

            case 'notactivated':
                $title = "Account not activated!";
                $info = "Your account is not activated! Please contact a moderator for activation.";
            break;

            case 'badname':
                $title = "Invalid ICAO!";
                $info = "Only letters and numbers allowed in the Airport ICAO field! Please try again.";
            break;

            case 'notfound':
                $title = "Airport not found!";
                $info = "Cannot find an airport with that name! Please try again.";
            break;

            case 'error':
                $title = "Error!";
                $info = "Something went wrong, contact a moderator for support.";
            break;

            case 'taken':
                $title = "Account taken!";
                $info = "This account is already registered! Click <a href='/login'>here</a> to sign in.";
            break;

            case 'activate':
                $title = "Account taken!";
                $info = "This account is already registered! Please contact a moderator for activation.";
            break;

            case 'invalid_request':
                $title = "OAuth Error!";
                $info = "There was an error trying to get the access token! Please try again or contact a moderator if you need help.";
            break;

            default:
            break;
        }

        $errortemp="<div class='alert alert-danger text-center alert-dismissible fade show' id='errorAlert' role='alert'>
                    <strong>{$title}</strong><br>{$info}
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>";

        if (!empty($info) && !empty($title)) {echo $errortemp;}; // If there is an error, echo it.
        }
    }
?>