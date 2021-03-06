<?php
error_reporting(E_All);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="bootstrap.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="bootstrap-theme.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Home</a>
          <?php
            session_start();
            include("passwords.php");
            if(isset($_POST["ac"]) && $_POST["ac"]=="log"){ // do after login form is submitted
                 if ($USERS[$_POST["username"]]==$_POST["password"]){ // check if submitted username and password exist in $USERS array
                      $_SESSION["logged"]=$_POST["username"];
                 }else{
                      echo 'Incorrect username/password. Please, try again.';
                 };
            };
            if(isset($_POST["ac"]) && array_key_exists($_SESSION["logged"],$USERS)){ // check if user is logged or not
                 echo "PHP is kind of weird."; // if user is logged show a message
            }else{ // if not logged show login form
                 echo '<form action="sampleprofile.php" method="post"><input type="hidden" name="ac" value="log">
                      Username: <input type="text" name="username" />
                      Password: <input type="password" name="password" />
                    <input type="submit" value="Login" />
                      </form>';
            }
        ?>
        </div>
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <center><img height=50% width=50% src="images/skin.png" /><center>
        <p>
        Find the right product for your skin.
    </p>
        <p>
    The current market is filled with products that have long lists of obscure ingredients.
    </p>
        <p>
        Here is our secret:
    </p>
        <ol>
          <li>Start with the most basic face wash depending on your skin type.</li>
      <li>Add products one at a time and see what works.</li>
      <li>90 day commitment towards a lifetime of better skin.</li>
    </ol>
        <p>
    We provide a database where you can easily cross reference products and ingredients.
    </p>
    <p>
        We offer a starter kit that includes a basic face wash, 3 ingredients of your choice, detailed instructions, and a daily planner.
        </p>
      </div>
    </div>

      <hr>

      <footer>
        <p>&copy; Team Skin City 2015</p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.1.min.js"><\/script>')</script>

        <script src="bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>