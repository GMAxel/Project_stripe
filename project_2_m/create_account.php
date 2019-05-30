<?php
    session_start();
    require_once('classes/Customer.php');
    // Instatiate customer
    if(isset($_SESSION['customer_id'])) {
        header("Location: index.php");
    }
    $customer = new Customer();

    if(isset($_POST['createAcc'])) {
        $customer->create_account();
        header('Location: login.php');
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

    <title>Document</title>
</head>
<body>
<?php require_once('layout/nav/nav.php'); ?>   

<h2 class="my-4 text-center">Create Account</h2>
<form method="post" action="" class="create_acc_form needs-validation" novalidate>
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="first_name" id="firstname" class="form-control" required>        
                <div class="invalid-feedback">Enter your first name</div>
                <div class="valid-feedback">Accepted</div>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" class="form-control" required>        
                <div class="invalid-feedback">Enter your last name</div>
                <div class="valid-feedback">Accepted</div>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" class="form-control" required>        
        <div class="invalid-feedback">Please enter a valid email</div>

    </div>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" required>        
        <div class="invalid-feedback">Please enter a valid username</div>

    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="form-check">
        <input type="checkbox" id="accept-terms" class="form-check-input" required>
        <label for="accept_terms" class="form-check-label">Accept Terms & Conditions</label>
    </div>
    <button type="submit" name="createAcc" class="mt-3 btn btn-primary">Create Account
    </button>
    <p class="mt-3"><?php if(isset($customer->response)) { echo $customer->response; } ?></p>
    <p class="mt-3"><a href="login.php">Log In</a></p>

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

</body>
</html>
