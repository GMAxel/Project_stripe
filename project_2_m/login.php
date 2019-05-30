<?php
    session_start();
    require_once('classes/Customer.php');
    // Instatiate customer
    $customer = new Customer();
    if(isset($_SESSION['customer_id'])) {
        header("Location: index.php");
    }
    if(isset($_GET['license'])) {
        $license = $_GET['license'];
    }
    if(isset($_POST['login'])) {
        if(isset($license)) {
            header("Location: license.php?id=$license");
        } else if(isset($_GET['reroute'])) {
            $page = $_GET['reroute'];
            header("Location: $page.php");
        } else {
            header("Location: index.php"); 
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="layout/main/create_account.css">
    <link rel="stylesheet" href="layout/nav/nav.css">

    <title>Log In</title>
</head>
<body>
<?php require_once('layout/nav/nav.php'); ?>   

<h2 class="my-4 text-center">Log In</h2>
<form method="post" action="" class="create_acc_form needs-validation" novalidate>  
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="user" id="username" class="form-control" required>        
        <div class="invalid-feedback">Please enter a valid username</div>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="pass" id="password" class="form-control" required>
    </div>
    <button type="submit" name="login" class="mt-3 btn btn-primary">Log In
    </button>
    <p class="mt-3"><?php if(isset($customer->response)) { echo $customer->response; } ?></p>
    <p class="mt-3"><a href="create_account.php">Create Account</a></p>
</form>    
<script>
    var form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated')
    });
</script>
<?php require_once('layout/footer/footer.php'); ?>      
</body>
</html>
