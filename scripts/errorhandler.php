<?php
    
    /**
     * Returns an alert with error details.
     *
     * @return void
     */
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
                $info = "Only letters and numbers allowed in the Airport ICAO field! Please try again and make sure to use four characters.";
            break;

            case 'callsignbadname':
                $title = "Invalid Callsign!";
                $info = "Only letters and numbers allowed in the Callsign field! Please try again and make sure to use a maximum of ten characters.";
            break;

            case 'aircraftbadname':
                $title = "Invalid Aircraft!";
                $info = "Only letters and numbers allowed in the Aircraft field! Please try again and make sure to use a minimum of two and maximum of four characters.";
            break;

            case 'rulesbadname':
                $title = "Invalid Rules!";
                $info = "Only IFR, VFR or SVFR allowed!";
            break;

            case 'depbadname':
                $title = "Invalid Departure ICAO!";
                $info = "Only letters and numbers allowed in the Airport ICAO field! Please try again and make sure to use four characters.";
            break;

            case 'arrbadname':
                $title = "Invalid Arrival ICAO!";
                $info = "Only letters and numbers allowed in the Airport ICAO field! Please try again and make sure to use four characters.";
            break;

            case 'altitudebad':
                $title = "Invalid Altitude!";
                $info = "A maximum of five numbers allowed!";
            break;

            case 'routebad':
                $title = "Invalid Route!";
                $info = "Only letters and numbers allowed in the Route field! Please try again and make sure to use a maximum of one hundred characters.";
            break;

            case 'remarksbad':
                $title = "Invalid Remarks!";
                $info = "Only letters and numbers allowed in the Remarks field! Please try again and make sure to use a maximum of tweny characters.";
            break;

            case 'notfound':
                $title = "Airport Not Found!";
                $info = "Cannot find an airport with that name! Please try again.";
            break;

            case 'depnotfound':
                $title = "Departure Airport Not Found!";
                $info = "Cannot find an airport with that name! Please try again.";
            break;

            case 'arrnotfound':
                $title = "Arrival Airport Not Found!";
                $info = "Cannot find an airport with that name! Please try again.";
            break;

            case 'missing_plan_property':
                $title = "Missing Plan Property!";
                $info = "One of the plan properties are missing";
            break;

            case 'error':
                $title = "Error!";
                $info = "Something went wrong, contact a moderator for support.";
            break;

            case 'taken':
                $title = "Account Taken!";
                $info = "This account is already registered! Click <a href='/login'>here</a> to sign in.";
            break;

            case 'activate':
                $title = "Account Taken!";
                $info = "This account is already registered! Please contact a moderator for activation.";
            break;

            case 'invalid_request':
                $title = "OAuth Error!";
                $info = "There was an error trying to get the access token! Please try again or contact a moderator if you need help.";
            break;

            case 'access_denied':
                $title = "Access Denied!";
                $info = "The resource owner or authorization server denied the request. Did you press cancel?";
            break;

            case 'commit_error':
                $title = "Commit Error!";
                $info = "An error occured while trying to write to the database! Please try again or contact a moderator for help.";
            break;

            case 'db_error':
                $title = "Database Error!";
                $info = "An error occured while trying to write to the database! Please try again or contact a moderator for help.";
            break;

            case 'prepare_fail':
                $title = "Prepare Fail!";
                $info = "An error occured while trying to prepare a statement! Please try again or contact a moderator for help.";
            break;

            case 'delete_success':
                $title = "Deletion Successfull!";
                $info = "Flight plan was deleted successfully!";
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