<?php
session_start();
require_once('config/db.php');
require_once('lib/pdo_db.php');
require_once('models/Customer.php');
var_dump($_SESSION['customer_id']);
var_dump($_SESSION['stripe_id']);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Pay Page</title>
</head>
<body>
<?php require_once('../layout/header/header.php'); ?>   
  <div class="container">
    <h2 class="my-4 text-center">Book Information 50$</h2>
    <form action="./charge.php" method="post" id="payment-form">
      <div class="form-row">
          <div id="card-element" class="form-control">
          <!-- A Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
      </div>

      <button>Submit Payment</button>
    </form>
  </div>      
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="./js/charge.js"></script>

</body>
</html>