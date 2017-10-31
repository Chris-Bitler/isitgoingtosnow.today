<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
        <script src="assets/application.js" type="text/javascript"></script>
        <link rel="stylesheet" href="assets/style.css"/>
        <link rel="shortcut icon" href="assets/favicon.ico"/>
    </head>

    <body>
        <h1 class="header-center">Is it going to snow today?</h1>
        <input type="text" id="zip-input" placeholder="Zip code" class="form-control zip-input"/>
        <input type="button" id='button' value='Check' class="btn btn-primary button"/>

        <div class="response-hidden" id="response">
            <img src="" id="weather_image"/><br />
            <span id="text-response"></span>
        </div>
        <p class="footer">Created by Christopher Bitler</p>
    </body>
</html>
