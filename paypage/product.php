<?php
    require_once('models/products.php');
    $product_obj = new Product();
    $id = $_GET['id'];
    $product = $product_obj->getProduct($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        .container { margin-top: 100px; }
        .card { width: 500px; margin-left:80%; }
        .card:hover { 
            transform: scale(1.01);
            transition: all .5s ease-in-out;
        }
        .list-group-item {
            border:0px;
            padding:5px;
        }
        .price {
            font-size: 72px;
        }
        .currency {
            position:relative;
            font-size:25px;
            top: -31px;
        }

    </style>
</head>
<body>
    <?php require_once('../layout/header/header.php'); ?>   
    <div class="container">
        <?php 
                echo "<div class='row'>";
                echo " 
                    <div class='col-md-4'>
                        <div class='card'>
                            <div class='card-header text-center'>
                                <h2 class='price'><span class='currency'>$</span>" . ($product->price/100) ."</h2>
                            </div>
                            <div class='card-body text-center'>
                                <div class='cart-title'>
                                    <h2>". $product->name ."</h2>
                                </div>
                                <ul class='list-group'>";
                                        echo "<li class='list-group-item'>Licence: $product->nrOfBooks </li>
                                              <li class='list-group-item'>$product->description</li>";
                                echo "
                                    </ul>
                                    <br>
                                    <form action='charge2.php?id=".$product->id."' method='POST'>
                                    <script src='https://checkout.stripe.com/checkout.js' class='stripe-button'
                                        data-key='pk_test_Os0wZHnLLtjVJA2y4RXvOK6P00CXrZZMIM'
                                        data-amount='".$product->price."'
                                        data-name='".$product->name."'
                                        data-description='".$product->description."'
                                        data-image='https://stripe.com/img/documentation/checkout/marketplace.png'
                                        data-locale='auto'
                                        data-currency='sek'>
                                    </script>
                                    <br>
                                    </form>
                            </div>
                        </div> 
                    </div>
                ";
                echo "</div>";
        ?>
   
            
    </div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html> 