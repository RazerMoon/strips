<?php
    /**
     * Used to get information from AviationAPI and manage the controller details.
     * 
     * TODO: Instead of only using printInfo, store the information in the class.
     * @link https://www.aviationapi.com/
     */
    class AirInfo {
        
        /**
         * Changes airport session variable and erases saved airport information.
         *
         * @param  string $icao
         * @return false|void
         */
        public function changeAirport(string $icao) {
            if ($this->getInfo($icao) === FALSE) {
                return FALSE;
            } else {
                $_SESSION["Airport_ICAO"] = $icao;
                if (isset($_SESSION["Air_Info"])) {
                    unset($_SESSION["Air_Info"]);
                }

                if (isset($_SESSION['Discord'])) {
                    require_once(__DIR__.'/../config/config.php');

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
                        $stmt->close();
                    }
                    $mysqli->close();
                }
            }
        }
        
        /**
         * Gets data from AviationAPI.
         *
         * @param  string $icao
         * @return object
         */
        private function getData(string $icao) {
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
                return (object) ['success' => TRUE, 'data' => $decoded];
            } else {
                return (object) ['success' => FALSE, 'data' => $decoded];
            }
        }
        
        /**
         * Gets information about an airport and displays it.
         *
         * @param  string $icao
         * @return array|bool
         */
        public function getInfo(string $icao) {
            $response = $this->getData($icao);
            if ($response->success) {
                return $response->data;
            } else {
                return FALSE;
            }
        }
        
        /**
         * Gets information about ICAO stored in session.
         *
         * @param  string $icao
         * @return void|array
         */
        public function getLocalInfo(string $icao) {
            if (! isset($_SESSION["Air_Info"])) { // Only get info once (kind of like caching?). HAVE TO RESET "Air_Info" TO GET NEW RESULTS.

                $response = $this->getData($icao);
                if ($response->success) {
                    $_SESSION["Air_Info"] = $response->data;
                    return $response->data;
                } else {
                    echo "Airport could not be found!";
                    $_SESSION["Air_Info"] = $response->data;
                }
            
            } elseif (count($_SESSION["Air_Info"]) == 0){
                echo "<div class='alert alert-danger mb-0 text-center fade show' id='errorAlert' role='alert'><strong>Airport could not be found!</strong></div>";
            } else {
                return $_SESSION["Air_Info"];
            }
        }
        
        /**
         * Displays AviationAPI results nicely using a table.
         *
         * @param  array $data Response from ```getData()```
         * @return void
         */
        public function printInfo(array $data) {
            $options = ["facility_name", "icao_ident", "city"];

            $info = $data[0];
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