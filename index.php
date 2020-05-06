<?php

session_start();

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();

$f3->route('GET /',
    function() {
        $view = new Template();
        echo $view->render('views/pet-home.html');
    });

$f3->route('GET|POST /order', function($f3) {

        //print_r($_POST);

        //Check if the form has been posted
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Validate the data
            if (empty($_POST['pet'])) {

                //Data is invalid
                echo "Please supply a pet type";
            } else {

                //Data is valid
                $_SESSION['pet'] = $_POST['pet'];
                $_SESSION['color'] = $_POST['color'];

                //Redirect to order summary
                $f3->reroute("summary");
            }
        }

        $view = new Template();
        echo $view->render('views/pet-order.html');
    });

$f3->route('GET /summary',
    function() {
        //print_r($_SESSION);

        $view = new Template();
        echo $view->render('views/order-summary.html');
        session_destroy();
    });


//Run fat free
$f3->run();