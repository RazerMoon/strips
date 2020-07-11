<?php
    /* IF REUSING THIS CODE, GET THE NUMBER VALIDATOR JS CODE */

    /* If a user tries tries to visit this page while logged in, they get redirected back to the atc page. */
    session_start();                        // Starts the session.

    include __DIR__.'/scripts/logblock.php';
    include __DIR__.'/scripts/errorhandler.php';
    include __DIR__.'/scripts/classes/Validate.php';
    include __DIR__.'/scripts/classes/AirInfo.php';
    include __DIR__.'/scripts/classes/Plan.php';

    /* Checks for illegal characters */
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST["Callsign"], $_POST["Aircraft"], $_POST["Rules"], $_POST["Departure_ICAO"], $_POST["Arrival_ICAO"], $_POST["Altitude"], $_POST["Route"], $_POST["Remarks"])) {

            $planinfo = (object) 
            [
                'callsign'  => $_POST["Callsign"],
                'aircraft'  => $_POST["Aircraft"],
                'rules'     => $_POST["Rules"],
                'departure' => $_POST["Departure_ICAO"],
                'arrival'   => $_POST["Arrival_ICAO"],
                'altitude'  => $_POST["Altitude"],
                'route'     => $_POST["Route"],
                'remarks'   => $_POST["Remarks"]
            ];

            $caught = false;
        
            try {
                $plan = new Plan($planinfo);

                $_SESSION['PlanID'] = $plan->commitPlan();
                $_SESSION['Plan'] = $plan;

                header('Location: /plan');
            } catch (Exception $e) {
                header("Location: ?error={$e->getMessage()}");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>File a plan</title>
    <meta name="title" content="File a plan">
    <meta name="description" content="File a flight plan!">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Dark <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-Bo21yfmmZuXwcN/9vKrA5jPUMhr7znVBBeLxT9MA4r2BchhusfJ6+n8TLGUcRAtL" crossorigin="anonymous"> -->
</head>

<body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
      <a class="navbar-brand" href="/">Strips System</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
        </ul>
      </div>
    </nav>
    

    <!-- File Form -->
    <form class="form-signin" method="post">
        <div class="text-center mb-4 mt-2">
            <!-- Icon made by Raj Dev, freeicons.io. https://freeicons.io/documents-icons/icon-notebook-icon-7317-->
            <svg width="6em" height="6em" viewBox="0 0 32 32">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g sketch:type="MSArtboardGroup" fill="#000000">
                    <path d="M9.99742191,3 C8.89427625,3 8,3.89833832 8,5.00732994 L8,27.9926701 C8,29.1012878 8.89092539,30 9.99742191,30 L25.0025781,30 C26.1057238,30 27,29.1016617 27,27.9926701 L27,5.00732994 C27,3.89871223 26.1090746,3 25.0025781,3 L9.99742191,3 L9.99742191,3 Z M6,10 L6,11 L8,11 L8,10 L6,10 L6,10 Z M6,14 L6,15 L8,15 L8,14 L6,14 L6,14 Z M6,6 L6,7 L8,7 L8,6 L6,6 L6,6 Z M6,22 L6,23 L8,23 L8,22 L6,22 L6,22 Z M6,26 L6,27 L8,27 L8,26 L6,26 L6,26 Z M6,18 L6,19 L8,19 L8,18 L6,18 L6,18 Z M8,10 L8,11 L10,11 L10,10 L8,10 L8,10 Z M8,14 L8,15 L10,15 L10,14 L8,14 L8,14 Z M8,6 L8,7 L10,7 L10,6 L8,6 L8,6 Z M8,22 L8,23 L10,23 L10,22 L8,22 L8,22 Z M8,26 L8,27 L10,27 L10,26 L8,26 L8,26 Z M8,18 L8,19 L10,19 L10,18 L8,18 L8,18 Z M12,8 L12,9 L23,9 L23,8 L12,8 L12,8 Z M13,12 L13,13 L22,13 L22,12 L13,12 L13,12 Z" id="notebook" sketch:type="MSShapeGroup"></path>
                </g>
            </g>
            </svg>
            <h1 class="h3 mb-3 font-weight-normal">File a flight plan</h1>
            <p>Fill out the fields below to file a flight plan.</p>
        </div>
        
        <?php displayError()?>

        <div class="form-label-group">
            <input type="text" maxlength="10" class="form-control uppercase" placeholder="Callsign" name="Callsign" required autofocus>
            <label>Callsign</label>
        </div>

        <div class="form-label-group">
            <input type="text" maxlength="4" class="form-control uppercase" placeholder="Aircraft" name="Aircraft" required>
            <label>Aircraft</label>
        </div>

        <div class="form-label-group">
            <select class="form-control" name="Rules">
                <option>IFR</option>
                <option>VFR</option>
                <option>SVFR</option>
            </select>
        </div>

        <div class="form-label-group">
            <input type="text" maxlength="4" class="form-control uppercase" placeholder="Departure Airport ICAO" name="Departure_ICAO" required>
            <label>Departure Airport ICAO</label>
        </div>

        <div class="form-label-group">
            <input type="text" maxlength="4" class="form-control uppercase" placeholder="Arrival Airport ICAO" name="Arrival_ICAO" required>
            <label>Arrival Airport ICAO</label>
        </div>

        <div class="form-label-group">
            <input type="number" maxlength="5" class="form-control uppercase" placeholder="Cruise Altitude" name="Altitude" required>
            <label>Cruise Altitude</label>
        </div>

        <div class="form-label-group">
            <input type="text" maxlength="100" class="form-control uppercase" placeholder="Route" name="Route" required>
            <label>Route</label>
        </div>

        <div class="form-label-group">
            <input type="text" maxlength="20" class="form-control" placeholder="Remarks" name="Remarks">
            <label>Remarks</label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">File plan</button>

        <p class="text-center mt-1">Want to become a controller? <a href="/register">Sign up now.</a></p>

        <p class="mt-4 mb-2 text-muted text-center">Copyright &copy; 2020 | RazerMoon</p>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Special -->
    <script src="assets/js/file.js"></script>
</body>

</html>