<?php
    session_start();
    require_once('classes/Customer.php');

    // Instatiate customer
    $customer = new Customer();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="layout/nav/nav.css">


</head>
<body>
    <?php require_once('layout/nav/nav.php'); ?>   

    <div id="container" class="container">
        <h1 class="my-4 text-center">Home</h1>
        <h2 class="my-4">What we do</h2>
        <p class="mb-0"> You get to upload a CSV file with ISBN numbers.
        In return we will return a new CSV file containing information
        about the books with the uploaded ISBN-numbers
        </p>

        <h2 class="my-4">The process</h2>
        <p>
        The process is rather simple. First you buy a license.
        Then for each purchased license you can retrieve information about
        one book.
        <ol>
            <li> Create Account <a href="#"> here</a></li>
            <li> Log In <a href="#"> here </a></li>
            <li> Purchase license <a href="#">here</a></li>
            <li> Upload CSV-file <a href="#">here</a></li>
        </ol>
        </p>
        <h2 class="my-4">Why do we do it?</h2>
        <p> School assignment :) :) :)
        </p>
    </div> 
    <?php require_once('layout/footer/footer.php'); ?>      
    </body>
</html>