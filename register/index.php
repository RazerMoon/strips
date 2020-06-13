<?php
    /* If a user tries tries to visit this page while logged in, they get redirected back to the atc page. */
    session_start();                        // Starts the session.

    include $_SERVER['DOCUMENT_ROOT'].'/scripts/logblock.php';
    include $_SERVER['DOCUMENT_ROOT'].'/scripts/errorhandler.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
    <meta name="title" content="Register">
    <meta name="description" content="Register as a controller!">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href=assets/css/style.css>
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
          <li class="nav-item active">
            <a class="nav-link" href="/register">Register</a>
          </li>
        </ul>
      </div>
    </nav>

    <!-- Register Form -->
    <form class="form-signin" action="/scripts/logreg.php?action=register" method="post">
    <div class="text-center mb-4 mt-2">
        <svg class="bi bi-person-square mb-4" width="5em" height="5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M14 1H2a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V2a1 1 0 00-1-1zM2 0a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V2a2 2 0 00-2-2H2z" clip-rule="evenodd"/>
            <path fill-rule="evenodd" d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
        </svg>
        <h1 class="h3 mb-3 font-weight-normal">ATC Register</h1>
        <p>Register as an Air Traffic Controller.</p>
    </div>
        
    <button class="btn btn-lg btn-primary btn-block" type="submit">Register with Discord</button>
    <p class="text-center mt-1">Already have an account? <a href="/login">Sign in here.</a></p>

    <?php displayError()?>

    <p class="mt-4 mb-2 text-muted text-center">Copyright &copy; 2020 | RazerMoon</php>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- Special -->
</body>

</html>

