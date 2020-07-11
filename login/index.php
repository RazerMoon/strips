<?php
    /* If a user tries tries to visit this page while logged in, they get redirected back to the atc page. */
    session_start();                                                // Starts the session.

    include __DIR__.'/../scripts/logblock.php';
    include __DIR__.'/../scripts/errorhandler.php';
    include __DIR__.'/../scripts/classes/AirInfo.php';
    include __DIR__.'/../scripts/classes/Validate.php';

    /* Checks ICAO for illegal characters, sends to login script if everything is clean */
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST["Airport_ICAO"], $_POST["Position"])) {

            $icao = $_POST["Airport_ICAO"];
            $pos = $_POST["Position"];

            if (!Validate::specific($_POST["Airport_ICAO"], 4)) {
                header('Location: ?error=badname');                         // If ICAO contains illegal characters, reload the page with an error code.
            }
            else {
                $airinfo = new AirInfo();
                $icao = strtoupper($icao);
                
                if (!$airinfo->getInfo($icao)) {
                    header('Location: ?error=notfound');                        // If airport wasn't found, reload with error.
                } else {
                    $_SESSION["Airport_ICAO"] = $icao;
                    $_SESSION["Position"] = htmlspecialchars($pos);
                    header('Location: /scripts/logreg.php?action=login');       // Redirect to login script.
                }
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
    <title>Login</title>
    <meta name="title" content="Login">
    <meta name="description" content="Login as a controller!">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
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
          <li class="nav-item active">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Login Form -->
    <form class="form-signin" method="post">
        <div class="text-center mb-4 mt-2">
            <svg class="bi bi-person-square mb-4" width="5em" height="5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
            </svg>
            <h1 class="h3 mb-3 font-weight-normal">ATC Login</h1>
            <p>Fill out the fields below to sign into the Strips System as an Air Traffic Controller.</p>
        </div>
            
        <div class="form-label-group">
            <input type="text" maxlength="4" class="form-control uppercase" placeholder="Airport ICAO" name="Airport_ICAO" required autofocus>
            <label>Airport ICAO</label>
        </div>
            
        <div class="form-label-group">
            <select class="form-control" name="Position">
                <option>App/Dep</option>
                <option>Tower</option>
                <option>Ground</option>
                <option>Delivery</option>
                <option>Supervisor</option>
            </select>
        </div>
            
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    
        <p class="text-center mt-1">Don't have an account? <a href="/register">Sign up now</a>.</p>
    
        <?php displayError()?>
    
        <p class="mt-4 mb-2 text-muted text-center">Copyright &copy; 2020 | RazerMoon</p>
    </form>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Special -->
    <script src="assets/js/login.js"></script>
</body>

</html>

