<?php
    require('classes/Validate.php');
    require("classes/AirlineInfo.php");

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET["icao"])) {
            if (Validate::specific($_GET["icao"], 3)) {
                $ai = new AirlineInfo;
            
                $ai->getAirlineInfo($_GET["icao"]);
            } else {
                echo "Invalid ICAO!";
            }
        }
    }
?>