<?php
session_start();
require_once('classes/Customer.php');
require_once('classes/Filehandler.php');


// Instantiate Customer
$customer = new Customer();
// Instantiate filehandler
$filehandler = new Filehandler();
// Open and read file, store values in array.
if (!empty($_FILES['books_file']['tmp_name'])) {
    if(!isset($_SESSION['customer_id'])) {
        $message = "You have to log in to upload";
    } else {
        $books = $filehandler->read_file();
        if(!$books) {
            $message = $filehandler->response;
            $books = null;
        } else {
            $saldo = $customer->remove_license(count($_SESSION['books'])-1);
            if(!$saldo) {
                $message = $customer->response;
                $books = null;
            }
        }
    }
} 

// Ändra innehållet i filen, lagra innehållet i sessionen.  
if(isset($books)) {
    $filehandler->write_file($books);
    $redirect_link = '<a href="upload_csv.php?return">Download file as CSV </a>'; 
}
if(isset($_GET['return'])) {
    $filehandler->upload_edited_file();
    die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="layout/nav/nav.css">
    <title>Ladda upp fil</title>
    <style>
        .form-container input[type="file"]{
            width:400px;
            margin:auto;
        }
        .form-container input[type="file"]{
            border:none;
            margin:auto;
            width:250px;
        }
        .form-container input[type="submit"]{
            width:100px;
            margin:auto;
            margin-top:10px;
        }
        .form-container input[type="submit"]:hover{
            background-color:rgb(255,235,255);
        }
        .product_info {
            min-width:600px;
            max-width:950px;
            margin:auto;
        }

            </style>
</head>
<body>
    <?php require_once('layout/nav/nav.php'); ?>       
    <h1 class="my-4 text-center">Upload your CSV file</h1>
    <?php if (isset($message)) : ?>
    <h5 class="my-4 text-center"><span style="color:red;">Error</span><br><?php echo $message ?></h5>
    <?php endif; ?>

    <div class="form-container">
        <form method="post" enctype="multipart/form-data">
            <input class="form-control" type="file" name="books_file">
            <input class="form-control" type="submit" name="action" value="Upload File">
        </form>
    </div>
    <?php if (isset($books)) : ?>
    <div class="product_info">
        <table class="table table-striped">
                <thead>
                    <tr>
                        <?php foreach($books[0] as $book_header) :?>
                            <th><?php echo $book_header ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 1; $i < count($books[0]); $i++) : ?>
                        <tr>
                            <?php foreach($books[$i] as $val) : ?>
                                <td><?php echo $val ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endfor; ?>
                </tbody>
        </table>
        <a href="upload_csv.php?return">Download file as CSV </a>    
    </div>
<?php endif; ?>
<?php require_once('layout/footer/footer.php'); ?>
</body>
</html>