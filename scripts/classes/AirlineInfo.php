<?php
    /**
     * Used to get information from OpenFlights.
     * 
     * @link https://openflights.org/
     */
    class AirlineInfo {

        /**
         * Gets data from OpenFlights.
         * 
         * Makes a POST request to OpenFlights, typically with just an airline ICAO, and returns an object with the returned status code and data.
         * 
         * @return object
         * @link https://openflights.org/
         */
        private function getData(array $fields) {

            // Open connection.
            $ch = curl_init();

            // Set the URL, POST variables and POST data
            curl_setopt($ch, CURLOPT_URL, 'https://openflights.org/php/alsearch.php');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded'
            ));

            $data = curl_exec($ch);

            $status = curl_getinfo($ch)["http_code"];

            curl_close($ch);

            if ($status == 200) {
                return (object) ['success' => TRUE, 'data' => $data];
            } else {
                return (object) ['success' => FALSE, 'data' => $data];
            }
        }

        /**
         * Gets information about an airline from OpenFlights.
         * 
         * Gets information about an airline from OpenFlights. Returns FALSE and 404 if no match was found, otherwise returns airline info NOTE: Only temporary, will return object in future.
         * 
         * @return false|void
         * @link https://openflights.org/
         */
        public function getAirlineInfo(string $icao) {
            $fields = [
                "icao"  =>  $icao // Only three characters allowed, no more no less.
            ];

            $response = $this->getData($fields);

            if ($response->success) {
                $jsonData = json_decode(preg_replace('/^[^{]*/', '', $response->data)); // Removes everything before bracket so json_decode works.

                if (empty($jsonData)) {
                    http_response_code(404);
                    return FALSE;
                } else {
                    echo "<pre>";
                    print_r($jsonData);
                    echo "</pre>";

                    print_r($jsonData->name);
                    echo "</br>";
                    print_r($jsonData->callsign);
                    echo "</br>";
                    print_r($jsonData->al_name);
                }
            }
        }
    }
?>