<?php
    // session_start();
    require_once('config/db.php');
    require_once('lib/pdo_db.php');
    require_once('models/Customer.php');

    // Instatiate customer
    $customer = new Customer();

    if(isset($_POST['createAcc'])) {
        if(!$customer->create_account()) {
            echo $customer->response['message'];
        }
    }
    
    if(isset($_POST['login'])) {
        if(!$customer->login()) {
            $message = $customer->response['message'];
        }
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log in</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../layout/header/header.css">


</head>
<body>
    <?php require_once('../layout/header/header.php'); ?>   

    <div id="container" class="container">

        <!-- <h1 class="my-4 text-center">Book Info</h1> -->
        <form method="post">

            <div class="form-row">
                <div class="error_container">
                <!-- Går det kanske att sätta denna på det element som det blir fel på? hur? -->
                    <span class="error"><?php if(isset($message)) { echo $message; } ?></span>
                </div>
                <input type="text"      name="username"    class="form-control mb-3 StripElement StripeElement--empty" placeholder="Username">
                <input type="text"      name="first_name"  class="form-control mb-3 StripElement StripeElement--empty" placeholder="First Name">
                <input type="text"      name="last_name"   class="form-control mb-3 StripElement StripeElement--empty" placeholder="Last Name">
                <input type="email"     name="email"       class="form-control mb-3 StripElement StripeElement--empty" placeholder="Email">
                <input type="password"  name="password"    class="form-control mb-3 StripElement StripeElement--empty" placeholder="Password">
                <input type="submit"    name="createAcc"   class="form-control mb-3 StripElement StripeElement--empty" value="Create Account">
            </div>
        </form>
        <form method="post">
            <input type="text"      name="user"     class="form-control mb-3 StripElement StripeElement--empty" placeholder="Username">
            <input type="password"  name="pass"     class="form-control mb-3 StripElement StripeElement--empty" placeholder="Password">
            <input type="submit"    name="login"    class="form-control mb-3 StripElement StripeElement--empty" value="Log in">
        </form>
    </div>    
</body>
</html>