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
        <h2 class="my-4 text-center">Documentation</h2>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium ducimus 
            voluptates autem excepturi dolorem exercitationem consequuntur quas recusandae 
            nemo, culpa nobis pariatur rem numquam est temporibus voluptatibus cum, inventore odit.
        </p>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium ducimus 
            voluptates autem excepturi dolorem exercitationem consequuntur quas recusandae 
            nemo, culpa nobis pariatur rem numquam est temporibus voluptatibus cum, inventore odit.
        </p>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium ducimus 
            voluptates autem excepturi dolorem exercitationem consequuntur quas recusandae 
            nemo, culpa nobis pariatur rem numquam est temporibus voluptatibus cum, inventore odit.
        </p>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium ducimus 
            voluptates autem excepturi dolorem exercitationem consequuntur quas recusandae 
            nemo, culpa nobis pariatur rem numquam est temporibus voluptatibus cum, inventore odit.
        </p>
    </div>    
</body>
</html>