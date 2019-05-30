<?php
    session_start();
    require_once('classes/Product.php');
    require_once('classes/Customer.php');
    $product_obj = new Product();
    $id = $_GET['id'];
    $product = $product_obj->getProduct($id);
    $customer = new Customer();
    var_dump($_SESSION['customer_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="layout/nav/nav.css">
    <link rel="stylesheet" href="layout/main/license.css">
    <style>
        .container_offer {
            margin:auto;
            width:500px;
        }
        .card {
            margin:0;
        }
    </style>
</head>
<body>
    <?php require_once('layout/nav/nav.php'); ?>   
    <p class="my-4 text-center"><a href="licenses.php">Back one step</a></p>
    <div class="container_offer">
                <div class='row'>
                    <div class='col-md-4'>
                        <div class='card'>
                            <div class='card-header text-center'>
                                <h2 class='price'> <?php echo ($product->price/100); ?> <span class='currency'>kr</span> </h2>
                            </div>
                            <div class='card-body text-center'>
                                <div class='cart-title'>
                                    <h2> <?php echo $product->name; ?></h2>
                                </div>
                                <ul class='list-group'>
                                        <li class='list-group-item'>License: <?php echo $product->nrOfBooks; ?></li>
                                        <li class='list-group-item'><?php echo $product->description; ?></li>
                                    </ul>
                                    <br>
                                    <?php if(isset($_SESSION['customer_id'])): ?>
                                    <a href='purchase.php?id=<?php echo $product->id ?>' class='btn btn-primary btn-primary'>
                                        Purchase
                                    </a>
                                    <?php else: ?>
                                    <a href="#"></a>
                                        Purchase
                                    </a>
                                    <p class="mt-3"><a href="login.php?license=<?php echo $product->id ?>">You have to be logged in to make a purchase</a></p>
                                    <?php endif; ?>
                            </div>
                        </div> 
                    </div>
            
                </div>

   
            
    </div>

    <?php require_once('layout/footer/footer.php'); ?>      
</body>
</html> 