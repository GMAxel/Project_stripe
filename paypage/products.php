<?php
    require_once('models/products.php');
    $product = new Product();
    $products = $product->getProducts();
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
        .card { width: 300px; }
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
        .col-md-4 {
            max-width:50%;
        }
        @media screen and (max-width: 769px) {
            .col-md-4 {
                max-width:100%;
            }
            .card {
                margin-top:10px;
            }
        }

    </style>
</head>
<body>
    <?php require_once('../layout/header/header.php'); ?>   
    <div class="container">
        <?php 
            $colNum = 1;
            foreach($products as $product) {
                if ($colNum === 1) { 
                    echo "<div class='row'>";
                }
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
                                        echo "<li class='list-group-item'>License: $product->nrOfBooks</li>
                                              <li class='list-group-item'>$product->description</li>";
                                echo "
                                    </ul>
                                    <br>
                                    <a href='product.php?id=".$product->id."' class='btn btn-primary btn-primary'>
                                        <span class='glyphicon glyphicon-shopping-cart'></span> 
                                        Purchase
                                    </a>
                                    <br>
                                    </form>
                            </div>
                        </div> 
                    </div>
                ";
                if ($colNum === 3) {
                    echo "</div>";
                    $colNum = 0;
                } else {
                    $colNum++;
                }

            }
        ?>
        <!-- <form action='stripe_payment.php?id=".$productID."' method='POST'>
                                    <script src='https://checkout.stripe.com/checkout.js' class='stripe-button'
                                        data-key='pk_test_Os0wZHnLLtjVJA2y4RXvOK6P00CXrZZMIM'
                                        data-amount='".$attributes['price']."'
                                        data-name='".$attributes['title']."'
                                        data-description='".$attributes['description']."'
                                        data-image='https://stripe.com/img/documentation/checkout/marketplace.png'
                                        data-locale='auto'
                                        data-currency='sek'>
                                    </script>
                                     -->
            
    </div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html> 