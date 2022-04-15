<?php

if ($_POST['city']) {

    $weather = "";
    $error = "";

    $city = str_replace(" ", "", $_POST['city']);

    $file_headers = @get_headers("https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest");

    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {

        $error = "That city could not be found";
    } else {

        $forecast = file_get_contents("https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest");

        $pageArray = explode('3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">', $forecast);

        if (sizeof($pageArray) > 1) {

            $secondPageArray = explode('</span></p></td>', $pageArray[1]);

            if (sizeof($secondPageArray) > 1) {

                $weather =  $secondPageArray[0];
            } else {

                $error = "That city could not be found";
            }
        } else {

            $error = "That city could not be found";
        }
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: -1;
            /* background: var(--color-darkblue); */
            background-image: url(unsplash.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .container {
            text-align: center;
            margin-top: 150px;
            font-family: sans-serif;
        }

        .container h1 {
            font-size: xxx-large;
            color: white;
        }

        .container p {
            font-size: large;
            color: white;
        }

        form {
            margin-top: 55px;
        }

        #city {
            width: 50%;
            margin-left: 27%;
        }

        #weather {
            width: 40%;
            margin-left: 30%;
            margin-top: 2%;
            text-align: center;
        }
    </style>

    <title>Weather Scraper</title>
</head>

<body>
    <div class="container">

        <h1>What's the weather?</h1>

        <form method="post">
            <div class="form-group">
                <label for="city">
                    <p>Enter the name of the city</p>
                </label>
                <input type="text" class="form-control" id="city" name="city" placeholder="Eg. Delhi, Tokyo" value="<?php echo $_POST['city']; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div id="weather">

            <?php

            if ($weather) {

                echo '<div class="alert alert-success" role="alert">
                            ' . $weather . '
                        </div>';
            } else if ($error) {

                echo '<div class="alert alert-danger" role="alert">
                            ' . $error . '
                        </div>';
            }

            ?>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>