<?php
    session_start();
    require_once('config/db.php');
    require_once('lib/pdo_db.php');
    require_once('models/Transaction.php');

    // Instatiate Customer
    $transaction = new Transaction();

    // get Customers
    $transactions = $transaction->getTransactions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>View Transactions</title>
</head>
<body>
<?php require_once('../layout/header/header.php'); ?>   

 <div class="container mt-4">
    <div class="btn-group" role="group">
        <a href="customers.php" class="btn btn-secondary">Customers</a>
        <a href="transactions.php" class="btn btn-primary">Transactions</a>

    </div>
    <h2>Customers</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Product</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach($transactions as $t): ?>
            <tr>
                <td><?php echo $t->stripe_charge_id ?></td>
                <td><?php echo $t->product ?></td>
                <td><?php echo sprintf('%.2f', $t->amount / 100) .
                 ' ' .  strtoupper($t->currency) ?> 
                </td>
                <td><?php echo $t->created_at ?></td>
                <td><?php echo $t->status ?></td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <p><a href="index.php"> Pay Page </a></p>

 </div>
    
</body>
</html>