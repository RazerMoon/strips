<?php

    require_once __DIR__.'/Validate.php';
    require_once __DIR__.'/AirInfo.php';

    /**
     * Represents a flight plan.
     * 
     * NOTE: Use a try catch block when creating a new instance.
     */
    class Plan {
        private string $id, $callsign, $aircraft, $squawk, $rules, $arrival, $departure, $altitude, $route, $remarks, $valid;
        
        /**
         * __construct
         *
         * @param object $plan An object containing a callsign, aircraft, rules, arrival, departure, altitude, route and remarks.
         * @return void
         */
        public function __construct(object $plan) {

            // TODO: Store airport info in session since you need to check if the airport is valid anyway.

            $airinfo = new AirInfo();

            $error = '';
            
            if (isset($plan->callsign, $plan->aircraft, $plan->rules, $plan->departure, $plan->arrival, $plan->altitude, $plan->route, $plan->remarks)) {
                if (!Validate::max($plan->callsign, 10)) {
                    $error = 'callsignbadname';
                } elseif (!Validate::minmax($plan->aircraft, 2, 4)) {
                    $error = 'aircraftbadname';
                } elseif ($plan->rules != 'IFR' && $plan->rules != 'VFR' && $plan->rules != 'SVFR') {
                    $error = 'rulesbadname';
                } elseif (!Validate::specific($plan->departure, 4)) {
                    $error = 'depbadname';
                } elseif (!Validate::specific($plan->arrival, 4)) {
                    $error = 'arrbadname';
                } elseif (!Validate::numbmax($plan->altitude, 5)) {
                    $error = 'altitudebad';
                } elseif (!Validate::max($plan->route, 100, TRUE)) {
                    $error = 'routebad';
                } elseif (!Validate::max($plan->remarks, 20, TRUE)) {
                    $error = 'remarksbad';
                } elseif (!$airinfo->getInfo(strtoupper($plan->departure))) {
                    $error = 'depnotfound';
                } elseif (!$airinfo->getInfo(strtoupper($plan->arrival))) {
                    $error = 'arrnotfound';
                } else {

                    $rules = $plan->rules;
                    if ($rules == 'VFR') {
                        $squawk = rand(1200, 1299);
                    } else {
                        $squawk = rand(2000, 2399);
                    }

                    $this->callsign  = strtoupper($plan->callsign);
                    $this->aircraft  = strtoupper($plan->aircraft);
                    $this->squawk    = $squawk;
                    $this->rules     = strtoupper($plan->rules);
                    $this->departure = strtoupper($plan->departure);
                    $this->arrival   = strtoupper($plan->arrival);
                    $this->altitude  = strtoupper($plan->altitude);
                    $this->route     = strtoupper($plan->route);
                    $this->remarks   = $plan->remarks;
                    $this->valid     = true;
                }
            } else {
                $error = 'missing_plan_property';
            }

            if (!empty($error)) {
                throw new Exception($error);
            }
        }

        public function getPlan() {
            return $this;
        }

        /**
         * Commits plan to database.
         *
         * @return void|mixed
         */
        public function commitPlan() {
            if ($this->valid) {
                require_once __DIR__.'/../config/config.php';

                $error = '';
                $id = '';

                if ($stmt = $mysqli->prepare("INSERT INTO `plans` (callsign, aircraft, squawk, rules, departure_icao, arrival_icao, altitude, route, remarks)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")){
                    $stmt->bind_param("sssssssss", $this->callsign, $this->aircraft, $this->squawk, $this->rules, $this->departure, $this->arrival, $this->altitude, $this->route, $this->remarks);

                    if($stmt->execute()){
                        $stmt->store_result();

                        if($stmt->affected_rows == 1){
                            $id = $mysqli->insert_id;
                        } else {
                            $error = "commit_error";
                        }
                    } else {
                        $error = "db_error";
                    }
                    $stmt->close();
                } else {
                    $error = "prepare_fail";
                }
                $mysqli->close();
            } else {
                $error = 'invalid';
            }

            if (!empty($error)) {
                throw new Exception($error);
            } elseif (!empty($id)) {
                $this->id = $id;
                return $this->id;
            }
        }

        /**
         * Deletes plan from database.
         *
         * @return void|bool
         */
        public static function deletePlan(int $id) {
            require_once __DIR__.'/../config/config.php';

            $error = '';

            if ($stmt = $mysqli->prepare("DELETE FROM plans WHERE id = ?")){
                $stmt->bind_param("i", $id);

                if($stmt->execute()){
                    $stmt->store_result();

                    if($stmt->affected_rows == 1){
                        // Success
                    } else {
                        $error = "commit_error";
                    }
                } else {
                    $error = "db_error";
                }
                $stmt->close();
            } else {
                $error = "prepare_fail";
            }
            $mysqli->close();

            if (!empty($error)) {
                throw new Exception($error);
            } else {
                return TRUE;
            }
        }
    }

?>