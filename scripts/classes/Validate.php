<?php
    
    /**
     * Check if input is valid.
     */
    class Validate {
        
        /**
         * Check if input has a specific length.
         *
         * @param  string $input  The string.
         * @param  int    $strlen Specific length.
         * @return bool   True if clean.
         */
        public static function specific(string $input, int $strlen) {
            $input = htmlspecialchars($input);
            if (strlen($input) == $strlen && !preg_match("/[^\w]+/", $input)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        /**
         * Check if input is less than or eual to a specific length.
         *
         * @param  string $input  The string.
         * @param  int    $strlen Maximum length.
         * @param  bool   $space  (optional) Whether to allow spaces.
         * @return bool   True if clean.
         */
        public static function max(string $input, int $strlen, bool $space=FALSE) {
            $input = htmlspecialchars($input);
            if ($space) {$match="/[^\w\s]+/";} else {$match="/[^\w]+/";}

            if (strlen($input) <= $strlen && !preg_match($match, $input)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        /**
         * Check if input is longer than a certain length and less than another length.
         *
         * @param  string $input     The string.
         * @param  int    $strlenmin Minimum length.
         * @param  int    $strlenmax Maximum length.
         * @return bool   True if clean.
         */
        public static function minmax(string $input, int $strlenmin, int $strlenmax) {
            $input = htmlspecialchars($input);
            if (strlen($input) >= $strlenmin && strlen($input) <= $strlenmax && !preg_match("/[^\w]+/", $input)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
        
        /**
         * Check if input of numbers is less than another length.
         *
         * @param  string $input The string.
         * @param  int    $strlen Maximum length.
         * @return bool   True if clean.
         */
        public static function numbmax(string $input, int $strlen) {
            $input = htmlspecialchars($input);
            if (strlen($input) <= $strlen && !preg_match("/[^0-9]+/", $input)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
?>