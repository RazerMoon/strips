<?php

    // Used to get information from the AviationAPI and manage the controller details.

    class AirInfo {
        public function __construct() {}

        // Checks if ICAO is valid.

        public static function validate($icao) {
            $icao = htmlspecialchars($icao);
            if (strlen($icao) == 4 && !preg_match("/[^a-zA-Z0-9]+/", $icao)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        // Changes airports, this is temporary until a full script with mysql inegration is made.

        public function changeAirport($icao) {
            $_SESSION["Airport_ICAO"] = $icao;
            if (isset($_SESSION["Air_Info"])) {
                unset($_SESSION["Air_Info"]);
            }
        }

        // Makes the GET request.

        private function getData($icao) {
            $result = array();

            $connection = curl_init();
                
            curl_setopt($connection, CURLOPT_URL, "https://api.aviationapi.com/v1/airports?apt={$icao}");
            curl_setopt($connection, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
            ));
            curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
        
            $airportinfo = curl_exec($connection);
            $status = curl_getinfo($connection)["http_code"];
            curl_close($connection);
        
            $decoded = json_decode($airportinfo)->$icao;

            if ($status == 200 && ! count($decoded) == 0) {
                $result["success"] = TRUE;
                $result["data"] = $decoded;
                return $result;
            } else {
                $result["success"] = FALSE;
                $result["data"] = $decoded;
                return $result;
            }
        }

        // Uses passed ICAO.

        public function getInfo($icao) {
            $response = $this->getData($icao);
            if ($response["success"]) {
                $this->printInfo($response["data"]);
            } else {
                return 'FALSE';
            }
        }

        // Uses ICAO stored in session.

        public function getLocalInfo($icao) {
            if (! isset($_SESSION["Air_Info"])) { // Only get info once (kind of like caching?). HAVE TO RESET "Air_Info" TO GET NEW RESULTS.

                $response = $this->getData($icao);
                if ($response["success"]) {
                    $_SESSION["Air_Info"] = $response["data"];
                    $this->printInfo($response["data"]);
                } else {
                    echo "Airport could not be found!";
                    $_SESSION["Air_Info"] = $response["data"];
                }
            
            } elseif (count($_SESSION["Air_Info"]) == 0){
                echo "<div class='alert alert-danger mb-0 text-center fade show' id='errorAlert' role='alert'><strong>Airport could not be found!</strong></div>";
            } else {
                $this->printInfo($_SESSION["Air_Info"]);
            }
        }

        // Displays the results nicely.

        private function printInfo($data) {
            $options = ["facility_name", "icao_ident", "city"];

            $info = (array)$data[0];
            echo "<table class='table table-striped table-bordered modal-body'><thead class='thead-dark'><tr><th scope='col'>Title</th><th scope='col'>Details</th></tr></thead><tbody>";
            foreach($info as $item=>$value) {
                if (in_array($item, $options)) {
                    $item = preg_replace('/icao/ m', 'ICAO', $item);
                    $item = ucfirst(preg_replace('/_/ m', ' ', $item));
                    echo "<tr><th scope='row'>{$item}</th><td>{$value}</td></tr>";
                }
            }
            echo "</tbody></table>";
        }
    }

?>