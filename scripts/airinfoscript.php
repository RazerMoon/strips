<?php
    require('classes/AirInfo.php');
    require('config/config.php');

    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET["icao"])) {
            $icao = $_GET["icao"];
            if (AirInfo::validate($icao)) {
                $icao = strtoupper($icao);
                $airinfo = new AirInfo();
                $airinfo->getInfo($icao);
            } else {
                echo "Illegal ICAO!";
                http_response_code(406);
            }
        } elseif (isset($_SESSION["Airport_ICAO"])) {
            $icao = $_SESSION["Airport_ICAO"];
            if (AirInfo::validate($icao)) {
                $airinfo = new AirInfo();
                $airinfo->getLocalInfo($icao);
            } else {
                echo "Illegal ICAO!";
                http_response_code(406);
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['icao'])) {
            $icao = $_POST["icao"];
            if (AirInfo::validate($icao)) {
                $airinfo = new AirInfo();
                $airinfo->changeAirport($icao);
                if (isset($_SESSION['Discord'])) {
                    $sql = 'UPDATE `users` SET `airport` = ? WHERE `discord` = ?';
                    $param_discord = $_SESSION['Discord'];

                    if($stmt = mysqli_prepare($link, $sql)){
                        mysqli_stmt_bind_param($stmt, "ss", $icao, $param_discord); // For some reason discord ID has to be varchar or it doesn't work¯\_(ツ)_/¯

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
                            //echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                    mysqli_stmt_close($stmt);
                    mysqli_close($link);
                }
            } else {
                echo "Illegal ICAO!";
                http_response_code(406);
            }
        }
    }

?>