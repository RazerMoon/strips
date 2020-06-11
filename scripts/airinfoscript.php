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

                    if($stmt = $mysqli->prepare("UPDATE `users` SET `airport` = ? WHERE `discord` = ?")){
                        $stmt->bind_param("ss", $icao, $_SESSION['Discord']); // For some reason discord ID has to be varchar or it doesn't work¯\_(ツ)_/¯

                        if($stmt->execute()){
                            $stmt->store_result();

                            /* If row was affected (Value changed) */
                            if($stmt->affected_rows == 1){
                                //echo "Success";
                            } else {
                                //echo "Fail";
                                //print_r($stmt);
                            }
                        } else {
                            //echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                    $stmt->close();
                    $mysqli->close();
                }
            } else {
                echo "Illegal ICAO!";
                http_response_code(406);
            }
        }
    }

?>