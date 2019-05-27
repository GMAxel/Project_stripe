<?php
    session_start();
    require_once('classes/Product.php');
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
    <link rel="stylesheet" href="layout/main/licenses.css">
    <link rel="stylesheet" href="layout/nav/nav.css">
    <style type="text/css">
      

    </style>
</head>
<body>
    <?php require_once('layout/nav/nav.php'); ?>   

    <div class="container">
        <h1 class="my-5 text-center">Offers</h1>

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
                                <h2 class='price'> ". ($product->price/100) ." <span class='currency'>kr</span></h2>
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
                                    <a href='license.php?id=".$product->id."' class='btn btn-primary btn-primary'>
                                        Select
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
    </div>

    <?php require_once('layout/footer/footer.php'); ?>      
</body>
</html> 