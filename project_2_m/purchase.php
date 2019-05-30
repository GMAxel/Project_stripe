<?php
session_start();

if(!isset($_SESSION['customer_id'])) {
    header("Location: login.php");  
}

require_once('classes/Customer.php');
require_once('classes/Product.php');

var_dump($_SESSION['customer_id']);
var_dump($_SESSION['stripe_id']);
$id = $_GET['id'];
echo $id;
$product_obj = new Product();
$product = $product_obj->getProduct($id);
var_dump($product);
$customer = new Customer();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="layout/main/purchase.css">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Pay Page</title>

</head>
<body>
<?php require_once('layout/nav/nav.php'); ?>   
<h2 class="my-4 text-center">Purchase</h2>
<p class="my-4 text-center"><a href="license.php?id=<?php echo $id ?>">Back one step</a></p>
<div class="product_info">
    <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Licenses</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $product->name ?></td>
                    <td><?php echo $product->nrOfBooks ?></td>
                    <td><?php echo ($product->price/100) ?>kr</td>
                </tr>
            </tbody>
    </table>
</div>
<div class="pay_container">
    <form action="./charge.php?id=<?php echo $product->id; ?>" method="post" id="payment-form">
        <div class="form-row">
            <div id="card-element" class="form-control">
                <!-- A Stripe Element will be inserted here. -->
            </div>

            <div id="card-errors" role="alert">
                <!-- Used to display form errors. -->
            </div>
        </div>

        <button>Submit Payment</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="./js/charge.js"></script>

</body>
</html>