<?php
    require('classes/AirInfo.php');
    require('classes/Validate.php');

    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET["icao"])) {
            $icao = $_GET["icao"];
            if (Validate::specific($icao, 4)) {
                $icao = strtoupper($icao);
                $airinfo = new AirInfo;
                $airinfo->printInfo($airinfo->getInfo($icao));
            } else {
                echo "Illegal ICAO!";
                http_response_code(406);
            }
        } elseif (isset($_SESSION["Airport_ICAO"])) {
            $icao = $_SESSION["Airport_ICAO"];
            if (Validate::specific($icao, 4)) {
                $airinfo = new AirInfo;
                $airinfo->printInfo($airinfo->getLocalInfo($icao));
            } else {
                echo "Illegal ICAO!";
                http_response_code(406);
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['icao'])) {
            $icao = $_POST["icao"];
            if (Validate::specific($icao, 4)) {
                $icao = strtoupper($icao);
                $airinfo = new AirInfo;
                if ($airinfo->changeAirport($icao) === FALSE) {
                    echo "Airport not found!";
                    http_response_code(404);
                }
            } else {
                echo "Illegal ICAO!";
                http_response_code(406);
            }
        }
    }

?>