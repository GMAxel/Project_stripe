<?php
    session_start();
    require_once('classes/Customer.php');

    // Instatiate Customer
    $customer = new Customer();

    // get Customers
    $customers = $customer->getCustomer();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="layout/nav/nav.css">
    <title>View Customers</title>
</head>
<body>
<?php require_once('layout/nav/nav.php'); ?>   

 <div class="container mt-4">
    <div class="btn-group" role="group">
        <a href="my_account.php" class="btn btn-primary">Account</a>
        <a href="my_transactions.php" class="btn btn-secondary">Transactions</a>

    </div>
    <h2 class="my-4 text-center">Account</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created Account</th>
                <th>Licenses</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($customers as $c): ?>
            <tr>
                <td><?php echo $c->first_name . ' ' . $c->last_name ?></td>
                <td><?php echo $c->email ?></td>
                <td><?php echo $c->created_at ?></td>
                <td><?php echo $c->licenses ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
 </div>
 <?php require_once('layout/footer/footer.php'); ?>   

</body>
</html>