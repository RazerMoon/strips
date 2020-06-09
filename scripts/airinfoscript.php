<?php
    require('classes/AirInfo.php');

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
            } else {
                echo "Illegal ICAO!";
                http_response_code(406);
            }
        }
    }

?>