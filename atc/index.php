<?php
    session_start(); // Starts the session.
    
    // Redirects user to homepage if they don't have an ICAO or ATC Position set.
    
    if (! isset($_SESSION["Airport_ICAO"]) || ! isset($_SESSION["Position"])) {
        header('Location: /');
    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Meta -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>ATC</title>
        <meta name="title" content="ATC">
        <meta name="description" content="Control Plans!">

        <!-- Stylesheets -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href=assets/css/style.css>
    </head>
    <body>
        <!-- Get Airport Information -->
        <div class="modal fade" id="airModal" tabindex="-1" role="dialog" aria-labelledby="airModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 text-white bg-primary">
                        <h5 class="modal-title" id="airModal"><?php echo $_SESSION["Airport_ICAO"]?> Information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="airModal-body"></div>
                </div>
            </div>
        </div>
        </div>
        <!-- NavBar -->
        <nav class="navbar navbar-expand-md navbar-dark pt-0 pb-0 fixed-top">
            <a class="navbar-brand" href="/">Strips System</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/scripts/logout.php">Logout</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <button type="button" class="btn btn-success pl-4 pr-4" data-toggle="tooltip" data-placement="bottom" title="Current position"><?php echo $_SESSION["Position"];?></button>                                                        
                    <!-- Airport Selector -->
                    <div class="btn-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <button type="button" id="airModal-button" class="btn btn-primary pl-4 pr-4 ml-2" data-toggle="modal" data-target="#airModal"><?php echo $_SESSION["Airport_ICAO"];?></button>
                                <button type="button" id="airDrop" class="btn btn-primary dropdown-toggle dropdown-toggle-split pl-4 pr-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown" id="changeAirDiv">
                                    <form class="dropdown-menu mt-2" id="changeAirForm">
                                        <div class="input-group pl-2 pr-2">
                                            <input type="text" id="changeAirport" maxlength="4" class="form-control" placeholder="KSAN" aria-label="ICAO" aria-describedby="button-ICAO">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" id="changeButton">Change</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>
            </div>
        </nav>
        <!-- Strips Container -->
        <div class="container-fluid ml-3">
            <div class="row">
                <div class="col-3" style="min-width: 265px">
                    <input type="text" name="search" id="search" placeholder="Search Plans" class="form-control form-control-lg mb-5" maxlength="8" autocomplete="off">
                    <div id="load-strips">
                        <div class="card strip-card">
                            <a class="block" strip="25265" href="?i=25265">
                                <div class="card-body">
                                    <img src="assets/img/unknownCallsign.png" height="65px">
                                </div>
                                <div class="card-footer">
                                    <h4>MS10</h4>
                                    <p style="font-size: 11px;">KFIG→KEWR</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-9 ui-sortable" id="tablelist"></div>
            </div>
        </div>
        <!--Script Magic-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="assets/js/atc.js"></script>
    </body>
</html>