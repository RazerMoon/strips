<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight plan</title>
    <meta name="title" content="Flight plan">
    <meta name="description" content="View your flight plan details!">

    <!-- Stylesheets -->
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.0/darkly/bootstrap.min.css" rel="stylesheet" integrity="sha384-Bo21yfmmZuXwcN/9vKrA5jPUMhr7znVBBeLxT9MA4r2BchhusfJ6+n8TLGUcRAtL" crossorigin="anonymous">
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
                <li class="nav-item">
                    <a class="nav-link" href="/scripts/delete-plan.php">Delete Plan</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="card">
        <div class="card-body" id="plan">
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript">
        
        $(document).ready(() => {

        $('#plan').load("/scripts/fetch-plan.php");

        setInterval(() => {
            $('#plan').load("/scripts/fetch-plan.php");
            }, 15000);

        });
    </script>
</body>

</html>