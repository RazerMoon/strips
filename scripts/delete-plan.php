<?php
    require("classes/Plan.php");

    session_start();

    // TODO: Take input on POST request and check if user is logged to delete flight plans as atc.

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_SESSION['PlanID'])) {
            $id = $_SESSION['PlanID'];

            try {
                if (Plan::deletePlan($id)){
                    session_destroy();
                    header('Location: /?error=delete_success');
                }
            } catch (Exception $e) {
                header("Location: ?error={$e->getMessage()}");
            }
              /*
            $airinfo = new AirInfo;
            if ($airinfo->changeAirport($icao) === FALSE) {
                echo "Airport not found!";
                http_response_code(404);
            }
            */

        }
    }

?>