<?php
    session_start();
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
<?php 
    require_once('layout/nav/nav.php'); 
    if(isset($_GET['id'])):
        $id = $_GET['id'];
?>  
    <h3 class="my-4 text-center">
        <a href="purchase.php?id=<?php echo $id ?>"> Purchase was not successfull, please try again </a>
    </h3>
    <?php else :?>
    <h3 class="my-4 text-center">
        <a href="licenses.php"> Purchase was not successfull, please try again </a>
    </h3>
    <?php endif; ?>
</body>
</html>
